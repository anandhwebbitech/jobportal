<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVarient;
use App\Models\Size;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $products = Product::with(['category', 'subcategory'])->latest();

            return DataTables::of($products)
                ->addIndexColumn()

                ->addColumn('category', function ($row) {
                    return $row->category->name ?? '-';
                })

                ->addColumn('subcategory', function ($row) {
                    return $row->subcategory->name ?? '-';
                })

                ->editColumn('thumbnail', function ($row) {
                    if (!$row->thumbnail) {
                        return '-';
                    }

                    $url = asset($row->thumbnail);
                    return '<img src="'.$url.'" 
                            style="width:50px;height:50px;object-fit:cover;border-radius:8px;">';
                })

                ->editColumn('status', function ($row) {
                    return $row->status
                        ? '<span class="badge bg-success">Active</span>'
                        : '<span class="badge bg-danger">Inactive</span>';
                })

                ->addColumn('action', function ($row) {
                    return '
                        <div class="d-flex gap-3">
                            <a href="'.route('admin.products.edit', $row->id).'" 
                               class="btn btn-sm btn-primary">
                                <i class="fa fa-edit"></i>
                            </a>
                            <button data-id="'.$row->id.'"
                                data-route="'.route('admin.products.destroy', $row->id).'"
                                class="btn btn-sm btn-danger delete">
                                <i class="fa fa-trash"></i>
                            </button>
                        </div>
                    ';
                })

                ->rawColumns(['thumbnail', 'status', 'action'])
                ->make(true);
        }

        return view('admin.product.index');
    }

    public function create()
    {
        $categories   = Category::where('status', 1)->get();
        $subcategories = SubCategory::where('status', 1)->get();
        $colors       = Color::where('status', 1)->get();
        $sizes        = Size::where('status', 1)->get();

        return view('admin.product.create', compact(
            'categories',
            'subcategories',
            'colors',
            'sizes'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'            => 'required|string|max:255',
            'slug'            => 'required|unique:products,slug',
            'category_id'     => 'required|exists:categories,id',
            'sub_category_id' => 'required|exists:sub_categories,id',
            'base_price'      => 'required|numeric|min:0',
            'discount_price'  => 'nullable|numeric|min:0',
            'stock'           => 'required|integer|min:0',
            'thumbnail'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'images.*'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'colors'          => 'nullable|array',
            'sizes'           => 'nullable|array',
        ]);

        DB::beginTransaction();

        try {

            // ❗ REMOVE colors & sizes from insert (IMPORTANT FIX)
            $data = $request->except([
                'thumbnail',
                'images',
                'variants',
                'colors',
                'sizes'
            ]);

            // Status checkbox fix
            $data['status'] = $request->has('status') ? 1 : 0;

            // Discount Percentage
            if ($request->filled('discount_price') && $request->base_price > 0) {
                $data['discount_percentage'] =
                    (($request->base_price - $request->discount_price) / $request->base_price) * 100;
            }

            // Upload Thumbnail
            if ($request->hasFile('thumbnail')) {
                $file = $request->file('thumbnail');
                $filename = time() . '_thumb.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/products'), $filename);
                $data['thumbnail'] = 'uploads/products/' . $filename;
            }

            // Create Product
            $product = Product::create($data);

            // Save Gallery Images
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $img) {
                    $imgName = time() . '_' . uniqid() . '.' . $img->getClientOriginalExtension();
                    $img->move(public_path('uploads/products'), $imgName);

                    ProductImage::create([
                        'product_id' => $product->id,
                        'image'      => 'uploads/products/' . $imgName,
                    ]);
                }
            }

            // ✅ AUTO CREATE VARIANTS FROM COLORS & SIZES (IF NO MANUAL VARIANTS)
            if ($request->filled('colors') || $request->filled('sizes')) {
                $colors = $request->colors ?? [null];
                $sizes  = $request->sizes ?? [null];

                foreach ($colors as $color) {
                    foreach ($sizes as $size) {
                        ProductVarient::create([
                            'product_id'     => $product->id,
                            'color_id'       => $color,
                            'size_id'        => $size,
                            'price'          => $request->base_price,
                            'discount_price' => $request->discount_price,
                            'stock'          => $request->stock,
                            'status'         => 1,
                        ]);
                    }
                }
            }

            // Manual Variants (if you use dynamic variant rows)
            if ($request->has('variants')) {
                foreach ($request->variants as $variant) {

                    if (empty($variant['price'])) {
                        continue;
                    }

                    ProductVarient::create([
                        'product_id'     => $product->id,
                        'color_id'       => $variant['color_id'] ?? null,
                        'size_id'        => $variant['size_id'] ?? null,
                        'price'          => $variant['price'],
                        'discount_price' => $variant['discount_price'] ?? null,
                        'stock'          => $variant['stock'] ?? 0,
                        'status'         => 1,
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('admin.products.index')
                ->with('success', 'Product created successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function edit($id)
    {
        $product = Product::with(['images', 'varients'])->findOrFail($id);
        $categories = Category::all();
        $colors = Color::all();
        $sizes = Size::all();

        $selectedColorIds = $product->varients->pluck('color_id')->filter()->unique()->toArray();
        $selectedSizeIds  = $product->varients->pluck('size_id')->filter()->unique()->toArray();

        return view('admin.product.edit', compact(
            'product',
            'categories',
            'colors',
            'sizes',
            'selectedColorIds',
            'selectedSizeIds'
        ));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name'            => 'required|string|max:255',
            'slug'            => 'required|unique:products,slug,' . $product->id,
            'category_id'     => 'required|exists:categories,id',
            'sub_category_id' => 'required|exists:sub_categories,id',
            'base_price'      => 'required|numeric|min:0',
            'discount_price'  => 'nullable|numeric|min:0',
            'stock'           => 'required|integer|min:0',
            'thumbnail'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'images.*'        => 'image|mimes:jpg,jpeg,png,webp|max:1024',
            'images'          => 'nullable|array|max:5',
            'colors'          => 'nullable|array',
            'sizes'           => 'nullable|array',
        ]);

        DB::beginTransaction();

        try {
            $data = $request->except([
                'thumbnail',
                'images',
                'colors',
                'sizes',
                'variants'
            ]);

            $data['status'] = $request->has('status') ? 1 : 0;

            if ($request->filled('discount_price') && $request->base_price > 0) {
                $data['discount_percentage'] =
                    (($request->base_price - $request->discount_price) / $request->base_price) * 100;
            } else {
                $data['discount_percentage'] = null;
            }

            if ($request->hasFile('thumbnail')) {

                if ($product->thumbnail && file_exists(public_path($product->thumbnail))) {
                    unlink(public_path($product->thumbnail));
                }

                $file = $request->file('thumbnail');
                $filename = time() . '_thumb.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/products'), $filename);
                $data['thumbnail'] = 'uploads/products/' . $filename;
            }

            $product->update($data);

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $img) {
                    $imgName = time() . '_' . uniqid() . '.' . $img->getClientOriginalExtension();
                    $img->move(public_path('uploads/products'), $imgName);

                    ProductImage::create([
                        'product_id' => $product->id,
                        'image'      => 'uploads/products/' . $imgName,
                    ]);
                }
            }

            ProductVarient::where('product_id', $product->id)->delete();

            $colors = $request->colors ?? [null];
            $sizes  = $request->sizes ?? [null];

            foreach ($colors as $color) {
                foreach ($sizes as $size) {
                    ProductVarient::create([
                        'product_id'     => $product->id,
                        'color_id'       => $color,
                        'size_id'        => $size,
                        'price'          => $request->base_price,
                        'discount_price' => $request->discount_price,
                        'stock'          => $request->stock,
                        'status'         => 1,
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('admin.products.index')
                ->with('success', 'Product updated successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return response()->json([
            'status' => true,
            'message' => 'Product deleted successfully'
        ]);
    }

    // AJAX: Get subcategories by category
    public function getSubcategories($categoryId)
    {
        $subcategories = SubCategory::where('category_id', $categoryId)
            ->where('status', 1)
            ->get();

        return response()->json($subcategories);
    }

    public function deleteImage($id)
    {
        $image = ProductImage::findOrFail($id);

        if ($image->image && file_exists(public_path($image->image))) {
            unlink(public_path($image->image));
        }

        $image->delete();

        return response()->json([
            'success' => true,
            'message' => 'Image deleted successfully'
        ]);
    }
}

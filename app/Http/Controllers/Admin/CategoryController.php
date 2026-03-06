<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $pages = Category::latest();

            return DataTables::of($pages)
                ->addIndexColumn()
                ->filter(function ($query) {
                    if (request()->has('search') && $search = request('search')['value']) {
                        $query->where(function ($q) use ($search) {
                            $q->Where('title', 'like', "%{$search}%")
                            ->orWhere('name', 'like', "%{$search}%")
                            ->orWhere('paragraph', 'like', "%{$search}%")
                            ->orWhere('body_content', 'like', "%{$search}%")
                            ->orWhere('meta_title', 'like', "%{$search}%")
                            ->orWhere('meta_description', 'like', "%{$search}%")
                            ->orWhere('created_at', 'like', "%{$search}%");
                        });
                    }
                })
                ->editColumn('status', function ($row) {
                    return $row->status
                        ? '<span class="badge bg-success">Active</span>'
                        : '<span class="badge bg-danger">Inactive</span>';
                })
                ->editColumn('created_at', function ($row) {
                    return $row->created_at->format('Y-m-d H:i:s');
                })
                ->editColumn('image', function ($row) {
                    if (!$row->image) {
                        return '-';
                    }

                    $url = asset($row->image);

                    return '<img src="'.$url.'" 
                        style="width:50px;height:50px;object-fit:cover;border-radius:50%;border:1px solid #ddd;">';
                })

                ->editColumn('paragraph', function ($row) {
                    $original = $row->paragraph ?? '';
                    $limit = 30;
                    $short = \Illuminate\Support\Str::limit($original, $limit);
                    if (strlen($original) <= $limit) {
                        return '<span>'.e($original).'</span>';
                    }
                    return '
                        <span>'.e($short).'</span>
                        <a href="javascript:void(0)"
                        class="text-primary viewMessage ms-1"
                        data-message="'.e($original).'">
                            <i class="fa fa-eye"></i>
                        </a>';
                })
                ->addColumn('action', function ($row) {
                    return '
                        <div class="d-flex gap-3">
                            <a href="'.route('admin.categories.edit', $row->id).'" class="btn btn-sm btn-primary" title="Edit">
                                <i class="fa fa-edit"></i>
                            </a>
                            <button data-id="'.$row->id.'"
                                data-table-id="service-table"
                                data-route="'.route('admin.categories.destroy', $row->id).'" 
                                class="btn btn-sm btn-danger delete" title="Delete">
                                <i class="fa fa-trash"></i>
                            </button>
                        </div>
                    ';
                })
                ->rawColumns(['status','action','created_at','paragraph','image'])
                ->make(true);
        }
        return view('admin.category.index');
    }

    public function create()
    {
        $parents = Category::whereNull('parent_id')->get();
        return view('admin.category.create', compact('parents'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'slug'        => 'nullable|string|max:255|unique:categories,slug',
            'parent_id'   => 'nullable|exists:categories,id',
            'status'      => 'nullable|boolean',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'name.required' => 'Category name is required.',
            'slug.unique'   => 'This slug already exists. Please use a different name.',
            'image.image'   => 'Please upload a valid image file.',
        ]);

        $data = $request->only([
            'name',
            'slug',
            'parent_id',
            'description'
        ]);

        $slug = $request->slug ?: Str::slug($request->name);

        $originalSlug = $slug;
        $count = 1;
        while (Category::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }
        $data['slug'] = $slug;

        $data['status'] = $request->has('status') ? 1 : 0;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . $slug . '.' . $image->getClientOriginalExtension();

            $destination = public_path('uploads/categories');
            if (!file_exists($destination)) {
                mkdir($destination, 0755, true);
            }

            $image->move($destination, $filename);
            $data['image'] = 'uploads/categories/' . $filename;
        }

        Category::create($data);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category created successfully.');
    }

    public function show(Category $category)
    {
        return view('admin.category.show', compact('category'));
    }

    public function edit(Category $category)
    {
        $parents = Category::whereNull('parent_id')
                    ->where('id', '!=', $category->id)
                    ->get();

        return view('admin.category.edit', compact('category', 'parents'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'slug'        => 'nullable|string|max:255|unique:categories,slug,' . $category->id,
            'parent_id'   => 'nullable|exists:categories,id',
            'status'      => 'nullable|boolean',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'name.required' => 'Category name is required.',
            'slug.unique'   => 'This slug already exists. Please use a different name.',
        ]);

        $data = $request->only([
            'name',
            'slug',
            'parent_id',
            'description'
        ]);

        $slug = $request->slug ?: Str::slug($request->name);

        $originalSlug = $slug;
        $count = 1;
        while (
            Category::where('slug', $slug)
                ->where('id', '!=', $category->id)
                ->exists()
        ) {
            $slug = $originalSlug . '-' . $count++;
        }

        $data['slug'] = $slug;

        $data['status'] = $request->has('status') ? 1 : 0;

        if ($request->hasFile('image')) {
            if ($category->image && file_exists(public_path($category->image))) {
                unlink(public_path($category->image));
            }

            $image = $request->file('image');
            $filename = time() . '_' . $slug . '.' . $image->getClientOriginalExtension();

            $destination = public_path('uploads/categories');
            if (!file_exists($destination)) {
                mkdir($destination, 0755, true);
            }

            $image->move($destination, $filename);
            $data['image'] = 'uploads/categories/' . $filename;
        }

        $category->update($data);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return response()->json([
            'status' => true,
            'message' => 'Category deleted successfully',
        ]);
    }

    // public function trashed()
    // {
    //     $categories = Category::onlyTrashed()->get();
    //     return view('admin.category.trashed', compact('categories'));
    // }

    public function restore($id)
    {
        Category::withTrashed()->findOrFail($id)->restore();
        return redirect()->route('admin.category.index')
            ->with('success', 'Category restored successfully');
    }

    public function forceDelete($id)
    {
        Category::withTrashed()->findOrFail($id)->forceDelete();
        return redirect()->route('admin.category.index')
            ->with('success', 'Category permanently deleted');
    }
}

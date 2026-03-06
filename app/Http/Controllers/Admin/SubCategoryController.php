<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class SubCategoryController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = SubCategory::with('category')->latest();

            return DataTables::of($data)
                ->addIndexColumn()

                ->filter(function ($query) {
                    if ($search = request('search')['value'] ?? null) {
                        $query->where('name', 'LIKE', "%{$search}%")
                            ->orWhereHas('category', function ($q) use ($search) {
                                $q->where('name', 'LIKE', "%{$search}%");
                            });
                    }
                })

                ->addColumn('category', function ($row) {
                    return $row->category?->name ?? '-';
                })

                ->editColumn('status', function ($row) {
                    return $row->status
                        ? '<span class="badge bg-success">Active</span>'
                        : '<span class="badge bg-danger">Inactive</span>';
                })

                ->editColumn('image', function ($row) {
                    if (!$row->image) return '-';
                    return '<img src="'.asset($row->image).'" width="50" height="50" style="border-radius:6px;">';
                })

                ->addColumn('action', function ($row) {
                    return '
                        <a href="'.route('admin.subcategories.edit',$row->id).'" class="btn btn-sm btn-primary">
                            <i class="fa fa-edit"></i>
                        </a>
                        <button data-id="'.$row->id.'" 
                            data-route="'.route('admin.subcategories.destroy',$row->id).'" 
                            class="btn btn-sm btn-danger delete">
                            <i class="fa fa-trash"></i>
                        </button>
                    ';
                })

                ->rawColumns(['status','action','image'])
                ->make(true);
        }

        return view('admin.subcategory.index');
    }

    public function create()
    {
        $categories = Category::where('status',1)->get();
        return view('admin.subcategory.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|max:255',
            'slug' => 'nullable|unique:sub_categories,slug',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = $request->only(['category_id','name','description']);

        $slug = $request->slug ?: Str::slug($request->name);
        $original = $slug;
        $count = 1;

        while (SubCategory::where('slug',$slug)->exists()) {
            $slug = $original.'-'.$count++;
        }

        $data['slug'] = $slug;
        $data['status'] = $request->has('status') ? 1 : 0;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time().'_'.$slug.'.'.$image->getClientOriginalExtension();
            $image->move(public_path('uploads/subcategories'), $filename);
            $data['image'] = 'uploads/subcategories/'.$filename;
        }

        SubCategory::create($data);

        return redirect()->route('admin.subcategories.index')
            ->with('success','SubCategory created successfully');
    }

    public function edit(SubCategory $subcategory)
    {
        $categories = Category::where('status',1)->get();
        return view('admin.subcategory.edit', compact('subcategory','categories'));
    }

    public function update(Request $request, SubCategory $subcategory)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|max:255',
            'slug' => 'nullable|unique:sub_categories,slug,'.$subcategory->id,
        ]);

        $data = $request->only(['category_id','name','description']);

        $slug = $request->slug ?: Str::slug($request->name);
        $data['slug'] = $slug;
        $data['status'] = $request->has('status') ? 1 : 0;

        if ($request->hasFile('image')) {
            if ($subcategory->image && file_exists(public_path($subcategory->image))) {
                unlink(public_path($subcategory->image));
            }

            $image = $request->file('image');
            $filename = time().'_'.$slug.'.'.$image->getClientOriginalExtension();
            $image->move(public_path('uploads/subcategories'), $filename);
            $data['image'] = 'uploads/subcategories/'.$filename;
        }

        $subcategory->update($data);

        return redirect()->route('admin.subcategories.index')
            ->with('success','SubCategory updated successfully');
    }

    public function destroy(SubCategory $subcategory)
    {
        $subcategory->delete();
        return response()->json([
            'status' => true,
            'message' => 'SubCategory deleted successfully'
        ]);
    }
}

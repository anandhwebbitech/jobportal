<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Size;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class SizeController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $pages = Size::latest();

            return DataTables::of($pages)
                ->addIndexColumn()
                ->filter(function ($query) {
                    if (request()->has('search') && $search = request('search')['value']) {
                        $query->where(function ($q) use ($search) {
                            $q->Where('value', 'like', "%{$search}%")
                            ->orWhere('name', 'like', "%{$search}%")
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

                ->addColumn('action', function ($row) {
                    return '
                        <div class="d-flex gap-3">
                            <a href="javascript:void(0);" data-title="Edit Plan" data-size="modal-lg"
                            data-route="'. route('admin.sizes.edit',$row->id) .'" class="btn btn-sm btn-primary common_model" title="Edit">
                                <i class="fa fa-edit"></i>
                            </a>
                            <button data-id="'.$row->id.'"
                                data-table-id="size-table"
                                data-route="'.route('admin.sizes.destroy', $row->id).'" 
                                class="btn btn-sm btn-danger delete" title="Delete">
                                <i class="fa fa-trash"></i>
                            </button>
                        </div>
                    ';
                })
                ->rawColumns(['status','action','created_at','paragraph','image'])
                ->make(true);
        }
        return view('admin.sizes.index');
    }

    public function create()
    {
        $html = view('admin.sizes.create')->render();

        return response()->json([
            'html' => $html
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'value' => 'nullable|string'
        ],[
            'name.required' => 'Size name is required.',
            'name.unique' => 'This color already exists.'
        ]);

        Size::create($request->all());

        return redirect()->route('admin.sizes.index')
            ->with('success', 'Size created successfully.');
    }

    public function edit(Size $size)
    {
        if (!$size) {
            return response()->json([
                'success' => false,
                'error'   => 'Size not found'
            ]);
        }

        $html = view('admin.sizes.edit', compact('size'))->render();

        return response()->json([
            'success' => true,
            'html'    => $html
        ]);
    }

    public function update(Request $request, Size $size)
    {
        $validated = $request->validate([
            'name'   => 'required|string|max:100',
            'value'   => 'nullable|string|max:20',
            'status' => 'required|boolean',
        ], [
            'name.required' => 'Size name is required.',
            'name.unique'   => 'This color name already exists.',
        ]);

        // Update only needed fields (safe)
        $size->update([
            'name'   => $validated['name'],
            'value'   => $validated['value'] ?? null,
            'status' => $validated['status'],
        ]);

        return redirect()->route('admin.sizes.index')
            ->with('success', 'Size updated successfully.');
    }

    public function destroy(Size $size)
    {
        $size->delete();
        return response()->json([
                'status'  => true,
                'message' => 'Size deleted successfully.'
            ]);
    }
}

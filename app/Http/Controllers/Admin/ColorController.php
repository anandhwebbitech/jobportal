<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Color;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ColorController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $pages = Color::latest();

            return DataTables::of($pages)
                ->addIndexColumn()
                ->filter(function ($query) {
                    if (request()->has('search') && $search = request('search')['value']) {
                        $query->where(function ($q) use ($search) {
                            $q->Where('code', 'like', "%{$search}%")
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
                            data-route="'. route('admin.colors.edit',$row->id) .'" class="btn btn-sm btn-primary common_model" title="Edit">
                                <i class="fa fa-edit"></i>
                            </a>
                            <button data-id="'.$row->id.'"
                                data-table-id="color-table"
                                data-route="'.route('admin.colors.destroy', $row->id).'" 
                                class="btn btn-sm btn-danger delete" title="Delete">
                                <i class="fa fa-trash"></i>
                            </button>
                        </div>
                    ';
                })
                ->rawColumns(['status','action','created_at','paragraph','image'])
                ->make(true);
        }
        return view('admin.colors.index');
    }

    public function create()
    {
        $html = view('admin.colors.create')->render();

        return response()->json([
            'html' => $html
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'code' => 'nullable|string'
        ],[
            'name.required' => 'Color name is required.',
            'name.unique' => 'This color already exists.'
        ]);

        Color::create($request->all());

        return redirect()->route('admin.colors.index')
            ->with('success', 'Color created successfully.');
    }

    public function edit(Color $color)
    {
        if (!$color) {
            return response()->json([
                'success' => false,
                'error'   => 'Color not found'
            ]);
        }

        $html = view('admin.colors.edit', compact('color'))->render();

        return response()->json([
            'success' => true,
            'html'    => $html
        ]);
    }

    public function update(Request $request, Color $color)
    {
        $validated = $request->validate([
            'name'   => 'required|string|max:100',
            'code'   => 'nullable|string|max:20',
            'status' => 'required|boolean',
        ], [
            'name.required' => 'Color name is required.',
            'name.unique'   => 'This color name already exists.',
        ]);

        // Update only needed fields (safe)
        $color->update([
            'name'   => $validated['name'],
            'code'   => $validated['code'] ?? null,
            'status' => $validated['status'],
        ]);

        return redirect()->route('admin.colors.index')
            ->with('success', 'Color updated successfully.');
    }

    public function destroy(Color $color)
    {
        $color->delete();
        return response()->json([
                'status'  => true,
                'message' => 'Color deleted successfully.'
            ]);
    }
}

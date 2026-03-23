<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use Illuminate\Queue\Middleware\Skip;
use Illuminate\Support\Facades\Validator;

class SkillController extends Controller
{
    //
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $pages = Skill::latest();

            return DataTables::of($pages)
                ->addIndexColumn()
                ->filter(function ($query) {
                    if (request()->has('search') && $search = request('search')['value']) {
                        $query->where(function ($q) use ($search) {
                            $q->Where('skill_name', 'like', "%{$search}%")
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
                            data-route="'. route('admin.skills.edit',$row->id) .'" class="btn btn-sm btn-primary common_model" title="Edit">
                                <i class="fa fa-edit"></i>
                            </a>
                            <button data-id="'.$row->id.'"
                                data-table-id="skill-table"
                                data-route="'.route('admin.skills.destroy', $row->id).'" 
                                class="btn btn-sm btn-danger delete" title="Delete">
                                <i class="fa fa-trash"></i>
                            </button>
                        </div>
                    ';
                })
                ->rawColumns(['status','action','created_at','paragraph','image'])
                ->make(true);
        }
        return view('admin.skills.index');
    }

    public function create()
    {
        $html = view('admin.skills.create')->render();

        return response()->json([
            'html' => $html
        ]);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'skill_name'  => 'required|string|max:255|unique:skills,skill_name',
            'description' => 'nullable|string|max:500',
            'status'      => 'required|in:0,1',
        ],[
            'skill_name.required' => 'Skill name is required.',
            'skill_name.unique'   => 'This skill already exists.',
            'status.required'     => 'Status is required.'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        Skill::create([
            'skill_name' => $request->skill_name,
            'description' => $request->description,
            'status' => $request->status
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Skill created successfully'
        ]);
    }
    public function edit(Skill $skill)
    {
        if (!$skill) {
            return response()->json([
                'success' => false,
                'error'   => 'Skill not found'
            ]);
        }
        $html = view('admin.skills.edit', compact('skill'))->render();

        return response()->json([
            'success' => true,
            'html'    => $html
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'skill_name' => 'required|max:255|unique:skills,skill_name,'.$id,
            'description' => 'nullable|max:500'
        ]);

        $skill = Skill::findOrFail($id);

        $skill->update([
            'skill_name' => $request->skill_name,
            'description' => $request->description,
            'status' => $request->status
        ]);

        return redirect()->route('admin.skills.index')
                ->with('success','Skill updated successfully');
    }

    public function destroy(Skill $skill)
    {
        $skill->delete();
        return response()->json([
                'status'  => true,
                'message' => 'Skill deleted successfully.'
            ]);
    }
}

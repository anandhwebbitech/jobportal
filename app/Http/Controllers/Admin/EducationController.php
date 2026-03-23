<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Education;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class EducationController extends Controller
{
    //
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $educations = Education::query();

            return DataTables::of($educations)
                ->addIndexColumn()

                ->filter(function ($query) {

                    if (request()->has('search') && $search = request('search')['value']) {

                        $query->where(function ($q) use ($search) {

                            $q->where('level_of_education', 'like', "%{$search}%")
                                ->orWhere('field_of_study', 'like', "%{$search}%")
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

                            <a href="javascript:void(0);" 
                            data-title="Edit Education" 
                            data-size="modal-lg"
                            data-route="' . route('admin.educations.edit', $row->id) . '"
                            class="btn btn-sm btn-primary common_model" 
                            title="Edit">

                                <i class="fa fa-edit"></i>

                            </a>

                            <button data-id="' . $row->id . '"
                                data-table-id="education-table"
                                data-route="' . route('admin.educations.destroy', $row->id) . '" 
                                class="btn btn-sm btn-danger delete"
                                title="Delete">

                                <i class="fa fa-trash"></i>

                            </button>

                        </div>
                    ';
                })

                ->rawColumns(['status', 'action', 'created_at'])
                ->make(true);
        }

        return view('admin.education.index');
    }


    public function create()
    {
        $html = view('admin.education.create')->render();

        return response()->json([
            'html' => $html
        ]);
    }


    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [

            'level_of_education' => 'required|string|max:255',
            'field_of_study' => 'required|string|max:255',
            'status' => 'required|in:0,1',

        ], [

            'level_of_education.required' => 'Level of education is required.',
            'field_of_study.required' => 'Field of study is required.',
            'status.required' => 'Status is required.'

        ]);

        if ($validator->fails()) {

            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        Education::create([

            'level_of_education' => $request->level_of_education,
            'field_of_study' => $request->field_of_study,
            'status' => $request->status

        ]);

        return response()->json([

            'status' => true,
            'message' => 'Education created successfully'

        ]);
    }


    public function edit(Education $education)
    {

        if (!$education) {

            return response()->json([
                'success' => false,
                'error'   => 'Education not found'
            ]);
        }

        $html = view('admin.education.edit', compact('education'))->render();

        return response()->json([
            'success' => true,
            'html' => $html
        ]);
    }


    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [

            'level_of_education' => 'required|string|max:255',
            'field_of_study' => 'required|string|max:255',
            'status' => 'required|in:0,1',
        ], [
            'level_of_education.required' => 'Level of education is required.',
            'field_of_study.required' => 'Field of study is required.'
        ]);

        if ($validator->fails()) {

            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $education = Education::findOrFail($id);

        $education->update([

            'level_of_education' => $request->level_of_education,
            'field_of_study' => $request->field_of_study,
            'status' => $request->status

        ]);

        return response()->json([

            'status' => true,
            'message' => 'Education updated successfully'
        ]);
    }


    public function destroy(Education $education)
    {

        $education->delete();

        return response()->json([

            'status'  => true,
            'message' => 'Education deleted successfully.'

        ]);
    }
}

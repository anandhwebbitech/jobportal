<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employer;
use App\Models\EmployerDetail;
use App\Models\Job;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;


class JobController extends Controller
{
    //
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $jobs = Job::query();

            return DataTables::of($jobs)
                ->addIndexColumn()
                ->editColumn('status', function ($row) {

                    switch ($row->admin_status) {
                        case 0:
                            return '<span class="badge bg-warning">wating for approve</span>';
                        case 1:
                            return '<span class="badge bg-success">Approved</span>';
                        case 2:
                            return '<span class="badge bg-info">Re-Submit</span>';
                        case 3:
                            return '<span class="badge bg-danger">Rejected</span>';
                        default:
                            return '<span class="badge bg-secondary">Unknown</span>';
                    }
                })               
                ->addColumn('action', function ($row) {

                    return '
                        <div class="d-flex gap-2 align-items-center">

                            <button 
                                data-id="'.$row->id.'"
                                class="btn btn-sm btn-info viewjob"
                                title="View">
                                <i class="fa fa-eye"></i>
                            </button>
                        </div>
                    ';
                    // <button data-id="' . $row->id . '"
                    //     data-table-id="employers-table"
                    //     data-route="' . route('admin.employers.destroy', $row->id) . '" 
                    //     class="btn btn-sm btn-danger delete"
                    //     title="Delete">
                    //     <i class="fa fa-trash"></i>
                    // </button>
                })

                ->rawColumns(['status', 'action'])
                ->make(true);
        }
        return view('admin.job.index');
    }

    public function show($id)
    {
        $job = Job::findOrFail($id);
       
        return response()->json($job);
    }
    public function approve(Request $request, $id)
    {
        $job = Job::find($id);

        if (!$job) {
            return response()->json([
                'status' => false,
                'message' => 'Job not found'
            ]);
        }

        $job->admin_status = $request->status;

        if ($request->admin_status == 3) {
            $job->old = $request->reject_message;
        }

        $job->save();

        return response()->json([
            'status' => true,
            'message' => 'Job status updated successfully'
        ]);
    }
}

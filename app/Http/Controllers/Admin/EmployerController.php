<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employer;
use App\Models\EmployerDetail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;


class EmployerController extends Controller
{
    //
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $employer = User::with('employerDetails')
                ->where('role', 'employer');

            return DataTables::of($employer)
                ->addIndexColumn()

                ->filter(function ($query) {

                    if (request()->has('search') && $search = request('search')['value']) {

                        $query->where(function ($q) use ($search) {

                            $q->where('users.email', 'like', "%{$search}%")
                                ->orWhereHas('employerDetails', function ($q2) use ($search) {
                                    $q2->where('company_name', 'like', "%{$search}%")
                                    ->orWhere('owner_name', 'like', "%{$search}%")
                                    ->orWhere('owner_mobile', 'like', "%{$search}%")
                                    ->orWhere('pan_number', 'like', "%{$search}%");
                                });

                        });
                    }
                })

                ->editColumn('status', function ($row) {

                    switch ($row->is_active) {
                        case 0:
                            return '<span class="badge bg-warning">Pending</span>';
                        case 1:
                            return '<span class="badge bg-success">Approved</span>';
                        case 3:
                            return '<span class="badge bg-danger">Rejected</span>';
                        default:
                            return '<span class="badge bg-secondary">Unknown</span>';
                    }
                })

                ->addColumn('company_name', function ($row) {
                    return $row->employerDetails->company_name ?? '-';
                })

                ->addColumn('owner_name', function ($row) {
                    return $row->employerDetails->owner_name ?? '-';
                })

                ->addColumn('mobile', function ($row) {
                    return $row->employerDetails->owner_mobile ?? '-';
                })
                ->addColumn('gst', function ($row) {
                    return $row->employerDetails->gst_number ?? '-';
                })
                ->addColumn('pan', function ($row) {
                    return $row->employerDetails->pan_number ?? '-';
                })

                ->addColumn('action', function ($row) {

                    $statusDropdown = '
                        <select class="form-select form-select-sm changeStatus" 
                            data-id="'.$row->id.'" style="width:120px">

                            <option value="0" '.($row->is_active == 0 ? 'selected' : '').'>Pending</option>
                            <option value="1" '.($row->is_active == 1 ? 'selected' : '').'>Approved</option>
                            <option value="3" '.($row->is_active == 3 ? 'selected' : '').'>Rejected</option>

                        </select>
                    ';

                    return '
                        <div class="d-flex gap-2 align-items-center">

                            <button 
                                data-id="'.$row->id.'"
                                class="btn btn-sm btn-info viewEmployer"
                                title="View">
                                <i class="fa fa-eye"></i>
                            </button>

                            '.$statusDropdown.'

                            <button data-id="' . $row->id . '"
                                data-table-id="employers-table"
                                data-route="' . route('admin.employers.destroy', $row->id) . '" 
                                class="btn btn-sm btn-danger delete"
                                title="Delete">
                                <i class="fa fa-trash"></i>
                            </button>

                        </div>
                    ';
                })

                ->rawColumns(['status', 'action'])
                ->make(true);
        }
        return view('admin.employer.index');
    }

    public function show($id)
    {
        $employer = User::with('employerDetails')->findOrFail($id);
        $employer->created_at_formatted = $employer->created_at 
        ? $employer->created_at->format('d M Y h:i A') 
        : '-';
        return response()->json($employer);
    }

    public function approve(Request $request, $id)
    {
        $employer = User::find($id);

        if (!$employer) {
            return response()->json([
                'status' => false,
                'message' => 'Employer not found'
            ]);
        }

        $employer->is_active = $request->status;

        if ($request->is_active == 3) {
            $employer->reject_message = $request->reject_message;
        }

        $employer->save();

        return response()->json([
            'status' => true,
            'message' => 'Employer status updated successfully'
        ]);
    }
}

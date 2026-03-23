<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;


class EmployerController extends Controller
{
    //
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $educations = Employer::latest();
            // dd($educations->get());

            return DataTables::of($educations)
                ->addIndexColumn()

                ->filter(function ($query) {

                    if (request()->has('search') && $search = request('search')['value']) {

                        $query->where(function ($q) use ($search) {

                            $q->where('company_name', 'like', "%{$search}%")
                            ->orWhere('owner_name', 'like', "%{$search}%")
                            ->orWhere('contact_number', 'like', "%{$search}%")
                            ->orWhere('pan_number', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");

                        });

                    }

                })

                ->editColumn('status', function ($row) {

                    switch ($row->status) {
                        case 1:
                            return '<span class="badge bg-warning">Pending</span>';
                        case 2:
                            return '<span class="badge bg-info">Waiting</span>';
                        case 3:
                            return '<span class="badge bg-success">Approved</span>';
                        case 4:
                            return '<span class="badge bg-danger">Rejected</span>';
                        default:
                            return '<span class="badge bg-secondary">Unknown</span>';
                    }

                })

                ->addColumn('action', function ($row) {

                    $statusDropdown = '
                        <select class="form-select form-select-sm changeStatus" 
                            data-id="'.$row->id.'" style="width:120px">

                            <option value="1" '.($row->status == 1 ? 'selected' : '').'>Pending</option>
                            <option value="2" '.($row->status == 2 ? 'selected' : '').'>Waiting</option>
                            <option value="3" '.($row->status == 3 ? 'selected' : '').'>Approved</option>
                            <option value="4" '.($row->status == 4 ? 'selected' : '').'>Rejected</option>

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
        $employer = Employer::findOrFail($id);
        $employer->created_at_formatted = $employer->created_at 
        ? $employer->created_at->format('d M Y h:i A') 
        : '-';
        return response()->json($employer);
    }

    public function approve(Request $request, $id)
    {
        $employer = Employer::find($id);

        if (!$employer) {
            return response()->json([
                'status' => false,
                'message' => 'Employer not found'
            ]);
        }

        $employer->status = $request->status;

        if ($request->status == 'rejected') {
            $employer->message = $request->reject_message;
        }

        $employer->save();

        return response()->json([
            'status' => true,
            'message' => 'Employer status updated successfully'
        ]);
    }
}

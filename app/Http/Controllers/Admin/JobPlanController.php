<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JobPlan;
use Yajra\DataTables\DataTables;

class JobPlanController extends Controller
{
    //
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $plans = JobPlan::query();

            return DataTables::of($plans)
                ->addIndexColumn()
                ->filter(function ($query) use ($request) {
                    if ($search = $request->input('search.value')) {
                        $query->where('name', 'like', "%{$search}%")
                              ->orWhere('created_at', 'like', "%{$search}%");
                    }
                })
                ->editColumn('status', function ($row) {
                    return $row->is_active
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
                                data-id="'.$row->id.'"
                                data-edit-url="'.route('admin.plans.edit', $row->id).'"
                                data-update-url="'.route('admin.plans.update', $row->id).'"
                                class="btn btn-sm btn-primary editPlan">
                                <i class="fa fa-edit"></i>
                            </a>

                            <button data-id="'.$row->id.'"
                                data-table-id="plan-table"
                                data-route="'.route('admin.plans.destroy', $row->id).'" 
                                class="btn btn-sm btn-danger delete" title="Delete">
                                <i class="fa fa-trash"></i>
                            </button>
                        </div>
                    ';
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }

        return view('admin.plans.postjobindex');
    }

    // Store a new plan
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'duration_days' => 'required|integer|min:1',
            'price' => 'required|numeric',
        ]);

        $validated['gst_amount'] = $validated['price'] * 0.18;
        $validated['total_price'] = $validated['price'] + $validated['gst_amount'];

        JobPlan::create(array_merge($validated, [
            'job_post_limit' => $request->job_post_limit ?? 1,
            'applicant_management' => $request->has('applicant_management'),
            'email_notifications' => $request->has('email_notifications'),
            'tamil_nadu_reach' => $request->has('tamil_nadu_reach'),
            'featured_listing' => $request->has('featured_listing'),
            'priority_support' => $request->has('priority_support'),
            'is_active' => $request->is_active,
        ]));

        return response()->json([
            'status' => true,
            'message' => 'Job Plan Created Successfully'
        ]);
    }

    // Get a plan for editing
    public function edit($id)
    {
        $plan = JobPlan::findOrFail($id);
        return response()->json($plan);
    }

    // Update an existing plan
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'duration_days' => 'required|integer|min:1',
            'price' => 'required|numeric',
            'job_post_limit' => 'required|integer|min:1',
        ]);

        $plan = JobPlan::findOrFail($id);

        $plan->update(array_merge($validated, [
            'is_active' => $request->is_active,
            'applicant_management' => $request->has('applicant_management'),
            'email_notifications' => $request->has('email_notifications'),
            'tamil_nadu_reach' => $request->has('tamil_nadu_reach'),
            'featured_listing' => $request->has('featured_listing'),
            'priority_support' => $request->has('priority_support'),
            'gst_amount' => $request->gst_amount ?? ($request->price * 0.18),
            'total_price' => $request->total_price ?? ($request->price * 1.18),
        ]));

        return response()->json([
            'status' => true,
            'message' => 'Plan updated successfully!'
        ]);
    }

    // Delete a plan
    public function destroy(JobPlan $plan)
    {
        $plan->delete();
        return response()->json([
            'status'  => true,
            'message' => 'Plan deleted successfully.'
        ]);
    }

}

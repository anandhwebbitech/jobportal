<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BannerPlan;
use App\Models\BannerPlanSubscription;
use Illuminate\Http\Request;
use App\Models\JobPlan;
use App\Models\ResumePlan;
use App\Models\ResumePlanSubscription;
use Yajra\DataTables\DataTables;
use App\Models\UserPlanSubscription;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

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
   public function resumeindex(Request $request)
    {
        if ($request->ajax()) {

            $plans = ResumePlan::latest()->get();

            return datatables()->of($plans)
                ->addIndexColumn()

                ->addColumn('price_html', function ($row) {
                    return "₹{$row->price}<br>
                        <small class='text-success'>GST: ₹{$row->gst_amount}</small><br>
                        <strong>₹{$row->total_price}</strong>";
                })

                ->addColumn('status_html', function ($row) {
                    return $row->is_active
                        ? '<span class="badge bg-success">Active</span>'
                        : '<span class="badge bg-danger">Inactive</span>';
                })

                ->addColumn('action', function ($row) {
                    return '
                        <button class="btn btn-sm btn-warning editPlan"
                            data-edit="'.route('admin.resumeplans.edit',$row->id).'">
                            Edit
                        </button>

                        <button class="btn btn-sm btn-danger deletePlan"
                            data-id="'.$row->id.'">
                            Delete
                        </button>
                    ';
                })

                ->rawColumns(['price_html','status_html','action'])
                ->make(true);
        }

        return view('admin.plans.resumedownloadplanindex');
    }


    // STORE
    public function Resumestore(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'downloads_limit' => 'required|numeric',
            'valid_days' => 'required|numeric',
        ]);

        ResumePlan::create([
            'name' => $request->name,
            'price' => $request->price,
            'gst_amount' => $request->gst_amount,
            'total_price' => $request->total_price,
            'downloads_limit' => $request->downloads_limit,
            'valid_days' => $request->valid_days,
            'features' => $request->features ?? [], // ✅ FIX
            'is_active' => $request->is_active ?? 1
        ]);

        return response()->json(['message' => 'Plan Created Successfully']);
    }


    // EDIT
    public function Resumeedit($id)
    {
        $plan = ResumePlan::findOrFail($id);

        return response()->json([
            'id' => $plan->id,
            'name' => $plan->name,
            'price' => $plan->price,
            'gst_amount' => $plan->gst_amount,
            'total_price' => $plan->total_price,
            'downloads_limit' => $plan->downloads_limit,
            'valid_days' => $plan->valid_days,
            'features' => $plan->features, // ✅ already array
            'is_active' => $plan->is_active,
        ]);
    }


    // UPDATE
    public function Resumeupdate(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
        ]);

        $plan = ResumePlan::findOrFail($id);

        $plan->update([
            'name' => $request->name,
            'price' => $request->price,
            'gst_amount' => $request->gst_amount,
            'total_price' => $request->total_price,
            'downloads_limit' => $request->downloads_limit,
            'valid_days' => $request->valid_days,
            'features' => $request->features ?? [], // ✅ FIX
            'is_active' => $request->is_active
        ]);

        return response()->json(['message' => 'Plan Updated Successfully']);
    }
    public function Resumedestroy($id)
    {
        try {
            $plan = ResumePlan::findOrFail($id);

            $plan->delete();

            return response()->json([
                'status' => true,
                'message' => 'Resume Plan Deleted Successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong'
            ], 500);
        }
    }

    public function BannerAdindex(Request $request)
    {
        if ($request->ajax()) {

            $plans = BannerPlan::latest()->get();

            return datatables()->of($plans)
                ->addIndexColumn()

                ->addColumn('price_html', function ($row) {
                    return "₹{$row->price}<br>
                        <small>GST: ₹{$row->gst_amount}</small><br>
                        <strong>₹{$row->total_price}</strong>";
                })

                ->addColumn('status_html', function ($row) {
                    return $row->is_active
                        ? '<span class="badge bg-success">Active</span>'
                        : '<span class="badge bg-danger">Inactive</span>';
                })

                ->addColumn('action', function ($row) {
                    return '
                        <button class="btn btn-sm btn-warning editPlan"
                            data-edit="'.route('admin.bannerplans.edit',$row->id).'">
                            Edit
                        </button>

                        <button class="btn btn-sm btn-danger deletePlan"
                            data-id="'.$row->id.'">
                            Delete
                        </button>
                    ';
                })

                ->rawColumns(['price_html','status_html','action'])
                ->make(true);
        }

        return view('admin.plans.banneradplanindex');
    }


    // ==============================
    // STORE
    // ==============================
    public function BannerAdstore(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'duration_days' => 'required|numeric',
        ]);

        BannerPlan::create([
            'name' => $request->name,
            'placement' => $request->placement,
            'price' => $request->price,
            'gst_amount' => $request->gst_amount,
            'total_price' => $request->total_price,
            'duration_days' => $request->duration_days,
            'features' => $request->features ?? [],
            'is_active' => $request->is_active ?? 1,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Banner Plan Created Successfully'
        ]);
    }


    // ==============================
    // EDIT (FETCH SINGLE)
    // ==============================
    public function BannerAdedit($id)
    {
        $plan = BannerPlan::findOrFail($id);

        return response()->json([
            'id' => $plan->id,
            'name' => $plan->name,
            'placement' => $plan->placement,
            'price' => $plan->price,
            'gst_amount' => $plan->gst_amount,
            'total_price' => $plan->total_price,
            'duration_days' => $plan->duration_days,
            'features' => $plan->features, // already array
            'is_active' => $plan->is_active,
        ]);
    }


    // ==============================
    // UPDATE
    // ==============================
    public function BannerAdupdate(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
        ]);

        $plan = BannerPlan::findOrFail($id);

        $plan->update([
            'name' => $request->name,
            'placement' => $request->placement,
            'price' => $request->price,
            'gst_amount' => $request->gst_amount,
            'total_price' => $request->total_price,
            'duration_days' => $request->duration_days,
            'features' => $request->features ?? [],
            'is_active' => $request->is_active,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Banner Plan Updated Successfully'
        ]);
    }


    // ==============================
    // DELETE
    // ==============================
    public function BannerAddestroy($id)
    {
        $plan = BannerPlan::findOrFail($id);
        $plan->delete();

        return response()->json([
            'status' => true,
            'message' => 'Banner Plan Deleted Successfully'
        ]);
    }

    public function buyPlan(Request $request)
    {
        $request->validate([
            'plan_id' => 'required|exists:job_plans,id'
        ]);

        $user = Auth::user();

        // 🔍 Get plan
        $plan = JobPlan::findOrFail($request->plan_id);

        // ❗ Deactivate old plans (optional but recommended)
        UserPlanSubscription::where('user_id', $user->id)
            ->where('status', 1)
            ->update(['status' => 0]);

        // ✅ Create new subscription
        $subscription = UserPlanSubscription::create([
            'user_id'        => $user->id,
            'job_plan_id'    => $plan->id,
            'start_date'     => now(),
            'end_date'       => now()->addDays($plan->duration_days),
            'jobs_used'      => 0,
            'job_post_limit' => $plan->job_post_limit,
            'payment_id'     => 'TEST_' . rand(10000,99999), // temp
            'payment_status' => 'paid',
            'status'         => 1
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'Plan purchased successfully',
            'data'    => $subscription
        ]);
    }


    /* ===============================
       GET ACTIVE PLAN
    =============================== */
    public function activePlan()
    {
        $plan = UserPlanSubscription::where('user_id', Auth::id())
            ->where('status', 1)
            ->whereDate('end_date', '>=', now())
            ->latest()
            ->first();

        return $plan;
    }

    public function buyResumePlan(Request $request)
    {
         try {

            $request->validate([
                'plan_id' => 'required|exists:resume_plans,id'
            ]);

            $user = auth()->user();

            $plan = ResumePlan::findOrFail($request->plan_id);

            // ❌ Already active plan check
            $existing = ResumePlanSubscription::where('user_id', $user->id)
                ->where('status', 1)
                ->whereDate('end_date', '>=', now())
                ->first();

            if ($existing) {
                return response()->json([
                    'status' => false,
                    'message' => 'You already have an active plan!'
                ], 400);
            }

            // ✅ Create subscription
            ResumePlanSubscription::create([
                'user_id'        => $user->id,
                'plan_id'        => $plan->id,
                'download_limit' => $plan->downloads_limit ?? 0,
                'downloads_used' => 0,
                'start_date'     => Carbon::now(),
                'end_date'       => Carbon::now()->addDays($plan->duration_days),
                'status'         => 1,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Resume plan purchased successfully 🎉'
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }



public function purchaseBanner(Request $request)
    {
        $request->validate([
            'banner_plan_id' => 'required|exists:banner_plans,id',
            'banner_image' => 'required|image|max:5120'
        ]);

        $plan = BannerPlan::findOrFail($request->banner_plan_id);

        $file = $request->file('banner_image');
        $filename = time().'_'.$file->getClientOriginalName();
        $file->storeAs('public/banners', $filename);

        $subscription = BannerPlanSubscription::create([
            'user_id' => auth()->id(),
            'banner_plan_id' => $plan->id,
            'banner_image' => $filename,
            'price' => $plan->price,
            'gst_amount' => $plan->gst_amount,
            'total_price' => $plan->total_price,
            'status' => 'pending'
        ]);

        return response()->json([
            'status' => 'success',
            'subscription_id' => $subscription->id,
            'amount' => $plan->total_price
        ]);
    }

    public function paymentSuccess(Request $request)
    {
        $subscription = BannerPlanSubscription::findOrFail($request->subscription_id);

        $start = now();
        $end = now()->addDays(10); // or from plan

        $subscription->update([
            'status' => 'active',
            'start_date' => $start,
            'end_date' => $end,
            'payment_id' => $request->payment_id
        ]);

        return response()->json(['status' => 'success']);
    }
}

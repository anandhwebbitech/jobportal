<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BannerPlan;
use App\Models\BannerPlanSubscription;
use Illuminate\Http\Request;
use App\Models\JobPlan;
use App\Models\Order;
use App\Models\ResumePlan;
use App\Models\ResumePlanSubscription;
use App\Models\User;
use Yajra\DataTables\DataTables;
use App\Models\UserPlanSubscription;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Razorpay\Api\Api;
use App\Models\Invoice;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;


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
            'job_post_limit'        => $request->job_post_limit ?? 1,
            'applicant_management'  => $request->has('applicant_management'),
            'email_notifications'   => $request->has('email_notifications'),
            'tamil_nadu_reach'      => $request->has('tamil_nadu_reach'),
            'featured_listing'      => $request->has('featured_listing'),
            'priority_support'      => $request->has('priority_support'),
            'is_active'             => $request->is_active,
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
            'name'          => 'required|string|max:255',
            'duration_days' => 'required|integer|min:1',
            'price'         => 'required|numeric',
            'job_post_limit' => 'required|integer|min:1',
        ]);

        $plan = JobPlan::findOrFail($id);

        $plan->update(array_merge($validated, [
            'is_active'             => $request->is_active,
            'applicant_management'  => $request->has('applicant_management'),
            'email_notifications'   => $request->has('email_notifications'),
            'tamil_nadu_reach'      => $request->has('tamil_nadu_reach'),
            'featured_listing'      => $request->has('featured_listing'),
            'priority_support'      => $request->has('priority_support'),
            'gst_amount'            => $request->gst_amount ?? ($request->price * 0.18),
            'total_price'           => $request->total_price ?? ($request->price * 1.18),
        ]));

        return response()->json([
            'status' => true,
            'message' => 'Plan updated successfully!'
        ]);
    }
    public function verifyPayment(Request $request)
    {
        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));

        try {
            $api->utility->verifyPaymentSignature([
                'razorpay_order_id' => $request->razorpay_order_id,
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature' => $request->razorpay_signature
            ]);
        } catch (\Exception $e) {
                dd($e->getMessage());

        }

        // ✅ get order
        $order = Order::where('razorpay_order_id', $request->razorpay_order_id)->firstOrFail();

        // ✅ update order
        $order->update([
            'payment_id' => $request->razorpay_payment_id,
            'status' => 'paid'
        ]);

        // 🔥 get message from activatePlan
        $message = $this->activatePlan(
            $order->user_id,
            $request->plan_id,
            $request->quantity,
            $request->razorpay_payment_id
        );

        return response()->json([
            'status' => true,
            'message' => $message // 👈 dynamic message
        ]);
    }
    public function activatePlan($userId, $planId, $qty, $paymentId)
    {
        $plan = JobPlan::findOrFail($planId);
        $user = User::findOrFail($userId);
        // 🔍 check existing active plan
        $existing = UserPlanSubscription::where('user_id', $userId)
            ->where('status', 'active')
            ->first();
        $isExtended = false; // 👈 flag
        if ($existing && $existing->end_date > now()) {

            // 👉 extend from current plan end
            $startDate = $existing->end_date;

            // 👉 deactivate old
            $existing->update(['status' => 'expired']);

            $isExtended = true; // ⚠️ mark
        } else {
            $startDate = now(); 
        }

        // 💡 calculation
        $totalJobLimit = $plan->job_post_limit * $qty;

        $endDate = Carbon::parse($startDate)
            ->addDays($plan->duration_days);

        // 💾 SAVE
        UserPlanSubscription::create([
            'user_id'        => $userId,
            'job_plan_id'    => $plan->id,
            'start_date'     => $startDate,
            'end_date'       => $endDate,
            'jobs_used'      => 0,
            'job_post_limit' => $totalJobLimit,
            'payment_id'     => $paymentId,
            'payment_status' => 'paid',
            'status'         => 'active',
            'quantity'       => $qty 
        ]);
         // ✅ Invoice
        $invoiceNo = 'INV-' . strtoupper(Str::random(8));
        $amount = ($plan->price ?? 0) * $qty;
        $baseAmount = ($plan->price ?? 0) * $qty;
        $gstAmount  = $baseAmount * 0.18;
        $totalAmount = $baseAmount + $gstAmount;

        $invoice = Invoice::create([
            'invoice_no'     => $invoiceNo,
            'user_id'        => $user->id,
            'plan_id'        => $plan->id,

            // 🔥 IMPORTANT FIELDS
            'plan_type'      => 'job', // 👈 use keyword
            'plan_name'      => $plan->name,

            'amount'         => $baseAmount,
            'gst_amount'     => $gstAmount,
            'total_amount'   => $totalAmount,

            'payment_id'     => $paymentId,
            'payment_status' => 'paid',
            'payment_method' => 'razorpay',

            'paid_at'        => now(),
        ]);

        // ✅ Mail
        try {
            Mail::send('emails.invoice_mail', [
                'user' => $user,
                'plan' => $plan,
                'invoice' => $invoice,
                'qty' => $qty ,
                'plan_type' => 'Job Posting'
            ], function ($message) use ($user, $invoice) {
                $message->to("anandhwebbitech@gmail.com") // ✅ dynamic email
                    ->subject('Invoice #' . $invoice->invoice_no);
            });

        } catch (\Exception $e) {
            dd('Mail Error: ' . $e->getMessage());
        }


        // 🔥 return message
        if ($isExtended) {
            return "You already have an active plan. New plan will start after current plan expiry.";
        }

        return "Plan activated successfully";
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
            'name'              => $request->name,
            'price'             => $request->price,
            'gst_amount'        => $request->gst_amount,
            'total_price'       => $request->total_price,
            'downloads_limit'   => $request->downloads_limit,
            'valid_days'        => $request->valid_days,
            'features'          => $request->features ?? [], // ✅ FIX
            'is_active'         => $request->is_active ?? 1
        ]);

        return response()->json(['message' => 'Plan Created Successfully']);
    }


    // EDIT
    public function Resumeedit($id)
    {
        $plan = ResumePlan::findOrFail($id);

        return response()->json([
            'id'              => $plan->id,
            'name'            => $plan->name,
            'price'           => $plan->price,
            'gst_amount'      => $plan->gst_amount,
            'total_price'     => $plan->total_price,
            'downloads_limit' => $plan->downloads_limit,
            'valid_days'      => $plan->valid_days,
            'features'        => $plan->features, // ✅ already array
            'is_active'       => $plan->is_active,
        ]);
    }


    // UPDATE
    public function Resumeupdate(Request $request, $id)
    {
        $request->validate([
            'name'  => 'required',
            'price' => 'required|numeric',
        ]);

        $plan = ResumePlan::findOrFail($id);

        $plan->update([
            'name'            => $request->name,
            'price'           => $request->price,
            'gst_amount'      => $request->gst_amount,
            'total_price'     => $request->total_price,
            'downloads_limit' => $request->downloads_limit,
            'valid_days'      => $request->valid_days,
            'features'        => $request->features ?? [], // ✅ FIX
            'is_active'       => $request->is_active
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
            'plan_id' => 'required|exists:job_plans,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $user = auth()->user();
        $plan = JobPlan::findOrFail($request->plan_id);
        $qty  = (int) $request->quantity;

        // 🔥 Check existing active plan
        $existing = UserPlanSubscription::where('user_id', $user->id)
            ->where('status', 1)
            ->first();

        if ($existing && $existing->end_date > now()) {
            // 👉 extend from current end date
            $startDate = $existing->end_date;

            // ❗ old plan deactivate
            $existing->update(['status' => 0]);
        } else {
            $startDate = now();
        }

        // 💡 Calculation
        $totalJobLimit = $plan->job_post_limit * $qty;

        $endDate = \Carbon\Carbon::parse($startDate)
                    ->addDays($plan->duration_days);

        // 💾 Save subscription
        $subscription = UserPlanSubscription::create([
            'user_id'        => $user->id,
            'job_plan_id'    => $plan->id,
            'start_date'     => $startDate,
            'end_date'       => $endDate,
            'jobs_used'      => 0,
            'job_post_limit' => $totalJobLimit,
            'payment_id'     => 'TEST_' . uniqid(),
            'payment_status' => 'paid',
            'status'         => 1,
            'quantity'       => $qty 
        ]);
        // ✅ Invoice Number
        $invoiceNo = 'INV-' . strtoupper(Str::random(8));

        // ✅ Correct Amount (important)
        $amount = ($plan->price ?? 0) * $qty;

        // ✅ Create Invoice
        $invoice = Invoice::create([
            'invoice_no'     => $invoiceNo,
            'user_id'        => $user->id,
            'plan_id'        => $plan->id,
            'amount'         => $amount,
            'payment_status' => 'paid',
            'payment_method' => 'manual',
            'paid_at'        => now(),
        ]);
        try {

            Mail::send('emails.invoice_mail', [
                'user' => $user,
                'plan' => $plan,
                'invoice' => $invoice,
                'qty' => $qty
            ], function ($message) use ($user, $invoice) {
                $message->to("anandhwebbitech@gmail.com")
                    ->subject('Invoice #' . $invoice->invoice_no);
            });

        } catch (\Exception $e) {
            dd('Mail Error: ' . $e->getMessage());
        }

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
            'user_id'         => auth()->id(),
            'banner_plan_id'  => $plan->id,
            'banner_image'    => $filename,
            'price'           => $plan->price,
            'gst_amount'      => $plan->gst_amount,
            'total_price'     => $plan->total_price,
            'status'          => 'pending'
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

    public function createOrder(Request $request)
    {
        $request->validate([
            'plan_id' => 'required|exists:job_plans,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $user = auth()->user();

        $plan = JobPlan::findOrFail($request->plan_id);
        $qty  = (int) $request->quantity;

        // 💰 total amount (with GST already included)
        $amount = $plan->total_price * $qty * 100; // paisa

        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
        // dd(7,$user,$amount);

        $razorpayOrder = $api->order->create([
            'receipt' => 'order_' . uniqid(),
            'amount' => $amount,
            'currency' => 'INR'
        ]);
        // dd($razorpayOrder);
        // 💾 save order in DB
        $order = Order::create([
            'user_id'           => $user->id,
            'plan_id'           => $plan->id,
            'amount'            => $amount / 100,
            'razorpay_order_id' => $razorpayOrder['id'],
            'status'            => 'pending'
        ]);
        // dd(7);
        return response()->json([
            'order_id' => $razorpayOrder['id'],
            'amount' => $amount,
            'key' => env('RAZORPAY_KEY')
        ]);
    }
}

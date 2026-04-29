<?php

namespace App\Http\Controllers;

use App\Models\BannerPlan;
use App\Models\BannerPlanSubscription;
use App\Models\Invoice;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Razorpay\Api\Api;
use Illuminate\Support\Str;

class BannerPlanController extends Controller
{
    //
public function createBannerOrder(Request $request)
{
    $request->validate([
        'banner_plan_id' => 'required|exists:banner_plans,id',
        'banner_image'   => 'required|image|mimes:jpg,jpeg,png,webp|max:5120'
    ]);

    try {

        // ✅ Get Plan
        $plan = BannerPlan::findOrFail($request->banner_plan_id);

        // ✅ Upload Banner Image
        $filename = null;

        if ($request->hasFile('banner_image')) {

            $file = $request->file('banner_image');

            $filename = time() . '_' . str_replace(' ', '_', $file->getClientOriginalName());

            // storage/app/public/banners
            $file->storeAs('banners', $filename, 'public');
        }

        // ✅ Razorpay Amount (paise)
        $amount = $plan->total_price * 100;

        // ✅ Razorpay Init
        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));

        // ✅ Create Razorpay Order
        $razorpayOrder = $api->order->create([
            'receipt'  => 'banner_' . uniqid(),
            'amount'   => $amount,
            'currency' => 'INR'
        ]);

        // ✅ Save Subscription
        $subscription = BannerPlanSubscription::create([
            'user_id'           => auth()->id(),
            'banner_plan_id'    => $plan->id,
            'banner_image'      => $filename,

            'price'             => $plan->price,
            'gst_amount'        => $plan->gst_amount,
            'total_price'       => $plan->total_price,

            'status'            => 'pending',
            'payment_status'    => 'pending',

            'razorpay_order_id' => $razorpayOrder['id']
        ]);

        return response()->json([
            'status'   => true,
            'order_id' => $razorpayOrder['id'],
            'amount'   => $amount,
            'key'      => env('RAZORPAY_KEY'),
            'message'  => 'Order created successfully'
        ]);

    } catch (\Exception $e) {

        \Log::error('Banner Order Error: ' . $e->getMessage());

        return response()->json([
            'status'  => false,
            'message' => 'Something went wrong while creating order'
        ], 500);
    }
}
public function verifyBannerPayment(Request $request)
{
    $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));

    \DB::beginTransaction();

    try {

        // ✅ Verify signature
        $attributes = [
            'razorpay_order_id' => $request->razorpay_order_id,
            'razorpay_payment_id' => $request->razorpay_payment_id,
            'razorpay_signature' => $request->razorpay_signature
        ];

        $api->utility->verifyPaymentSignature($attributes);

        // ✅ Get subscription
        $subscription = BannerPlanSubscription::where('razorpay_order_id', $request->razorpay_order_id)
            ->firstOrFail();

        // 🔥 Prevent duplicate payment
        if ($subscription->payment_status === 'paid') {
            return response()->json([
                'status' => true,
                'message' => 'Already processed'
            ]);
        }

        $user = auth()->user();
        $plan = BannerPlan::findOrFail($subscription->banner_plan_id);

        // 🔍 Existing active plan check
        $existing = BannerPlanSubscription::where('user_id', $user->id)
            ->where('status', 'active')
            ->whereDate('end_date', '>=', now())
            ->first();

        if ($existing) {
            $startDate = $existing->end_date;
            $existing->update(['status' => 'expired']);
        } else {
            $startDate = now();
        }

        $endDate = \Carbon\Carbon::parse($startDate)
            ->addDays($plan->duration_days);

        $subscription->update([
            'status' => 'active',
            'payment_id' => $request->razorpay_payment_id,
            'payment_status' => 'paid',
            'start_date' => $startDate,
            'end_date' => $endDate
        ]);

        $baseAmount  = $plan->price;
        $gstAmount   = $plan->gst_amount ?? ($baseAmount * 0.18);
        $totalAmount = $plan->total_price ?? ($baseAmount + $gstAmount);

        $invoice = Invoice::create([
            'invoice_no'     => 'INV-' . strtoupper(\Str::random(8)),
            'user_id'        => $user->id,
            'plan_id'        => $plan->id,

            'plan_type'      => 'banner',
            'plan_name'      => 'Home Page Banner ('.$plan->duration_days.' Days)',

            'amount'         => $baseAmount,
            'gst_amount'     => $gstAmount,
            'total_amount'   => $totalAmount,

            'payment_id'     => $request->razorpay_payment_id,
            'payment_status' => 'paid',
            'payment_method' => 'razorpay',

            'paid_at'        => now(),
        ]);

        try {
            Mail::send('emails.invoice_mail', [
                'user' => $user,
                'plan' => $plan,
                'invoice' => $invoice,
                'qty' => 1,
                'plan_type' => 'Banner Advertisement'
            ], function ($message) use ($user, $invoice) {

                $message->to($user->email)
                    ->subject('Invoice #' . $invoice->invoice_no);
            });

        } catch (\Exception $mailError) {
            \Log::error('Mail Error: ' . $mailError->getMessage());
        }

        \DB::commit();

        return response()->json([
            'status' => true,
            'message' => 'Payment successful & Banner activated 🎉'
        ]);

    } catch (\Exception $e) {

        \DB::rollBack();

        \Log::error('Banner Payment Error: '.$e->getMessage());

        return response()->json([
            'status' => false,
            'message' => 'Payment verification failed'
        ], 500);
    }
}

}

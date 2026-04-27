<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\ResumePlan;
use App\Models\ResumePlanSubscription;
use App\Models\User;
use Illuminate\Http\Request;
use Razorpay\Api\Api;
use Illuminate\Support\Str;
use App\Models\Invoice;
use Illuminate\Support\Facades\Mail;

class ResumePlanController extends Controller
{
    //
    public function createResumeOrder(Request $request)
    {
        $request->validate([
            'plan_id' => 'required|exists:resume_plans,id'
        ]);

        $plan = ResumePlan::findOrFail($request->plan_id);

        $amount = $plan->total_price * 100; // paisa

        $api =  new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));

        $order = $api->order->create([
            'receipt' => 'resume_' . uniqid(),
            'amount' => $amount,
            'currency' => 'INR'
        ]);

        // save DB (optional but recommended)
        Order::create([
            'user_id' => auth()->id(),
            'plan_id' => $plan->id,
            'amount' => $plan->total_price,
            'razorpay_order_id' => $order['id'],
            'status' => 'pending'
        ]);

        return response()->json([
            'order_id' => $order['id'],
            'amount' => $amount,
            'key' => env('RAZORPAY_KEY')
        ]);
    }
    public function verifyResumePayment(Request $request)
    {
        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));

        try {

            $attributes = [
                'razorpay_order_id' => $request->razorpay_order_id,
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature' => $request->razorpay_signature
            ];

            $api->utility->verifyPaymentSignature($attributes);

            $order = Order::where('razorpay_order_id', $request->razorpay_order_id)->firstOrFail();

            $user = auth()->user();
            $plan = ResumePlan::findOrFail($order->plan_id);

            // ✅ Activate Plan
            ResumePlanSubscription::create([
                'user_id'        => $user->id,
                'plan_id'        => $plan->id,
                'download_limit' => $plan->downloads_limit,
                'downloads_used'=> 0,
                'start_date'     => now(),
                'end_date'       => now()->addDays($plan->duration_days),
                'status'         => 1,
            ]);

            // ✅ Update Order
            $order->update([
                'status' => 'paid',
                'payment_id' => $request->razorpay_payment_id
            ]);

            // 🔥 Invoice
            $invoiceNo = 'INV-' . strtoupper(Str::random(8));
            $baseAmount = $order->amount;
            $gstAmount  = $baseAmount * 0.18;
            $totalAmount = $baseAmount + $gstAmount;
            $invoice = Invoice::create([
                'invoice_no'     => $invoiceNo,
                'user_id'        => $user->id,
                'plan_id'        => $plan->id,

                // 🔥 IMPORTANT
                'plan_type'      => 'resume',
                'plan_name'      => $plan->name,

                'amount'         => $baseAmount,
                'gst_amount'     => $gstAmount,
                'total_amount'   => $totalAmount,

                'payment_id'     => $request->razorpay_payment_id,
                'payment_status' => 'paid',
                'payment_method' => 'razorpay',

                'paid_at'        => now(),
            ]);

            // 🔥 Mail
            try {
                Mail::send('emails.invoice_mail', [
                    'user' => $user,
                    'plan' => $plan,
                    'invoice' => $invoice,
                    'qty' => 1,
                    'plan_type' => 'Resume DB Plan'
                ], function ($message) use ($user, $invoice) {
                    $message->to("anandhwebbitech@gmail.com")
                        ->subject('Invoice #' . $invoice->invoice_no);
                });
            } catch (\Exception $e) {
                \Log::error('Mail Error: ' . $e->getMessage());
            }

            return response()->json([
                'status' => true,
                'message' => 'Payment successful & invoice sent 🎉'
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'message' => 'Payment verification failed'
            ], 500);
        }
    }

}

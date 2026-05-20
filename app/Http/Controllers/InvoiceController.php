<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    //
      public function getInvoices()
    {
        try {

            $invoices = Invoice::where('user_id', auth()->id())
                ->latest()
                ->get();

            return response()->json([
                'status' => true,
                'data' => $invoices
            ]);

        } catch (\Exception $e) {

            \Log::error('Invoice Error: '.$e->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Server error'
            ], 500);
        }
    }

    // 🔥 PDF download
    public function downloadPdf($id)
    {
        $invoice = Invoice::findOrFail($id);

        $pdf = Pdf::loadView('pdf.invoice', compact('invoice'));

        return $pdf->download($invoice->invoice_no . '.pdf');
    }
}

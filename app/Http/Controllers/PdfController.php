<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Registration;
use App\Models\RxStock;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class PdfController extends Controller
{
    function opt(Request $request)
    {
        $registration = Registration::findOrFail(decrypt($request->registration_id));
        $pdf = Pdf::loadView('admin.pdf.opt', compact('registration'));
        return $pdf->stream('opt.pdf');
    }

    function invoice(Request $request)
    {
        $order = Order::where('registration_id', decrypt($request->registration_id))->whereNotNull('invoice_number')->firstOrFail();
        $registration = Registration::findOrFail($order->registration_id);
        $pdf = Pdf::loadView('admin.pdf.invoice', compact('registration', 'order'));
        return $pdf->stream('invoice.pdf');
    }

    function storeOrderReceipt(Request $request)
    {
        $registration = Registration::findOrFail(decrypt($request->registration_id));
        $qrcode = base64_encode(QrCode::format('svg')->size(75)->errorCorrection('H')->generate('https://devieyecare.com'));
        $pdf = Pdf::loadView('admin.pdf.store_order_receipt', compact('registration', 'qrcode'));
        return $pdf->stream('receipt.pdf');
    }

    function pharmacyOrderReceipt(Request $request)
    {
        $registration = Registration::findOrFail(decrypt($request->registration_id));
        $pdf = Pdf::loadView('admin.pdf.pharmacy_receipt', compact('registration'));
        return $pdf->stream('pharmacy.pdf');
    }

    function serviceFeeReceipt(Request $request)
    {
        $registration = Registration::findOrFail(decrypt($request->registration_id));
        $pdf = Pdf::loadView('admin.pdf.service_fee_receipt', compact('registration'));
        return $pdf->stream('service_fee_receipt.pdf');
    }

    function certificate(Request $request)
    {
        $registration = Registration::findOrFail(decrypt($request->registration_id));
        $pdf = Pdf::loadView('admin.pdf.certificate', compact('registration'));
        return $pdf->stream('certificate.pdf');
    }

    function envelope(Request $request)
    {
        $stock = RxStock::findOrFail(decrypt($request->sid));
        if ($stock->type == "material"):
            $qrcode = base64_encode(QrCode::format('svg')->size(75)->errorCorrection('H')->generate('https://devieyecare.com'));
            $pdf = Pdf::loadView('admin.pdf.envelope', compact('stock', 'qrcode'));
            return $pdf->stream('envelope.pdf');
        endif;
        return redirect()->back()->with("error", "Envelope could not printed for Product");
    }

    function stock_barcode(Request $request)
    {
        $stock = RxStock::findOrFail(decrypt($request->sid));
        if ($stock->type == "product"):
            $product = Product::findOrFail($stock->material_id);
            $pdf = Pdf::loadView('admin.pdf.stock_barcode', compact('product'));
            return $pdf->stream('barcode.pdf');
        endif;
        return redirect()->back()->with("error", "Barcode could not printed for Material Stock");
    }
}

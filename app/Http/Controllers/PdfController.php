<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Registration;
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
}

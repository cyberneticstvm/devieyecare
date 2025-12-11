<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\Registration;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class HelperController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('search-registration'), only: ['searchRegistration', 'searchRegistrationShow']),
        ];
    }

    function searchRegistration()
    {
        $registrations = [];
        $inputs = array('');
        return view('admin.search.registration', compact('registrations', 'inputs'));
    }

    function searchRegistrationShow(Request $request)
    {
        $data = $request->validate([
            'search_term' => 'required',
        ]);
        try {
            $inputs = array($request->search_term);
            $registrations = Registration::orWhere('mrn', $request->search_term)->orWhere('mobile', $request->search_term)->orWhere('name', $request->search_term)->get();
        } catch (Exception $e) {
            return redirect()->back()->with("error", $e->getMessage())->withInput($data);
        }
        return view('admin.search.registration', compact('registrations', 'inputs'));
    }

    function storeOrderStatusUpdate(Request $request)
    {
        $order = Order::findOrFail(decrypt($request->oid));
        try {
            if ($order->ostatus()->latest()->first()->status->name == 'DLVD'):
                throw new Exception("Cannot update the status of the orders which has delivered / invoice generated!");
            endif;
            $status = getOrderStatus($request->status, 'order')->id;
            if (!$order->invoice_number && $request->status == 'DLVD'):
                $status = getOrderStatus($request->status, 'order')->id;
                $order->update([
                    'invoice_number' => generateInvoice($order),
                    'invoice_generated_at' => Carbon::now(),
                    'invoice_generated_by' => $request->user()->id,
                ]);
            endif;
            OrderStatus::create([
                'order_id' => $order->id,
                'mrn' => $order->registration->mrn,
                'status_id' => $status,
                'created_by' => $request->user()->id,
                'updated_by' => $request->user()->id,
            ]);
        } catch (Exception $e) {
            return redirect()->back()->with("error", $e->getMessage());
        }
        return redirect()->route('store.order.list')->with("success", "Order status updated successfully!");
    }
}

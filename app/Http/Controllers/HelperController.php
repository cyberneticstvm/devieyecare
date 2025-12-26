<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\Product;
use App\Models\Registration;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Session;

class HelperController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('search-registration'), only: ['searchRegistration', 'searchRegistrationShow']),
            new middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('order-status-update'), only: ['storeOrderStatusUpdate']),
            new middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('inventory-status'), only: ['inventory', 'getInventory']),
            new middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('surgery-register'), only: ['surgeryAdvised']),
        ];
    }
    protected $branch;
    function __construct()
    {
        $this->branch = Session::get('branch')->id;
    }

    function inventory()
    {
        $inputs = array($this->branch);
        $data = getInventory($this->branch, 0);
        $branches = fromBranches();
        return view('admin.inventory.status', compact('inputs', 'data', 'branches'));
    }

    function getInventory(Request $request)
    {
        $inputs = array($request->branch);
        $br = Branch::find($request->branch);
        $data = getInventory($request->branch, 0);
        $branches = fromBranches();
        return view('admin.inventory.status', compact('inputs', 'data', 'branches'));
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
            updateOrderStatus($order, ($request->status == 'DLVD') ? true : false);
        } catch (Exception $e) {
            return redirect()->back()->with("error", $e->getMessage());
        }
        return redirect()->route('store.order.list')->with("success", "Order status updated successfully!");
    }

    function surgeryAdvised()
    {
        $registrations = Registration::where('surgery_advised', 1)->latest()->get();
        return view('admin.misc.surgery_advised', compact('registrations'));
    }
}

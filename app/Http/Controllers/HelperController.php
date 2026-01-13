<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Extra;
use App\Models\LoginLog;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\Product;
use App\Models\Registration;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
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
            new middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('bulk-order-update'), only: ['orderStatus', 'orderStatusUpdate']),
        ];
    }
    protected $branch;
    function __construct()
    {
        $this->branch = Session::get('branch')->id;
    }

    function switchBranch(Request $request)
    {
        $branch = Branch::findOrFail(decrypt($request->branch));
        Session::forget('branch');
        Session::put('branch', $branch);
        LoginLog::where('user_id', Auth::user()->id)->where('login_session_id', Auth::user()->login_session_id)->update([
            'branch_id' => Session::get('branch')->id,
        ]);
        return redirect()->back()->with("success", "Branch switched successfully!");
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

    function orderStatus()
    {
        $statuses = Extra::where('category', 'order')->pluck('name', 'id');
        return view('admin.misc.bulk_order_status', compact('statuses'));
    }

    function orderStatusUpdate(Request $request)
    {
        try {
            $data = [];
            foreach ($request->status_ids as $key => $item):
                if ($item > 0 && $request->mrns[$key]):
                    $order = Order::where('registration_id', Registration::where('mrn', $request->mrns[$key])->first()->id)->first();
                    if ($order?->id):
                        $data[] = [
                            'order_id' => $order->id,
                            'mrn' => $order->registration->mrn,
                            'status_id' => $request->status_ids[$key],
                            'comments' => $request->comments[$key],
                            'created_by' => $request->user()->id,
                            'updated_by' => $request->user()->id,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ];
                        $order->update(['status' => $request->status_ids[$key]]);
                    endif;
                endif;
            endforeach;
            OrderStatus::insert($data);
        } catch (Exception $e) {
            return redirect()->back()->with("error", $e->getMessage());
        }
        return redirect()->route('bulk.order.status')->with("success", "Order status updated successfully!");
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Customer;
use App\Models\CustomerAccount;
use App\Models\CustomerOrder;
use App\Models\CustomerOrderDetail;
use App\Models\Extra;
use App\Models\LoginLog;
use App\Models\ManufacturerSupplier;
use App\Models\Product;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\DB;

class DrishtiController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            //new middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('drishti-customer'), only: ['customer', 'save_customer']),
        ];
    }

    private $payment_modes, $products, $customers;

    function __construct()
    {
        $this->payment_modes = Extra::where('category', 'pmode')->pluck('name', 'id');
        $this->products = Product::orderBy('name')->pluck('name', 'id');
        $this->customers = Customer::orderBy('name')->pluck('name', 'id');
    }

    function dashboard()
    {
        $branches = userBranches();
        return view('admin.drishti.dashboard', compact('branches'));
    }

    function updateBranch(Request $request)
    {
        $branch = Branch::findOrFail($request->branch);
        Session::put('branch', $branch);
        LoginLog::where('user_id', Auth::user()->id)->where('login_session_id', Auth::user()->login_session_id)->update([
            'branch_id' => Session::get('branch')->id,
        ]);
        if (Session::has('branch')) :
            return redirect()->route('drishti.dashboard')
                ->withSuccess('User branch updated successfully!');
        else :
            return redirect()->route('drishti.dashboard')
                ->withError('Please update branch!');
        endif;
    }

    function customer()
    {
        $customers = Customer::withTrashed()->latest()->get();
        $pmodes = $this->payment_modes;
        return view('admin.drishti.customer.index', compact('customers', 'pmodes'));
    }

    function save_customer(Request $request)
    {
        $inputs = request()->validate([
            'name' => 'required',
            'mobile' => 'required|digits:10',
            'address' => 'nullable',
            'gst' => 'nullable',
            'opening_balance' => 'nullable|numeric',
            'credit_limit' => 'nullable|numeric',
        ]);
        $inputs['created_by'] = request()->user()->id;
        $inputs['updated_by'] = request()->user()->id;
        Customer::create($inputs);
        return redirect()->route('drishti.customer')->withSuccess("Customer created successfully!");
    }

    function edit_customer()
    {
        $customer = Customer::findOrFail(decrypt(request()->id));
        return view('admin.drishti.customer.edit', compact('customer'));
    }

    function update_customer(Request $request)
    {
        $inputs = request()->validate([
            'name' => 'required',
            'mobile' => 'required|digits:10',
            'address' => 'nullable',
            'gst' => 'nullable',
            'opening_balance' => 'nullable|numeric',
            'credit_limit' => 'nullable|numeric',
        ]);
        $inputs['updated_by'] = request()->user()->id;
        $customer = Customer::findOrFail(decrypt(request()->id));
        $customer->update($inputs);
        return redirect()->route('drishti.customer')->withSuccess("Customer updated successfully!");
    }

    function delete_customer()
    {
        Customer::findOrFail(decrypt(request()->id))->delete();
        return redirect()->route('drishti.customer')->withSuccess("Customer deleted successfully!");
    }

    function customer_account()
    {
        $accounts = CustomerAccount::withTrashed()->with('customer')->latest()->get();
        return view('admin.drishti.customer.account', compact('accounts'));
    }

    function customer_account_save(Request $request)
    {
        $inputs = request()->validate([
            'customer_id' => 'required|exists:customers,id',
            'payment_type' => 'required|in:credit,debit',
            'payment_date' => 'required|date',
            'amount' => 'required|numeric',
            'payment_mode' => 'required|exists:extras,id',
            'description' => 'nullable',
        ]);
        $inputs['created_by'] = request()->user()->id;
        $inputs['updated_by'] = request()->user()->id;
        CustomerAccount::create($inputs);
        return redirect()->route('drishti.customer.account')->withSuccess("Customer account entry created successfully!");
    }

    function customer_account_delete()
    {
        CustomerAccount::findOrFail(decrypt(request()->id))->delete();
        return redirect()->route('drishti.customer.account')->withSuccess("Customer account entry deleted successfully!");
    }

    function customer_order()
    {
        $orders = CustomerOrder::withTrashed()->with('customer')->latest()->get();
        return view('admin.drishti.order.index', compact('orders'));
    }

    function customer_order_create()
    {
        $products = $this->products;
        $customers = $this->customers;
        return view('admin.drishti.order.create', compact('products', 'customers'));
    }

    function customer_order_store(Request $request)
    {
        $inputs = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'order_date' => 'required|date',
            'notes' => 'nullable',
            'show_price' => 'nullable|boolean',
            'product_id.*' => 'required|exists:products,id',
            'batch.*' => 'nullable',
            'expiry.*' => 'nullable|date',
            'qty.*' => 'required|integer',
            'price.*' => 'required|numeric',
        ]);
        try {
            DB::transaction(function () use ($request, $inputs) {
                $order_inputs = $request->only('customer_id', 'order_date', 'notes', 'show_price');
                $order_inputs['created_by'] = $request->user()->id;
                $order_inputs['updated_by'] = $request->user()->id;
                $order_inputs['branch_id'] = Session::get('branch')->id;
                $order = CustomerOrder::create($order_inputs);
                $data = [];
                foreach ($request->product_id as $key => $item):
                    $data[] = [
                        'customer_order_id' => $order->id,
                        'product_id' => $item,
                        'qty' => $request->qty[$key],
                        'batch' => $request->batch[$key] ?? 'NA',
                        'expiry' => $request->expiry[$key],
                        'price' => $request->price[$key] ?? 0,
                        'total' => $request->price[$key] * $request->qty[$key],
                        'created_at' => $order->created_at,
                        'updated_at' => $order->updated_at,
                    ];
                endforeach;
                CustomerOrderDetail::insert($data);
            });
        } catch (Exception $e) {
            return redirect()->back()->with("error", $e->getMessage())->withInput($inputs);
        }
        return redirect()->route('drishti.customer.order')->withSuccess("Customer order created successfully!");
    }

    function customer_order_edit()
    {
        $order = CustomerOrder::with('details')->findOrFail(decrypt(request()->id));
        $products = $this->products;
        $customers = $this->customers;
        return view('admin.drishti.order.edit', compact('order', 'products', 'customers'));
    }

    function customer_order_update(Request $request)
    {
        $inputs = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'order_date' => 'required|date',
            'notes' => 'nullable',
            'show_price' => 'nullable|boolean',
            'product_id.*' => 'required|exists:products,id',
            'batch.*' => 'nullable',
            'expiry.*' => 'nullable|date',
            'qty.*' => 'required|integer',
            'price.*' => 'required|numeric',
        ]);
        try {
            DB::transaction(function () use ($request, $inputs) {
                $order = CustomerOrder::findOrFail(decrypt(request()->id));
                $order_inputs = $request->only('customer_id', 'order_date', 'notes', 'show_price');
                $order_inputs['updated_by'] = $request->user()->id;
                $order_inputs['updated_by'] = $request->user()->id;
                $order->update($order_inputs);
                CustomerOrderDetail::where('customer_order_id', $order->id)->delete();
                $data = [];
                foreach ($request->product_id as $key => $item):
                    $data[] = [
                        'customer_order_id' => $order->id,
                        'product_id' => $item,
                        'qty' => $request->qty[$key],
                        'batch' => $request->batch[$key] ?? 'NA',
                        'expiry' => $request->expiry[$key],
                        'price' => $request->price[$key] ?? 0,
                        'total' => $request->price[$key] * $request->qty[$key],
                        'created_at' => $order->created_at,
                        'updated_at' => $order->updated_at,
                    ];
                endforeach;
                CustomerOrderDetail::insert($data);
            });
        } catch (Exception $e) {
            return redirect()->back()->with("error", $e->getMessage())->withInput($inputs);
        }
        return redirect()->route('drishti.customer.order')->withSuccess("Customer order updated successfully!");
    }

    function customer_order_delete()
    {
        CustomerOrder::findOrFail(decrypt(request()->id))->delete();
        return redirect()->route('drishti.customer.order')->withSuccess("Customer order deleted successfully!");
    }
}

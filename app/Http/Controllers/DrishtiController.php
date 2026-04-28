<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Customer;
use App\Models\CustomerAccount;
use App\Models\Extra;
use App\Models\LoginLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class DrishtiController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            //new middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('drishti-customer'), only: ['customer', 'save_customer']),
        ];
    }

    private $payment_modes;

    function __construct()
    {
        $this->payment_modes = Extra::where('category', 'pmode')->pluck('name', 'id');
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
        $accounts = CustomerAccount::with('customer')->latest()->get();
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
        return view('admin.drishti.order.index');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Extra;
use App\Models\Head;
use App\Models\Hsn;
use App\Models\IncomeExpense;
use App\Models\Order;
use App\Models\Pharmacy;
use App\Models\Product;
use App\Models\Registration;
use App\Models\User;
use App\Models\VehiclePayment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ReportController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('report-sales'), only: ['sales', 'salesFetch']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('report-pharmacy'), only: ['pharmacy', 'pharmacyFetch']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('report-sales'), only: ['registration', 'registrationFetch']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('report-sales'), only: ['daybook', 'daybookFetch']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('report-sales'), only: ['expense', 'expenseFetch']),
        ];
    }

    protected $branches, $advisors, $pmodes, $rtypes, $store_products, $medicines, $expense_heads;
    public function __construct()
    {
        $this->rtypes = array('0' => 'All', '1' => 'Due Date Report', '2' => 'Booked Without Advance', '3' => 'Booked Not Delivered');

        $brs = Branch::selectRaw("'All' as name, '0' AS id");

        $this->branches = Branch::when(!in_array(Auth::user()->roles->first()->name, ['Administrator']), function ($q) {
            return $q->where('id', Session::get('branch')->id);
        })->when(in_array(Auth::user()->roles->first()->name, ['Administrator']), function ($q) use ($brs) {
            return $q->union($brs);
        })->pluck('name', 'id');
        $this->advisors = User::role(requiredRoles()[1])->when(!in_array(Auth::user()->roles->first()->name, ['Administrator']), function ($q) {
            return $q->where('id', Auth::id());
        })->when(in_array(Auth::user()->roles->first()->name, ['Administrator']), function ($q) use ($brs) {
            return $q->union($brs);
        })->pluck('name', 'id');
        $this->pmodes = Extra::where('category', 'pmode')->union(Extra::selectRaw("'All' as name, '0' AS id"))->pluck('name', 'id');
        $this->store_products = Product::whereIn('hsn_id', Hsn::whereIn('name', ['Frame', 'Lens'])->pluck('id'))->union($brs)->pluck('name', 'id');
        $this->medicines = Product::whereIn('hsn_id', Hsn::whereNotIn('name', ['Frame', 'Lens'])->pluck('id'))->union($brs)->pluck('name', 'id');

        $this->expense_heads = Head::where('category_id', Extra::where('name', 'Expense')->where('category', 'head')->first()->id)->union($brs)->pluck('name', 'id');
    }

    function sales()
    {
        $records = collect();
        $inputs = array(date('Y-m-d'), date('Y-m-d'), Session::get('branch')->id, '0', '0', '0');
        $branches = $this->branches;
        $advisors = $this->advisors;
        $rtypes = $this->rtypes;
        $products = $this->store_products;
        return view('admin.report.sales', compact('records', 'inputs', 'branches', 'advisors', 'rtypes', 'products'));
    }

    function salesFetch(Request $request)
    {
        $params = $request->validate([
            'from_date' => 'required|date',
            'to_date' => 'required|date',
        ]);
        $fdate = Carbon::parse($request->from_date)->startOfDay();
        $tdate = Carbon::parse($request->to_date)->endOfDay();
        $inputs = array($request->from_date, $request->to_date, $request->branch, $request->advisor, $request->rtype, $request->product_id);
        $branches = $this->branches;
        $advisors = $this->advisors;
        $rtypes = $this->rtypes;
        $products = $this->store_products;
        $status = getOrderStatus('DLVD', 'order');
        $records = Order::leftJoin('order_details AS od', 'orders.id', 'od.order_id')->whereBetween(($request->rtype == 1) ? 'orders.due_date' : 'orders.created_at', [$fdate, $tdate])->when($request->branch > 0, function ($q) use ($request) {
            return $q->where('branch_id', $request->branch);
        })->when($request->product_id > 0, function ($q) use ($request) {
            return $q->where('od.product_id', $request->product_id);
        })->when($request->advisor > 0, function ($q) use ($request) {
            return $q->where('product_advisor', $request->advisor);
        })->when($request->rtype == 2, function ($q) {
            return $q->where('advance', 0);
        })->when($request->rtype == 3, function ($q) use ($status) {
            return $q->whereNot('status', $status->id);
        })->selectRaw("orders.id, orders.created_at, orders.registration_id, orders.discount, orders.advance, orders.branch_id, orders.invoice_number, orders.product_advisor, orders.status, SUM(od.total) AS total")->groupBy("orders.id", "orders.created_at", "orders.registration_id", "orders.discount", "orders.advance", "orders.branch_id", "orders.invoice_number", "orders.product_advisor", "orders.status")->get();
        return view('admin.report.sales', compact('records', 'inputs', 'branches', 'advisors', 'rtypes', 'products'));
    }

    function pharmacy()
    {
        $records = collect();
        $inputs = array(date('Y-m-d'), date('Y-m-d'), Session::get('branch')->id, '0');
        $branches = $this->branches;
        $products = $this->medicines;
        return view('admin.report.pharmacy', compact('records', 'inputs', 'branches', 'products'));
    }

    function pharmacyFetch(Request $request)
    {
        $params = $request->validate([
            'from_date' => 'required|date',
            'to_date' => 'required|date',
        ]);
        $fdate = Carbon::parse($request->from_date)->startOfDay();
        $tdate = Carbon::parse($request->to_date)->endOfDay();
        $inputs = array($request->from_date, $request->to_date, $request->branch, $request->product_id);
        $branches = $this->branches;
        $products = $this->medicines;
        $records = Pharmacy::leftJoin('pharmacy_details AS pd', 'pd.pharmacy_id', 'pharmacies.id')->whereBetween('pharmacies.created_at', [$fdate, $tdate])->when($request->branch > 0, function ($q) use ($request) {
            return $q->where('branch_id', $request->branch);
        })->when($request->product_id > 0, function ($q) use ($request) {
            return $q->where('pd.product_id', $request->product_id);
        })->selectRaw("pharmacies.id, pharmacies.registration_id, pharmacies.branch_id, pharmacies.invoice_number, pharmacies.discount, pharmacies.created_at, SUM(pd.total) AS total")->groupBy("pharmacies.id", "pharmacies.registration_id", "pharmacies.branch_id", "pharmacies.invoice_number", "pharmacies.discount", "pharmacies.created_at")->get();
        return view('admin.report.pharmacy', compact('records', 'inputs', 'branches', 'products'));
    }

    function registration()
    {
        $records = collect();
        $inputs = array(date('Y-m-d'), date('Y-m-d'), Session::get('branch')->id);
        $branches = $this->branches;
        return view('admin.report.registration', compact('records', 'inputs', 'branches'));
    }

    function registrationFetch(Request $request)
    {
        $params = $request->validate([
            'from_date' => 'required|date',
            'to_date' => 'required|date',
        ]);
        $fdate = Carbon::parse($request->from_date)->startOfDay();
        $tdate = Carbon::parse($request->to_date)->endOfDay();
        $inputs = array($request->from_date, $request->to_date, $request->branch);
        $branches = $this->branches;
        $records = Registration::whereBetween('created_at', [$fdate, $tdate])->when($request->branch > 0, function ($q) use ($request) {
            return $q->where('branch_id', $request->branch);
        })->latest()->get();
        return view('admin.report.registration', compact('records', 'inputs', 'branches'));
    }

    function daybook()
    {
        $inputs = array(date('Y-m-d'), Session::get('branch')->id);
        $branches = $this->branches;
        $records = getDayBook(date('Y-m-d'), Session::get('branch')->id);
        $iecat = Extra::where('name', 'Expense')->where('category', 'head')->first();
        $expenses = IncomeExpense::whereDate('created_at', date('Y-m-d'))->where('branch_id', Session::get('branch')->id)->where('category_id', $iecat->id)->get();
        $vpayments = VehiclePayment::whereDate('created_at', date('Y-m-d'))->where('branch_id', Session::get('branch')->id)->get();
        return view('admin.report.daybook', compact('records', 'inputs', 'branches', 'expenses', 'vpayments'));
    }

    function daybookFetch(Request $request)
    {
        $params = $request->validate([
            'ddate' => 'required|date',
            'branch' => 'required|gt:0',
        ]);
        $inputs = array($request->ddate, $request->branch);
        $branches = $this->branches;
        $records = getDayBook($request->ddate, $request->branch);
        $iecat = Extra::where('name', 'Expense')->where('category', 'head')->first();
        $expenses = IncomeExpense::whereDate('created_at', $request->ddate)->where('branch_id', $request->branch)->where('category_id', $iecat->id)->get();
        $vpayments = VehiclePayment::whereDate('created_at', $request->ddate)->where('branch_id', $request->branch)->get();
        return view('admin.report.daybook', compact('records', 'inputs', 'branches', 'expenses', 'vpayments'));
    }

    function expense()
    {
        $inputs = array(date('Y-m-d'), date('Y-m-d'), Session::get('branch')->id, '0');
        $branches = $this->branches;
        $heads = $this->expense_heads;
        $records = collect();
        return view('admin.report.expense', compact('records', 'inputs', 'branches', 'heads'));
    }

    function expenseFetch(Request $request)
    {
        $params = $request->validate([
            'from_date' => 'required|date',
            'to_date' => 'required|date',
        ]);
        $fdate = Carbon::parse($request->from_date)->startOfDay();
        $tdate = Carbon::parse($request->to_date)->endOfDay();
        $inputs = array($request->from_date, $request->to_date, $request->branch_id, $request->head_id);
        $branches = $this->branches;
        $heads = $this->expense_heads;
        $records = IncomeExpense::whereBetween('ie_date', [$fdate, $tdate])->where('category_id', Extra::where('name', 'Expense')->where('category', 'head')->first()->id)->when($request->branch > 0, function ($q) use ($request) {
            return $q->where('branch_id', $request->branch);
        })->get();
        return view('admin.report.expense', compact('records', 'inputs', 'branches', 'heads'));
    }
}

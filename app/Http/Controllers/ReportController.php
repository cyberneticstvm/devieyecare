<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Extra;
use App\Models\Order;
use App\Models\Registration;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ReportController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('report-sales'), only: ['sales', 'salesFetch']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('report-sales'), only: ['registration', 'registrationFetch']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('report-sales'), only: ['daybook', 'daybookFetch']),
        ];
    }

    protected $branches, $advisors, $pmodes, $rtypes;
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
    }

    function sales()
    {
        $records = collect();
        $inputs = array(date('Y-m-d'), date('Y-m-d'), Session::get('branch')->id, '0', '0', '0');
        $branches = $this->branches;
        $advisors = $this->advisors;
        $rtypes = $this->rtypes;
        return view('admin.report.sales', compact('records', 'inputs', 'branches', 'advisors', 'rtypes'));
    }

    function salesFetch(Request $request)
    {
        $params = $request->validate([
            'from_date' => 'required|date',
            'to_date' => 'required|date',
        ]);
        $fdate = Carbon::parse($request->from_date)->startOfDay();
        $tdate = Carbon::parse($request->to_date)->endOfDay();
        $inputs = array($request->from_date, $request->to_date, $request->branch, $request->advisor, $request->rtype, $request->pmode);
        $branches = $this->branches;
        $advisors = $this->advisors;
        $rtypes = $this->rtypes;
        $status = getOrderStatus('DLVD', 'order');
        $records = Order::whereBetween(($request->rtype == 1) ? 'due_date' : 'created_at', [$fdate, $tdate])->when($request->branch > 0, function ($q) use ($request) {
            return $q->where('branch_id', $request->branch);
        })->when($request->advisor > 0, function ($q) use ($request) {
            return $q->where('product_advisor', $request->advisor);
        })->when($request->rtype == 2, function ($q) {
            return $q->where('advance', 0);
        })->when($request->rtype == 3, function ($q) use ($status) {
            return $q->whereNot('status', $status->id);
        })->latest()->get();
        return view('admin.report.sales', compact('records', 'inputs', 'branches', 'advisors', 'rtypes'));
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
        $records = collect();
        return view('admin.report.daybook', compact('records', 'inputs', 'branches'));
    }

    function daybookFetch(Request $request)
    {
        $params = $request->validate([
            'ddate' => 'required|date',
            'branch' => 'required|gt:0',
        ]);
        $inputs = array($request->ddate, $request->branch);
        $branches = $this->branches;
        $records = collect();
        return view('admin.report.daybook', compact('records', 'inputs', 'branches'));
    }
}

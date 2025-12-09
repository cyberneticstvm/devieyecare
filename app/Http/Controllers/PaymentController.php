<?php

namespace App\Http\Controllers;

use App\Models\Extra;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Registration;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class PaymentController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('payment-list'), only: ['index']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('payment-create'), only: ['create', 'store']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('payment-edit'), only: ['edit', 'update']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('payment-delete'), only: ['destroy']),
        ];
    }
    protected $ptypes, $pmodes, $otypes;
    public function __construct()
    {
        $this->ptypes = Extra::where('category', 'ptype')->pluck('name', 'id');
        $this->pmodes = Extra::where('category', 'pmode')->pluck('name', 'id');
        $this->otypes = array('Store' => 'Store', 'Pharmacy' => 'Pharmacy');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $payments = Payment::withTrashed()->whereDate('pdate', Carbon::today())->when(!in_array(Auth::user()->roles->first()->name, ['Administrator']), function ($q) {
            return $q->where('branch_id', Session::get('branch')->id);
        })->get();
        $ptypes = $this->ptypes;
        $pmodes = $this->pmodes;
        $otypes = $this->otypes;
        return view('admin.order.payment.index', compact('payments', 'ptypes', 'pmodes', 'otypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $inputs = $request->validate([
            'pdate' => 'required|date',
            'mrn' => 'required',
            'order_type' => 'required',
            'payment_type' => 'required',
            'amount' => 'required|min:1',
            'pmode' => 'required',
            'notes' => 'nullable',
        ]);
        try {
            $order = Order::where('mrn', $request->mrn)->where('branch_id', Session::get('branch')->id)->firstOrFail();
            if ($request->amount > getStoreDueAmount($order->registration_id, 0)):
                throw new Exception("Entered amount is greater than due amount");
            endif;
            $inputs['created_by'] = $request->user()->id;
            $inputs['updated_by'] = $request->user()->id;
            $inputs['order_id'] = $order->id;
            $inputs['branch_id'] = Session::get('branch')->id;
            unset($inputs['mrn']);
            Payment::create($inputs);
        } catch (Exception $e) {
            return redirect()->back()->with("error", $e->getMessage())->withInput($inputs);
        }
        return redirect()->route('payment.list')->with("success", "Payment created successfully!");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $payment = Payment::findOrFail(decrypt($id));
        $ptypes = $this->ptypes;
        $pmodes = $this->pmodes;
        $otypes = $this->otypes;
        return view('admin.order.payment.edit', compact('payment', 'ptypes', 'pmodes', 'otypes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $inputs = $request->validate([
            'pdate' => 'required|date',
            'mrn' => 'required',
            'order_type' => 'required',
            'payment_type' => 'required',
            'amount' => 'required|min:1',
            'pmode' => 'required',
            'notes' => 'nullable',
        ]);
        try {
            $order = Order::where('mrn', $request->mrn)->where('branch_id', Session::get('branch')->id)->firstOrFail();
            $p = Payment::findOrFail(decrypt($id));
            if ($request->amount > getStoreDueAmount($order->registration_id, $p->amount)):
                throw new Exception("Entered amount is greater than due amount");
            endif;
            $inputs['updated_by'] = $request->user()->id;
            $p->update($inputs);
        } catch (Exception $e) {
            return redirect()->back()->with("error", $e->getMessage())->withInput($inputs);
        }
        return redirect()->route('payment.list')->with("success", "Payment updated successfully!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Payment::findOrFail(decrypt($id))->delete();
        return redirect()->route('payment.list')->with("success", "Payment deleted successfully!");
    }
}

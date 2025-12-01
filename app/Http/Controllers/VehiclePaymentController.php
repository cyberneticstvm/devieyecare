<?php

namespace App\Http\Controllers;

use App\Models\Extra;
use App\Models\Vehicle;
use App\Models\VehiclePayment;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class VehiclePaymentController extends Controller implements HasMiddleware
{

    public static function middleware(): array
    {
        return [
            new middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('vehicle-payment-list'), only: ['index']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('vehicle-payment-create'), only: ['create', 'store']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('vehicle-payment-edit'), only: ['edit', 'update']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('vehicle-payment-delete'), only: ['destroy']),
        ];
    }

    protected $pmodes;
    public function __construct()
    {
        $this->pmodes = Extra::where('category', 'pmode')->pluck('name', 'id');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(string $vid)
    {
        $payments = VehiclePayment::withTrashed()->where('vehicle_id', decrypt($vid))->orderByDesc('pdate')->get();
        $vehicle = Vehicle::findOrFail(decrypt($vid));
        $pmodes = $this->pmodes;
        return view('admin.vehicle.payment.index', compact('payments', 'vehicle', 'pmodes'));
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
            'amount' => 'required',
            'notes' => 'nullable',
            'vehicle_id' => 'required',
        ]);
        try {
            $inputs['vehicle_id'] = decrypt($request->vehicle_id);
            $inputs['created_by'] = $request->user()->id;
            $inputs['updated_by'] = $request->user()->id;
            VehiclePayment::create($inputs);
        } catch (Exception $e) {
            return redirect()->back()->with("error", $e->getMessage())->withInput($inputs);
        }
        return redirect()->route('vehicle.payment.list', $request->vehicle_id)->with("success", "Vehicle payment created successfully!");
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
        $payment = VehiclePayment::findOrFail(decrypt($id));
        $pmodes = $this->pmodes;
        return view('admin.vehicle.payment.edit', compact('payment', 'pmodes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $inputs = $request->validate([
            'pdate' => 'required|date',
            'amount' => 'required',
            'notes' => 'nullable',
        ]);
        try {
            $inputs['updated_by'] = $request->user()->id;
            $payment = VehiclePayment::findOrFail(decrypt($id));
            $payment->update($inputs);
        } catch (Exception $e) {
            return redirect()->back()->with("error", $e->getMessage())->withInput($inputs);
        }
        return redirect()->route('vehicle.payment.list', encrypt($payment->vehicle_id))->with("success", "Vehicle payment updated successfully!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $payment = VehiclePayment::findOrFail(decrypt($id));
        $payment->delete();
        return redirect()->route('vehicle.payment.list', encrypt($payment->vehicle_id))->with("success", "Vehicle payment deleted successfully!");
    }
}

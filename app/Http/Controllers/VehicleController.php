<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Vehicle;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class VehicleController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('vehicle-list'), only: ['index']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('vehicle-create'), only: ['create', 'store']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('vehicle-edit'), only: ['edit', 'update']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('vehicle-delete'), only: ['destroy']),
        ];
    }

    protected $branches;
    public function __construct()
    {
        $this->branches = Branch::when(!in_array(Auth::user()->roles->first()->name, ['Administrator']), function ($q) {
            return $q->where('id', Session::get('branch')->id);
        })->pluck('name', 'id');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $vehicles = Vehicle::withTrashed()->when(!in_array(Auth::user()->roles->first()->name, ['Administrator']), function ($q) {
            return $q->where('branch_id', Session::get('branch')->id);
        })->latest()->get();
        $branches = $this->branches;
        return view('admin.vehicle.index', compact('vehicles', 'branches'));
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
            'name' => 'required',
            'mobile' => 'required|numeric|digits:10',
            'registration_number' => 'required|unique:vehicles,registration_number',
            'branch_id' => 'required',
        ]);
        try {
            $inputs['created_by'] = $request->user()->id;
            $inputs['updated_by'] = $request->user()->id;
            Vehicle::create($inputs);
        } catch (Exception $e) {
            return redirect()->back()->with("error", $e->getMessage())->withInput($inputs);
        }
        return redirect()->route('vehicle.list')->with("success", "Vehicle created successfully!");
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
        $vehicle = Vehicle::findOrFail(decrypt($id));
        $branches = $this->branches;
        return view('admin.vehicle.edit', compact('vehicle', 'branches'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $inputs = $request->validate([
            'name' => 'required',
            'mobile' => 'required|numeric|digits:10',
            'registration_number' => 'required|unique:vehicles,registration_number,' . decrypt($id),
            'branch_id' => 'required',
        ]);
        try {
            $inputs['updated_by'] = $request->user()->id;
            Vehicle::findOrFail(decrypt($id))->update($inputs);
        } catch (Exception $e) {
            return redirect()->back()->with("error", $e->getMessage())->withInput($inputs);
        }
        return redirect()->route('vehicle.list')->with("success", "Vehicle updated successfully!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Vehicle::findOrFail(decrypt($id))->delete();
        return redirect()->route('vehicle.list')->with("success", "Vehicle deleted successfully!");
    }
}

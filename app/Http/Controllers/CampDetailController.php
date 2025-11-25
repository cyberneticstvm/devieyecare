<?php

namespace App\Http\Controllers;

use App\Models\Camp;
use App\Models\CampDetail;
use App\Models\Extra;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class CampDetailController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('camp-patient-list'), only: ['index']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('camp-patient-create'), only: ['create', 'store']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('camp-patient-edit'), only: ['edit', 'update']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('camp-patient-delete'), only: ['destroy']),
        ];
    }

    protected $gender;
    public function __construct()
    {
        $this->gender = Extra::where('category', 'gender')->pluck('name', 'name');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(string $id)
    {
        $camp = Camp::findOrFail(decrypt($id));
        $patients = CampDetail::withTrashed()->where('camp_id', $camp->id)->latest()->get();
        $gender = $this->gender;
        return view('admin.camp.patient.index', compact('patients', 'gender', 'camp'));
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
            'registration_date' => 'required|date',
            'name' => 'required',
            'gender' => 'required',
            'age' => 'required',
            'address' => 'required',
            'mobile' => 'required|numeric|digits:10',
            'notes' => 'nullable',
            'camp_id' => 'required',
        ]);
        try {
            $inputs['camp_id'] = decrypt($request->camp_id);
            $inputs['created_by'] = $request->user()->id;
            $inputs['updated_by'] = $request->user()->id;
            CampDetail::create($inputs);
        } catch (Exception $e) {
            return redirect()->back()->with("error", $e->getMessage())->withInput($inputs);
        }
        return redirect()->route('camp.patient.list', $request->camp_id)->with("success", "Patient created successfully!");
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
        $patient = CampDetail::findOrFail(decrypt($id));
        $gender = $this->gender;
        return view('admin.camp.patient.edit', compact('patient', 'gender'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $inputs = $request->validate([
            'registration_date' => 'required|date',
            'name' => 'required',
            'gender' => 'required',
            'age' => 'required',
            'address' => 'required',
            'mobile' => 'required|numeric|digits:10',
            'notes' => 'nullable',
        ]);
        try {
            $inputs['updated_by'] = $request->user()->id;
            $campatient = CampDetail::findOrFail(decrypt($id));
            $campatient->update($inputs);
        } catch (Exception $e) {
            return redirect()->back()->with("error", $e->getMessage())->withInput($inputs);
        }
        return redirect()->route('camp.patient.list', encrypt($campatient->camp_id))->with("success", "Patient updated successfully!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $campatient = CampDetail::findOrFail(decrypt($id));
        $campatient->delete();
        return redirect()->route('camp.patient.list', encrypt($campatient->camp_id))->with("success", "Camp deleted successfully!");
    }
}

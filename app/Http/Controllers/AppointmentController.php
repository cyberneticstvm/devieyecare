<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Branch;
use App\Models\Doctor;
use App\Models\Extra;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class AppointmentController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('appointment-list'), only: ['index']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('appointment-create'), only: ['create', 'store']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('appointment-edit'), only: ['edit', 'update']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('appointment-delete'), only: ['destroy']),
        ];
    }

    protected $branches, $gender, $doctors;
    public function __construct()
    {
        $this->branches = Branch::pluck('name', 'id');
        $this->gender = Extra::where('category', 'gender')->pluck('name', 'name');
        $this->doctors = Doctor::pluck('name', 'id');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $appointments = Appointment::withTrashed()->whereDate('adate', '>=', Carbon::today())->orderByDesc('adate')->whereNull('registration_id')->when(!in_array(Auth::user()->roles->first()->name, ['Administrator']), function ($q) {
            return $q->where('branch_id', Session::get('branch')->id);
        })->get();
        $branches = $this->branches;
        $gender = $this->gender;
        $doctors = $this->doctors;
        return view('admin.appointment.index', compact('appointments', 'branches', 'gender', 'doctors'));
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
            'gender' => 'required',
            'age' => 'required',
            'address' => 'required',
            'mobile' => 'required|numeric|digits:10',
            'branch_id' => 'required',
            'doctor_id' => 'required',
            'adate' => 'required',
            'atime' => 'required',
            'email' => 'nullable',
            'old_mrn' => 'nullable',
        ]);
        try {
            $inputs['created_by'] = $request->user()->id;
            $inputs['updated_by'] = $request->user()->id;
            Appointment::create($inputs);
        } catch (Exception $e) {
            return redirect()->back()->with("error", (Str::contains($e->getMessage(), ['1062'])) ? 'Appointment already exists for date, time, branch, and doctor' : $e->getMessage())->withInput($inputs);
        }
        return redirect()->route('appointment.list')->with("success", "Appointment created successfully!");
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
        $appointment = Appointment::findOrFail(decrypt($id));
        $branches = $this->branches;
        $gender = $this->gender;
        $doctors = $this->doctors;
        return view('admin.appointment.edit', compact('appointment', 'branches', 'gender', 'doctors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $inputs = $request->validate([
            'name' => 'required',
            'gender' => 'required',
            'age' => 'required',
            'address' => 'required',
            'mobile' => 'required|numeric|digits:10',
            'branch_id' => 'required',
            'doctor_id' => 'required',
            'adate' => 'required',
            'atime' => 'required',
            'email' => 'nullable',
            'old_mrn' => 'nullable',
        ]);
        try {
            $inputs['updated_by'] = $request->user()->id;
            Appointment::findOrFail(decrypt($id))->update($inputs);
        } catch (Exception $e) {
            return redirect()->back()->with("error", $e->getMessage())->withInput($inputs);
        }
        return redirect()->route('appointment.list')->with("success", "Appointment updated successfully!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Appointment::findOrFail(decrypt($id))->delete();
        return redirect()->route('appointment.list')->with("success", "Appointment deleted successfully!");
    }
}

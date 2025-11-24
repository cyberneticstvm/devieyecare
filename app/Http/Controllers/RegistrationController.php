<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Extra;
use App\Models\Registration;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class RegistrationController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('registration-list'), only: ['index']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('registration-create'), only: ['create', 'store']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('registration-edit'), only: ['edit', 'update']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('registration-delete'), only: ['destroy']),
        ];
    }

    protected $ctypes, $gender, $doctors;
    public function __construct()
    {
        $this->ctypes = Extra::where('category', 'ctype')->pluck('name', 'id');
        $this->gender = Extra::where('category', 'gender')->pluck('name', 'name');
        $this->doctors = Doctor::pluck('name', 'id');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $registrations = Registration::withTrashed()->whereDate('created_at', Carbon::today())->when(!in_array(Auth::user()->roles->first()->name, ['Administrator']), function ($q) {
            return $q->where('branch_id', Session::get('branch')->id);
        })->latest()->get();
        return view('admin.registration.index', compact('registrations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(string $rtype, string $typeid)
    {
        $doctors = $this->doctors;
        $ctypes = $this->ctypes;
        $gender = $this->gender;
        $patient = [];
        if ($typeid > 0 && decrypt($rtype) == 'Appointment'):
            $patient = Appointment::findOrFail(decrypt($typeid));
            $rtype = encrypt(getRtypeId('Appointment'));
        endif;
        if ($typeid > 0 && decrypt($rtype) == 'Camp'):
            $rtype = encrypt(getRtypeId('Camp'));
        endif;
        return view('admin.registration.create', compact('doctors', 'ctypes', 'gender', 'rtype', 'typeid', 'patient'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, string $rtype, string $typeid)
    {
        $inputs = $request->validate([
            'name' => 'required',
            'gender' => 'required',
            'age' => 'required',
            'address' => 'required',
            'mobile' => 'required|numeric|digits:10',
            'doctor_id' => 'required',
            'ctype' => 'required',
        ]);
        try {
            $inputs['rtype'] = decrypt($rtype);
            $inputs['rtype_id'] = decrypt($typeid);
            $inputs['created_by'] = $request->user()->id;
            $inputs['updated_by'] = $request->user()->id;
            $inputs['branch_id'] = Session::get('branch')->id;
            $inputs['mrn'] = Registration::max('mrn') + 1 ?? 1;
            $inputs['doc_fee'] = 0;
            DB::transaction(function () use ($inputs) {
                $type = Extra::findOrFail($inputs['rtype']);
                $reg = Registration::create($inputs);
                if ($inputs['rtype_id'] > 0 && ($type->name == 'Appointment')):
                    Appointment::find($inputs['rtype_id'])->update(['registration_id' => $reg->id]);
                endif;
                if ($inputs['rtype_id'] > 0 && ($type->name == 'Camp')):
                //
                endif;
            });
        } catch (Exception $e) {
            return redirect()->back()->with("error", $e->getMessage())->withInput($inputs);
        }
        return redirect()->route('registration.list')->with("success", "Registration completed successfully!");
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
        $doctors = $this->doctors;
        $ctypes = $this->ctypes;
        $gender = $this->gender;
        $registration = Registration::findOrFail(decrypt($id));
        return view('admin.registration.edit', compact('doctors', 'ctypes', 'gender', 'registration'));
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
            'doctor_id' => 'required',
            'ctype' => 'required',
        ]);
        try {
            $inputs['updated_by'] = $request->user()->id;
            $inputs['doc_fee'] = 0;
            Registration::findOrFail(decrypt($id))->update($inputs);
        } catch (Exception $e) {
            return redirect()->back()->with("error", $e->getMessage())->withInput($inputs);
        }
        return redirect()->route('registration.list')->with("success", "Registration updated successfully!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Registration::findOrFail(decrypt($id))->delete();
        return redirect()->route('registration.list')->with("success", "Registration deleted successfully!");
    }
}

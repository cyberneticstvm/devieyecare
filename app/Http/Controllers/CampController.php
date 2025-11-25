<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Camp;
use App\Models\Extra;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CampController extends Controller implements HasMiddleware
{

    public static function middleware(): array
    {
        return [
            new middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('camp-list'), only: ['index']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('camp-create'), only: ['create', 'store']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('camp-edit'), only: ['edit', 'update']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('camp-delete'), only: ['destroy']),
        ];
    }

    protected $gender, $branches;
    public function __construct()
    {
        $this->branches = Branch::pluck('name', 'id');
        $this->gender = Extra::where('category', 'gender')->pluck('name', 'name');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $camps = Camp::withTrashed()->whereDate('from_date', '>=', Carbon::today())->orderByDesc('from_date')->when(!in_array(Auth::user()->roles->first()->name, ['Administrator']), function ($q) {
            return $q->where('branch_id', Session::get('branch')->id);
        })->get();
        $branches = $this->branches;
        $gender = $this->gender;
        return view('admin.camp.index', compact('camps', 'branches', 'gender'));
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
            'from_date' => 'required|date',
            'to_date' => 'required|date',
            'venue' => 'required',
            'address' => 'required',
            'coordinator' => 'required',
            'branch_id' => 'required',
        ]);
        try {
            $inputs['created_by'] = $request->user()->id;
            $inputs['updated_by'] = $request->user()->id;
            Camp::create($inputs);
        } catch (Exception $e) {
            return redirect()->back()->with("error", $e->getMessage())->withInput($inputs);
        }
        return redirect()->route('camp.list')->with("success", "Camp created successfully!");
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
        $camp = Camp::findOrFail(decrypt($id));
        $branches = $this->branches;
        $gender = $this->gender;
        return view('admin.camp.edit', compact('camp', 'branches', 'gender'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $inputs = $request->validate([
            'from_date' => 'required|date',
            'to_date' => 'required|date',
            'venue' => 'required',
            'address' => 'required',
            'coordinator' => 'required',
            'branch_id' => 'required',
        ]);
        try {
            $inputs['updated_by'] = $request->user()->id;
            Camp::findOrFail(decrypt($id))->update($inputs);
        } catch (Exception $e) {
            return redirect()->back()->with("error", $e->getMessage())->withInput($inputs);
        }
        return redirect()->route('camp.list')->with("success", "Camp updated successfully!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Camp::findOrFail(decrypt($id))->delete();
        return redirect()->route('camp.list')->with("success", "Camp deleted successfully!");
    }
}

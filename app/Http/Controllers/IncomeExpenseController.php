<?php

namespace App\Http\Controllers;

use App\Models\Extra;
use App\Models\Head;
use App\Models\IncomeExpense;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class IncomeExpenseController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('ie-list'), only: ['index']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('ie-create'), only: ['create', 'store']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('ie-edit'), only: ['edit', 'update']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('ie-delete'), only: ['destroy']),
        ];
    }

    protected $heads, $category;
    public function __construct(Request $request)
    {
        $this->category = Extra::where('category', 'head')->where('name', $request->category)->firstOrFail();
        $this->heads = Head::where('category_id', $this->category->id)->pluck('name', 'id');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $category = $this->category;
        $heads = $this->heads;
        $ies = IncomeExpense::withTrashed()->where('category_id', $category->id)->whereDate('ie_date', Carbon::today())->when(!in_array(Auth::user()->roles->first()->name, ['Administrator']), function ($q) {
            return $q->where('branch_id', Session::get('branch')->id);
        })->latest()->get();
        return view('admin.ie.index', compact('heads', 'category', 'ies'));
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
            'ie_date' => 'required|date',
            'amount' => 'required|numeric|min:1',
            'head_id' => 'required',
            'description' => 'nullable',
        ]);
        try {
            if (isExpenseExceeded($request->amount, $this->category->id, 'store')):
                throw new Exception("Today's limit exceeded!");
            endif;
            $inputs['branch_id'] = Session::get('branch')->id;
            $inputs['category_id'] = $this->category->id;
            $inputs['created_by'] = $request->user()->id;
            $inputs['updated_by'] = $request->user()->id;
            IncomeExpense::create($inputs);
        } catch (Exception $e) {
            return redirect()->back()->with("error", $e->getMessage())->withInput($inputs);
        }
        return redirect()->route('ie.list', $this->category->name)->with("success", $this->category->name . " created successfully!");
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
    public function edit(string $category, string $id)
    {
        $category = $this->category;
        $heads = $this->heads;
        $ie = IncomeExpense::findOrFail(decrypt($id));
        return view('admin.ie.edit', compact('heads', 'category', 'ie'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $category, string $id)
    {
        $inputs = $request->validate([
            'ie_date' => 'required|date',
            'amount' => 'required|numeric|min:1',
            'head_id' => 'required',
            'description' => 'nullable',
        ]);
        try {
            $exp =  IncomeExpense::findOrFail(decrypt($id));
            if (isExpenseExceeded($request->amount, $this->category->id, 'update', $exp)):
                throw new Exception("Today's limit exceeded!");
            endif;
            $inputs['updated_by'] = $request->user()->id;
            $exp->update($inputs);
        } catch (Exception $e) {
            return redirect()->back()->with("error", $e->getMessage())->withInput($inputs);
        }
        return redirect()->route('ie.list', $this->category->name)->with("success", $this->category->name . " updated successfully!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $category, string $id)
    {
        IncomeExpense::findOrFail(decrypt($id))->delete();
        return redirect()->route('ie.list', $this->category->name)->with("success", $this->category->name . " deleted successfully!");
    }
}

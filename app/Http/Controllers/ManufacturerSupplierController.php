<?php

namespace App\Http\Controllers;

use App\Models\ManufacturerSupplier;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class ManufacturerSupplierController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('ms-list'), only: ['index']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('ms-create'), only: ['create', 'store']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('ms-edit'), only: ['edit', 'update']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('ms-delete'), only: ['destroy']),
        ];
    }

    protected $category;
    public function __construct(Request $request)
    {
        $this->category = $request->category;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $category = $this->category;
        $mss = ManufacturerSupplier::withTrashed()->where('category', $category)->orderBy('name')->get();
        return view('admin.ms.index', compact('mss', 'category'));
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
            'address' => 'required',
        ]);
        try {
            $inputs['category'] = $this->category;
            $inputs['created_by'] = $request->user()->id;
            $inputs['updated_by'] = $request->user()->id;
            ManufacturerSupplier::create($inputs);
        } catch (Exception $e) {
            return redirect()->back()->with("error", $e->getMessage())->withInput($inputs);
        }
        return redirect()->route('ms.list', $this->category)->with("success", $this->category . " created successfully!");
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
        $ms = ManufacturerSupplier::findOrFail(decrypt($id));
        return view('admin.ms.edit', compact('ms', 'category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $category, string $id)
    {
        $inputs = $request->validate([
            'name' => 'required',
            'mobile' => 'required|numeric|digits:10',
            'address' => 'required',
        ]);
        try {
            $inputs['updated_by'] = $request->user()->id;
            ManufacturerSupplier::findOrFail(decrypt($id))->update($inputs);
        } catch (Exception $e) {
            return redirect()->back()->with("error", $e->getMessage())->withInput($inputs);
        }
        return redirect()->route('ms.list', $this->category)->with("success", $this->category . " created successfully!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $category, string $id)
    {
        ManufacturerSupplier::findOrFail(decrypt($id))->delete();
        return redirect()->route('ms.list', $this->category)->with("success", $this->category . " deleted successfully!");
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\FixedAsset;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class FixedAssetController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('fixed-asset-list'), only: ['index']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('fixed-asset-create'), only: ['create', 'store']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('fixed-asset-edit'), only: ['edit', 'update']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('fixed-asset-delete'), only: ['destroy']),
        ];
    }

    protected $branches;
    public function __construct()
    {
        $this->branches = Branch::pluck('name', 'id');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $fas = FixedAsset::withTrashed()->latest()->get();
        $branches = $this->branches;
        return view("admin.fixed_asset.index", compact('fas', 'branches'));
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
            'qty' => 'required',
            'branch_id' => 'required',
        ]);
        try {
            $inputs['created_by'] = $request->user()->id;
            $inputs['updated_by'] = $request->user()->id;
            FixedAsset::create($inputs);
        } catch (Exception $e) {
            return redirect()->back()->with("error", $e->getMessage())->withInput($inputs);
        }
        return redirect()->route('fa.list')->with("success", "Asset created successfully!");
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
        $fa = FixedAsset::findOrFail(decrypt($id));
        $branches = $this->branches;
        return view('admin.fixed_asset.edit', compact('fa', 'branches'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $inputs = $request->validate([
            'name' => 'required',
            'qty' => 'required',
            'branch_id' => 'required',
        ]);
        try {
            $inputs['updated_by'] = $request->user()->id;
            $fa = FixedAsset::findOrFail(decrypt($id));
            $fa->update($inputs);
        } catch (Exception $e) {
            return redirect()->back()->with("error", $e->getMessage())->withInput($inputs);
        }
        return redirect()->route('fa.list')->with("success", "Asset updated successfully!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $fa = FixedAsset::findOrFail(decrypt($id));
        $fa->delete();
        return redirect()->route('fa.list')->with("success", "Asset deleted successfully!");
    }
}

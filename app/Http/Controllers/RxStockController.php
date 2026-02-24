<?php

namespace App\Http\Controllers;

use App\Models\Extra;
use App\Models\Material;
use App\Models\RxStock;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class RxStockController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('rx-stock-list'), only: ['index']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('rx-stock-create'), only: ['create', 'store']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('rx-stock-edit'), only: ['edit', 'update']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('rx-stock-delete'), only: ['destroy']),
        ];
    }

    protected $products, $axis, $dia, $statuses;
    public function __construct()
    {
        $axis = [];
        for ($i = 0; $i <= 180; $i++):
            $axis[$i] = $i;
        endfor;
        $this->axis = $axis;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rxstock = RxStock::withTrashed()->latest()->get();
        $extras = Extra::whereIn('category', ['sph', 'cyl', 'addition'])->get();
        $axis = $this->axis;
        $materials = Material::latest()->pluck("name", "id");
        return view('admin.rx.index', compact('rxstock', 'materials', 'extras', 'axis'));
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
            "material_id" => "required",
            "sph" => "nullable",
            "cyl" => "nullable",
            "axis" => "nullable",
            "addition" => "nullable",
            "qty" => "nullable",
        ]);
        RxStock::create($inputs);
        return redirect()->route('rx.list')->with("success", "Rx Stock created successfully!");
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        RxStock::findOrFail(decrypt($id))->delete();
        return redirect()->route('rx.list')->with("success", "Rx Stock deleted successfully!");
    }
}

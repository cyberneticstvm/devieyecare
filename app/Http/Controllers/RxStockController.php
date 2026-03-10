<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Extra;
use App\Models\Material;
use App\Models\Product;
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

    protected $axis, $materials;
    public function __construct()
    {
        $axis = [];
        for ($i = 0; $i <= 180; $i++):
            $axis[$i] = $i;
        endfor;
        $this->axis = $axis;
        $products = Product::selectRaw("CONCAT('product', '-', id) AS id, name, 'product' AS type");
        $this->materials = Material::selectRaw("CONCAT('material', '-', id) AS id, name, 'material' AS type")->unionAll($products);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rxstock = RxStock::withTrashed()->where("transaction_type", "purchase")->latest()->get();
        $extras = Extra::whereIn('category', ['sph', 'cyl', 'addition'])->get();
        $axis = $this->axis;
        $materials = $this->materials;
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
            "eye" => "nullable",
            "material_id" => "required",
            "sph" => "nullable",
            "cyl" => "nullable",
            "axis" => "nullable",
            "addition" => "nullable",
            "qty" => "nullable",
            "location" => "nullable"
        ]);
        $data = $inputs;
        $data['type'] = explode('-', $request->material_id)[0];
        $data['material_id'] = explode('-', $request->material_id)[1];
        $data['to_branch'] = Branch::where("is_store", 1)->first()->id;
        $data['from_branch'] = 0;
        $data['transaction_type'] = "purchase";
        RxStock::create($data);
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

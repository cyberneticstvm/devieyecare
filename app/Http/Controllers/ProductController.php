<?php

namespace App\Http\Controllers;

use App\Models\Extra;
use App\Models\Hsn;
use App\Models\ManufacturerSupplier;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('product-list'), only: ['index']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('product-create'), only: ['create', 'store']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('product-edit'), only: ['edit', 'update']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('product-delete'), only: ['destroy']),
        ];
    }

    protected $products, $hsns, $manufacturers, $ftypes, $fmaterial, $avatars, $brands;
    public function __construct()
    {
        $this->products = Product::withTrashed()->orderBy('name')->get();
        $this->hsns = Hsn::orderBy('name')->pluck('name', 'id');
        $this->manufacturers = ManufacturerSupplier::where('category', 'Manufacturer')->orderBy('name')->pluck('name', 'id');
        $this->ftypes = Extra::where("category", "frame_type")->pluck("name", "id");
        $this->fmaterial = Extra::where("category", "frame_material")->pluck("name", "id");
        $this->brands = Extra::where("category", "brand")->pluck("name", "id");
        $this->avatars = array("gents" => "Gents", "ladies" => "Ladies", "kids" => "Kids", "all" => "All");
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = $this->products;
        return view('admin.product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $hsns = $this->hsns;
        $manufacturers = $this->manufacturers;
        $ftypes = $this->ftypes;
        $fmaterial = $this->fmaterial;
        $avatars = $this->avatars;
        $brands = $this->brands;
        return view('admin.product.create', compact('hsns', 'manufacturers', 'ftypes', 'fmaterial', 'avatars', 'brands'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $inputs = $request->validate([
            'name' => 'required|unique:products,name',
            'hsn_id' => 'required',
            'manufacturer_id' => 'required',
            'selling_price' => 'required|numeric|min:1',
            'default_delivery_days' => 'required|numeric|min:1',
            'eligible_for_adviser' => 'required',
            'description' => 'nullable',
            'frame_type' => 'nullable',
            'material' => 'nullable',
            'avatar' => 'nullable',
            'dia' => 'nullable',
            'temple_size' => 'nullable',
            'bridge_size' => 'nullable',
            'weight' => 'nullable',
            'model_name' => 'nullable',
            'brand' => 'nullable',
            'product_image' => 'nullable',
        ]);
        try {
            $hsn = Hsn::findOrFail($inputs['hsn_id']);
            $inputs['created_by'] = $request->user()->id;
            $inputs['updated_by'] = $request->user()->id;
            $inputs['code'] = $hsn->short_name . '' . Product::where('hsn_id', $hsn->id)->max('id') + 1 ?? 1;
            if ($request->file('product_image')):
                $attachment = $request->file('product_image');
                $fname = time() . '_' . $attachment->getClientOriginalName();
                $storeFile = $attachment->storeAs('/product', $fname, 'gcs');
                $url = Storage::disk('gcs')->url($storeFile);
                $inputs['img'] = $url;
            endif;
            Product::create($inputs);
        } catch (Exception $e) {
            return redirect()->back()->with("error", $e->getMessage())->withInput($inputs);
        }
        return redirect()->route('product.list')->with("success", "Product created successfully!");
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
        $product = Product::findOrFail(decrypt($id));
        $hsns = $this->hsns;
        $manufacturers = $this->manufacturers;
        $ftypes = $this->ftypes;
        $fmaterial = $this->fmaterial;
        $avatars = $this->avatars;
        $brands = $this->brands;
        return view('admin.product.edit', compact('hsns', 'manufacturers', 'product', 'ftypes', 'fmaterial', 'avatars', 'brands'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $inputs = $request->validate([
            'name' => 'required|unique:products,name,' . decrypt($id),
            'manufacturer_id' => 'required',
            'selling_price' => 'required|numeric|min:1',
            'default_delivery_days' => 'required|numeric|min:1',
            'eligible_for_adviser' => 'required',
            'description' => 'nullable',
            'frame_type' => 'nullable',
            'material' => 'nullable',
            'avatar' => 'nullable',
            'dia' => 'nullable',
            'temple_size' => 'nullable',
            'bridge_size' => 'nullable',
            'weight' => 'nullable',
            'model_name' => 'nullable',
            'brand' => 'nullable',
            'product_image' => 'nullable',
        ]);
        try {
            $inputs['updated_by'] = $request->user()->id;
            if ($request->file('product_image')):
                $attachment = $request->file('product_image');
                $fname = time() . '_' . $attachment->getClientOriginalName();
                $storeFile = $attachment->storeAs('/product', $fname, 'gcs');
                $url = Storage::disk('gcs')->url($storeFile);
                $inputs['img'] = $url;
            endif;
            Product::findOrFail(decrypt($id))->update($inputs);
        } catch (Exception $e) {
            return redirect()->back()->with("error", $e->getMessage())->withInput($inputs);
        }
        return redirect()->route('product.list')->with("success", "Product updated successfully!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Product::findOrFail(decrypt($id))->delete();
        return redirect()->route('product.list')->with("success", "Product deleted successfully!");
    }
}

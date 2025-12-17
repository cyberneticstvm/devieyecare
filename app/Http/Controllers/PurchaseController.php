<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\ManufacturerSupplier;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseDetail;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller implements HasMiddleware
{

    public static function middleware(): array
    {
        return [
            new middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('purchase-list'), only: ['index']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('purchase-create'), only: ['create', 'store']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('purchase-edit'), only: ['edit', 'update']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('purchase-delete'), only: ['destroy']),
        ];
    }

    protected $products, $suppliers;
    public function __construct()
    {
        $this->products = Product::orderBy('name')->pluck('name', 'id');
        $this->suppliers = ManufacturerSupplier::where('category', 'Supplier')->orderBy('name')->pluck('name', 'id');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $purchases = Purchase::withTrashed()->get();
        return view('admin.purchase.index', compact('purchases'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = $this->products;
        $suppliers = $this->suppliers;
        return view('admin.purchase.create', compact('products', 'suppliers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $inputs = $request->validate([
            'supplier_id' => 'required',
            'pdate' => 'required|date',
            'invoice' => 'required',
            'notes' => 'nullable',
        ]);
        try {
            DB::transaction(function () use ($request, $inputs) {
                $inputs['created_by'] = $request->user()->id;
                $inputs['updated_by'] = $request->user()->id;
                $inputs['branch_id'] = Branch::where('is_store', 1)->first()->id;
                $purchase = Purchase::create($inputs);
                $data = [];
                foreach ($request->product_id as $key => $item):
                    $data[] = [
                        'purchase_id' => $purchase->id,
                        'product_id' => $item,
                        'qty' => $request->qty[$key],
                        'batch' => $request->batch[$key] ?? 'NA',
                        'expiry' => $request->expiry[$key],
                        'purchase_price' => $request->purchase_price[$key] ?? 0,
                        'selling_price' => $request->selling_price[$key] ?? 0,
                        'total' => $request->purchase_price[$key] * $request->qty[$key],
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ];
                endforeach;
                PurchaseDetail::insert($data);
            });
        } catch (Exception $e) {
            return redirect()->back()->with("error", $e->getMessage())->withInput($inputs);
        }
        return redirect()->route('purchase.list')->with("success", "Purchase created successfully!");
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
        $products = $this->products;
        $suppliers = $this->suppliers;
        $purchase = Purchase::findOrFail(decrypt($id));
        return view('admin.purchase.edit', compact('products', 'suppliers', 'purchase'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $inputs = $request->validate([
            'supplier_id' => 'required',
            'pdate' => 'required|date',
            'invoice' => 'required',
            'notes' => 'nullable',
        ]);
        try {
            DB::transaction(function () use ($request, $inputs, $id) {
                $inputs['updated_by'] = $request->user()->id;
                $purchase = Purchase::findOrFail(decrypt($id));
                $purchase->update($inputs);
                $data = [];
                foreach ($request->product_id as $key => $item):
                    $data[] = [
                        'purchase_id' => $purchase->id,
                        'product_id' => $item,
                        'qty' => $request->qty[$key],
                        'batch' => $request->batch[$key] ?? 'NA',
                        'expiry' => $request->expiry[$key],
                        'purchase_price' => $request->purchase_price[$key] ?? 0,
                        'selling_price' => $request->selling_price[$key] ?? 0,
                        'total' => $request->purchase_price[$key] * $request->qty[$key],
                        'created_at' => $purchase->created_at,
                        'updated_at' => $purchase->updated_at,
                    ];
                endforeach;
                PurchaseDetail::where('purchase_id', $purchase->id)->delete();
                PurchaseDetail::insert($data);
            });
        } catch (Exception $e) {
            return redirect()->back()->with("error", $e->getMessage())->withInput($inputs);
        }
        return redirect()->route('purchase.list')->with("success", "Purchase updated successfully!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Purchase::findOrFail(decrypt($id))->delete();
        return redirect()->route('purchase.list')->with("success", "Purchase deleted successfully!");
    }
}

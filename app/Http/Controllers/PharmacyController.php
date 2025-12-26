<?php

namespace App\Http\Controllers;

use App\Models\Extra;
use App\Models\Hsn;
use App\Models\Pharmacy;
use App\Models\PharmacyDetail;
use App\Models\Product;
use App\Models\Registration;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\DB;

class PharmacyController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('pharmacy-order-list'), only: ['index']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('pharmacy-order-create'), only: ['create', 'store']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('pharmacy-order-edit'), only: ['edit', 'update']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('pharmacy-order-delete'), only: ['destroy']),
        ];
    }

    protected $products, $pmodes;
    public function __construct()
    {
        $this->products = Product::whereIn('hsn_id', Hsn::whereIn('name', ['Ointment', 'Eye Drop', 'Tablet'])->pluck('id'))->pluck('name', 'id');
        $this->pmodes = Extra::where('category', 'pmode')->pluck('name', 'id');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Pharmacy::withTrashed()->whereDate('created_at', Carbon::today())->when(!in_array(Auth::user()->roles->first()->name, ['Administrator']), function ($q) {
            return $q->where('branch_id', Session::get('branch')->id);
        })->latest()->get();
        return view('admin.order.pharmacy.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(string $id)
    {
        $registration = Registration::findOrFail(decrypt($id));
        $order = Pharmacy::where('registration_id', $registration->id)->first();
        $products = $this->products;
        $pmodes = $this->pmodes;
        return view('admin.order.pharmacy.create', compact('order', 'registration', 'products', 'pmodes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $inputs = $request->validate([
            'branch_id' => 'required',
            'registration_id' => 'required',
            'pmode' => 'required',
            'discount' => 'nullable',
        ]);
        try {
            DB::transaction(function () use ($request, $inputs) {
                $inputs['invoice_number'] = Pharmacy::max('invoice_number') + 1 ?? 1;
                $inputs['total'] = 0;
                $inputs['discount'] = $request->discount ?? 0;
                $inputs['registration_id'] = decrypt($request->registration_id);
                $inputs['created_by'] = $request->user()->id;
                $inputs['updated_by'] = $request->user()->id;
                $pharmacy = Pharmacy::create($inputs);
                $data = [];
                foreach ($request->product_id as $key => $item):
                    $data[] = [
                        'pharmacy_id' => $pharmacy->id,
                        'product_id' => $item,
                        'batch' => $request->batch[$key],
                        'expiry' => $request->expiry[$key],
                        'qty' => $request->qty[$key],
                        'price' => $request->price[$key],
                        'total' => $request->total[$key],
                        'created_at' => $pharmacy->created_at,
                        'updated_at' => $pharmacy->updated_at,
                    ];
                endforeach;
                PharmacyDetail::insert($data);
                $pharmacy->update(['total' => $pharmacy->details->sum('total')]);
            });
        } catch (Exception $e) {
            return redirect()->back()->with("error", $e->getMessage())->withInput($inputs);
        }
        return redirect()->route('pharmacy.order.list')->with("success", "Pharmacy created successfully!");
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
        $order = Pharmacy::findOrFail(decrypt($id));
        $products = $this->products;
        $pmodes = $this->pmodes;
        $registration = Registration::findOrFail($order->registration_id);
        return view('admin.order.pharmacy.create', compact('order', 'registration', 'products', 'pmodes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $inputs = $request->validate([
            'pmode' => 'required',
            'discount' => 'nullable',
        ]);
        try {
            DB::transaction(function () use ($request, $inputs, $id) {
                $pharmacy = Pharmacy::findOrFail(decrypt($id));
                $inputs['updated_by'] = $request->user()->id;
                $inputs['discount'] = $request->discount ?? 0;
                $pharmacy->update($inputs);
                $data = [];
                foreach ($request->product_id as $key => $item):
                    $data[] = [
                        'pharmacy_id' => $pharmacy->id,
                        'product_id' => $item,
                        'batch' => $request->batch[$key],
                        'expiry' => $request->expiry[$key],
                        'qty' => $request->qty[$key],
                        'price' => $request->price[$key],
                        'total' => $request->total[$key],
                        'created_at' => $pharmacy->created_at,
                        'updated_at' => $pharmacy->updated_at,
                    ];
                endforeach;
                PharmacyDetail::where('pharmacy_id', $pharmacy->id)->delete();
                PharmacyDetail::insert($data);
                $pharmacy->update(['total' => $pharmacy->details->sum('total')]);
            });
        } catch (Exception $e) {
            return redirect()->back()->with("error", $e->getMessage())->withInput($inputs);
        }
        return redirect()->route('pharmacy.order.list')->with("success", "Pharmacy updated successfully!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Pharmacy::findOrFail(decrypt($id))->delete();
        return redirect()->route('pharmacy.order.list')->with("success", "Pharmacy deleted successfully!");
    }
}

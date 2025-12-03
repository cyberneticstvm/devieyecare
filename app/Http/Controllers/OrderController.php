<?php

namespace App\Http\Controllers;

use App\Models\Extra;
use App\Models\Hsn;
use App\Models\Order;
use App\Models\Product;
use App\Models\Registration;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $products;
    public function __construct()
    {
        $this->products = Product::whereIn('hsn_id', Hsn::whereIn('name', ['Frame', 'Lens'])->pluck('id'))->get();
    }
    public function index()
    {
        //
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
        //
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
        $registration = Registration::findOrFail(decrypt($id));
        $extras = Extra::whereIn('category', ['thickness'])->get();
        $products = $this->products;
        $order = Order::where('registration_id', $registration->id)->first();
        return view('admin.order.store.edit', compact('registration', 'order', 'extras', 'products'));
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
        //
    }
}

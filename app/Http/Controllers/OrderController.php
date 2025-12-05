<?php

namespace App\Http\Controllers;

use App\Models\Extra;
use App\Models\Hsn;
use App\Models\Order;
use App\Models\Product;
use App\Models\Registration;
use App\Models\User;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $products, $axis, $dia;
    public function __construct()
    {
        $this->products = Product::whereIn('hsn_id', Hsn::whereIn('name', ['Frame', 'Lens'])->pluck('id'))->get();
        $axis = [];
        $dia = [];
        for ($i = 0; $i <= 180; $i++):
            $axis[$i] = $i;
        endfor;
        for ($i = 50; $i <= 75; $i++):
            $dia[$i] = $i;
        endfor;
        $this->axis = $axis;
        $this->dia = $dia;
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
        $extras = Extra::whereIn('category', ['thickness', 'sph', 'cyl', 'addition', 'pmode'])->get();
        $products = $this->products;
        $axis = $this->axis;
        $dia = $this->dia;
        $order = Order::where('registration_id', $registration->id)->first();
        $advisors = User::role(requiredRoles()[1])->pluck('name', 'id');
        return view('admin.order.store.edit', compact('registration', 'order', 'extras', 'products', 'axis', 'dia', 'advisors'));
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

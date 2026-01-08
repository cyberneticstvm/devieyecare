<?php

namespace App\Http\Controllers;

use App\Models\Extra;
use App\Models\Hsn;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderStatus;
use App\Models\Product;
use App\Models\Registration;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class OrderController extends Controller implements HasMiddleware
{

    public static function middleware(): array
    {
        return [
            new middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('store-order-list'), only: ['index']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('store-order-create'), only: ['create', 'store']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('store-order-edit'), only: ['edit', 'update']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('store-order-delete'), only: ['destroy']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    protected $products, $axis, $dia, $statuses;
    public function __construct()
    {
        $this->products = Product::whereIn('hsn_id', Hsn::whereIn('name', ['Frame', 'Lens'])->pluck('id'))->get();
        $this->statuses = Extra::where('category', 'order')->pluck('name', 'name');
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
        $orders = Order::withTrashed()->whereDate('created_at', Carbon::today())->when(!in_array(Auth::user()->roles->first()->name, ['Administrator']), function ($q) {
            return $q->where('branch_id', Session::get('branch')->id);
        })->latest()->get();
        $statuses = $this->statuses;
        return view('admin.order.store.index', compact('orders', 'statuses'));
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
    public function edit(string $id, string $source)
    {
        try {
            if ($source == 'order'):
                $order = Order::findOrFail(decrypt($id));
                $registration = Registration::findOrFail($order->registration_id);
            else:
                $registration = Registration::findOrFail(decrypt($id));
                $order = Order::withTrashed()->where('registration_id', $registration->id)->latest()->first();
            endif;
            if ($order?->deleted_at):
                throw new Exception('Order has been deleted and cannot be edited');
            endif;
            if ($order?->invoice_number):
                throw new Exception('Invoice has been generated and cannot be edited');
            endif;
            $extras = Extra::whereIn('category', ['thickness', 'sph', 'cyl', 'addition', 'pmode'])->get();
            $products = $this->products;
            $axis = $this->axis;
            $dia = $this->dia;
            $advisors = User::role(requiredRoles()[1])->pluck('name', 'id');
        } catch (Exception $e) {
            return redirect()->back()->with("error", $e->getMessage());
        }
        return view('admin.order.store.edit', compact('registration', 'order', 'extras', 'products', 'axis', 'dia', 'advisors', 'order'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            DB::transaction(function () use ($request, $id) {
                Registration::where('id', $id)->update([
                    'doc_fee_pmode' => $request->doc_fee_pmode,
                    'surgery_advised' => $request->surgery_advised,
                    'post_review_date' => $request->post_review_date,
                ]);
                $order = Order::updateOrCreate(
                    ['id' => decrypt($request->oid)],
                    [
                        'registration_id' => $id,
                        'branch_id' => Session::get('branch')->id,
                        'discount' => $request->discount ?? 0,
                        'total' => $request->total, // total after discount
                        'advance' => $request->advance ?? 0,
                        'advance_pmode' => $request->advance_pmode,
                        'due_date' => $request->due_date,
                        'status' => getOrderStatus('BKD', 'order'),
                        'remarks' => $request->remarks,
                        'product_advisor' => $request->product_advisor,
                        'created_by' => $request->user()->id,
                        'updated_by' => $request->user()->id,
                    ]
                );
                updateOrderStatus($order, ($request->invoice) ? true : false);
                $data = [];
                foreach ($request->product as $key => $item):
                    if ($item > 0 && $request->qty[$key] > 0):
                        $data[] = [
                            'order_id' => $order->id,
                            'eye' => $request->eye[$key],
                            'sph' => $request->sph[$key],
                            'cyl' => $request->cyl[$key],
                            'axis' => $request->axis[$key],
                            'addition' => $request->add[$key],
                            'dia' => $request->dia[$key],
                            'thick' => $request->thickness[$key],
                            'ipd' => $request->ipd[$key],
                            'product_id' => $item,
                            'qty' => $request->qty[$key],
                            'price' => $request->price[$key],
                            'total' => $request->qty[$key] * $request->price[$key],
                            'created_at' => $order->created_at,
                            'updated_at' => $order->updated_at,
                        ];
                    endif;
                endforeach;
                OrderDetail::where('order_id', $order->id)->delete();
                OrderDetail::insert($data);
            });
        } catch (Exception $e) {
            return redirect()->back()->with("error", $e->getMessage())->withInput($request->all());
        }
        return redirect()->route('registration.list')->with("success", "Order updated successfully!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $order = Order::findOrFail(decrypt($id));
        $order->payments()->delete();
        $order->ostatus()->delete();
        $order->delete();
        return redirect()->route('store.order.list')->with("success", "Order deleted successfully!");
    }
}

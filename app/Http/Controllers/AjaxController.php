<?php

namespace App\Http\Controllers;

use App\Models\Extra;
use App\Models\Hsn;
use App\Models\IncomeExpense;
use App\Models\Order;
use App\Models\Product;
use App\Models\PurchaseDetail;
use App\Models\Registration;
use App\Models\VehiclePayment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AjaxController extends Controller
{
    protected $branch, $ostatus;
    function __construct()
    {
        $this->branch = Session::get('branch')->id;
        $this->ostatus = getOrderStatus('DLVD', 'order');
    }

    function getRegOrder(Request $request)
    {
        $branch = $this->branch;
        $ostatus = $this->ostatus->id;
        $orders = DB::table('extras AS e')->leftJoin('orders AS o', function ($q) use ($branch) {
            $q->on('o.created_at', '>=', DB::raw('LAST_DAY(CURRENT_DATE) + INTERVAL 1 DAY - INTERVAL e.id MONTH'))->on('o.created_at', '<', DB::raw('LAST_DAY(CURRENT_DATE) + INTERVAL 1 DAY - INTERVAL e.id MONTH + INTERVAL 1 MONTH'))->where('o.branch_id', $branch);
        })->where('e.id', '<=', 12)->selectRaw("LAST_DAY(CURRENT_DATE) + INTERVAL 1 DAY - INTERVAL e.id MONTH AS date, COUNT(CASE WHEN o.deleted_at IS NULL THEN o.id END) AS ocount, COUNT(CASE WHEN o.deleted_at IS NULL AND o.status = $ostatus THEN o.id END) AS dcount, CONCAT_WS('/', DATE_FORMAT(LAST_DAY(CURRENT_DATE) + INTERVAL 1 DAY - INTERVAL e.id MONTH, '%b'), DATE_FORMAT(LAST_DAY(CURRENT_DATE) + INTERVAL 1 DAY - INTERVAL e.id MONTH, '%y')) AS month")->groupBy('date', 'e.id')->orderByDesc('date')->get();
        $regs = DB::table('extras AS e')->leftJoin('registrations AS r', function ($q) use ($branch) {
            $q->on('r.created_at', '>=', DB::raw('LAST_DAY(CURRENT_DATE) + INTERVAL 1 DAY - INTERVAL e.id MONTH'))->on('r.created_at', '<', DB::raw('LAST_DAY(CURRENT_DATE) + INTERVAL 1 DAY - INTERVAL e.id MONTH + INTERVAL 1 MONTH'))->where('r.branch_id', $branch);
        })->where('e.id', '<=', 12)->selectRaw("LAST_DAY(CURRENT_DATE) + INTERVAL 1 DAY - INTERVAL e.id MONTH AS date, COUNT(CASE WHEN r.deleted_at IS NULL THEN r.id END) AS rcount, CONCAT_WS('/', DATE_FORMAT(LAST_DAY(CURRENT_DATE) + INTERVAL 1 DAY - INTERVAL e.id MONTH, '%b'), DATE_FORMAT(LAST_DAY(CURRENT_DATE) + INTERVAL 1 DAY - INTERVAL e.id MONTH, '%y')) AS month")->groupBy('date', 'e.id')->orderByDesc('date')->get();
        return response()->json([
            'orders' => $orders,
            'registrations' => $regs,
        ]);
    }

    function getExpenses(Request $request)
    {
        $dates = collect(range(0, 6))
            ->map(function ($i) {
                return Carbon::today()->subDays($i)->format('Y-m-d');
            })
            ->reverse()->values();

        $counts = IncomeExpense::where('category_id', Extra::where('name', 'Expense')->where('category', 'head')->first()->id)->where('branch_id', $this->branch)->whereDate('ie_date', '>=', Carbon::now()->subDays(7))->selectRaw("SUM(amount) AS total, ie_date AS date")->groupBy('date')->pluck('total', 'date');
        $result = $dates->map(function ($date) use ($counts) {
            return [
                'day'  => Carbon::parse($date)->format('d/M'),
                'tot' => $counts[$date] ?? 0 // default to 0 if missing
            ];
        });
        return response()->json([
            'data' => $result,
        ]);
    }

    function getReviews(Request $request)
    {
        $dates = collect(range(0, 29))
            ->map(function ($i) {
                return Carbon::today()->subDays($i)->format('Y-m-d');
            })
            ->reverse()->values();

        $counts = Registration::where('rtype', Extra::where('name', 'Review')->where('category', 'rtype')->first()->id)->where('branch_id', $this->branch)->whereDate('created_at', '>=', Carbon::now()->subDays(30))->selectRaw("COUNT(id) AS total, DATE(created_at) AS date")->groupBy('date')->pluck('total', 'date');
        $result = $dates->map(function ($date) use ($counts) {
            return [
                'day'  => Carbon::parse($date)->format('d/M'),
                'tot' => $counts[$date] ?? 0 // default to 0 if missing
            ];
        });
        return response()->json([
            'data' => $result,
        ]);
    }

    function getProductById(Request $request)
    {
        $product = Product::findOrFail($request->pdctId);
        return response()->json([
            'product' => $product,
        ]);
    }

    function getProducts(Request $request)
    {
        if ($request->type == 'medicine'):
            $products = Product::whereIn('hsn_id', Hsn::whereIn('name', ['Ointment', 'Eye Drop', 'Tablet'])->pluck('id'))->get();
        endif;
        if ($request->type == 'status'):
            $products = Extra::where('category', 'order')->get();
        endif;
        return response()->json([
            'products' => $products,
        ]);
    }

    function getBatch(Request $request)
    {
        $is_expiry = 0;
        if ($request->pdct > 0)
            $is_expiry = Hsn::where('id', Product::find($request->pdct)->hsn_id)->first()->is_expiry;
        $data = getInventory($request->frombr, $request->pdct);
        return response()->json([
            'batch' => $data,
            'is_expiry' => $is_expiry,
        ]);
    }

    function getBatchPrice(Request $request)
    {
        $product = PurchaseDetail::where('product_id', $request->pdct)->where('batch', $request->batch)->first();
        return response()->json([
            'product' => ($product->exists()) ? $product : NULL,
            'status' => ($product->exists()) ? 1 : 0,
        ]);
    }

    function getOrderDetails(Request $request)
    {
        $data = "";
        if ($request->type == 'reg'):
            $order = Order::where('registration_id', decrypt($request->rid))->first();
            if ($order):
                $data .= "<h5>" . $order->registration->getMrn() . "</h5>";
                $data .= "<table class='table table-round border-top w-100'><thead><tr><th>Eye</th><th>SPH</th><th>CYL</th><th>AXIS</th><th>ADD</th><th>DIA</th><th>THICK</th><th>Product</th></tr></thead><tbody>";
                foreach ($order->details as $key => $item):
                    $data .= "<tr>";
                    $data .= "<td>" . $item->eye . "</td>";
                    $data .= "<td>" . $item->sph . "</td>";
                    $data .= "<td>" . $item->cyl . "</td>";
                    $data .= "<td>" . $item->axis . "</td>";
                    $data .= "<td>" . $item->addition . "</td>";
                    $data .= "<td>" . $item->dia . "</td>";
                    $data .= "<td>" . $item->thickness?->name . "</td>";
                    $data .= "<td>" . $item->product->name . "</td>";
                    $data .= "</tr>";
                endforeach;
                $data .= "</tbody></table>";
            else:
                $data = "No records found";
            endif;
        endif;
        return response()->json([
            'data' => $data,
        ]);
    }

    function getExpenseDetails(Request $request)
    {
        $data = "";
        $iecat = Extra::where('name', 'Expense')->where('category', 'head')->first();
        $expenses = IncomeExpense::where('branch_id', $request->branch)->whereDate('created_at', $request->ddate)->where('category_id', $iecat->id)->get();
        $data .= "<table class='table table-round border-top w-100'><thead><tr><th>SL no</th><th>Head</th><th>Desc.</th><th>Amount</th></tr></thead><tbody>";
        foreach ($expenses as $key => $item):
            $data .= "<tr>";
            $data .= "<td>" . $key + 1 . "</td>";
            $data .= "<td>" . $item->head->name . "</td>";
            $data .= "<td>" . $item->description . "</td>";
            $data .= "<td>" . $item->amount . "</td>";
            $data .= "</tr>";
        endforeach;
        $data .= "<tfoot><tr><th colspan='3' class='fw-bold textend'>Total</th><th class='fw-bold'>" . number_format($expenses->sum('amount'), 2) . "</th></tr></tfoot>";
        $data .= "</tbody></table>";
        return response()->json([
            'data' => $data,
        ]);
    }

    function getVPaymentDetails(Request $request)
    {
        $data = "";
        $payments = VehiclePayment::where('branch_id', $request->branch)->whereDate('created_at', $request->ddate)->get();
        $data .= "<table class='table table-round border-top w-100'><thead><tr><th>SL no</th><th>Vehicle</th><th>Pmode</th><th>Notes</th><th>Amount</th></tr></thead><tbody>";
        foreach ($payments as $key => $item):
            $data .= "<tr>";
            $data .= "<td>" . $key + 1 . "</td>";
            $data .= "<td>" . $item->vehicle->registration_number . "</td>";
            $data .= "<td>" . $item->paymode->name . "</td>";
            $data .= "<td>" . $item->notes . "</td>";
            $data .= "<td>" . $item->amount . "</td>";
            $data .= "</tr>";
        endforeach;
        $data .= "<tfoot><tr><th colspan='4' class='fw-bold textend'>Total</th><th class='fw-bold'>" . number_format($payments->sum('amount'), 2) . "</th></tr></tfoot>";
        $data .= "</tbody></table>";
        return response()->json([
            'data' => $data,
        ]);
    }
}

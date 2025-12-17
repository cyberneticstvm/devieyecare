<?php

namespace App\Http\Controllers;

use App\Models\Extra;
use App\Models\Hsn;
use App\Models\Product;
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

    function getProductById(Request $request)
    {
        $product = Product::findOrFail($request->pdctId);
        return response()->json([
            'product' => $product,
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
}

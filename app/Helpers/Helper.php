<?php

/*function uniqueRegistrationId()
{
    do {
        $code = random_int(1000000, 9999999);
    } while (Ad::where("registration_id", $code)->first());

    return $code;
}*/

use App\Models\Branch;
use App\Models\Doctor;
use App\Models\Extra;
use App\Models\Hsn;
use App\Models\IncomeExpense;
use App\Models\LoginLog;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\Payment;
use App\Models\Registration;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

function getInventory($branch = 0, $product = 0)
{
    $is_store = 0;
    if ($branch > 0):
        $is_store = Branch::find($branch)->is_store;
    endif;
    $data = DB::select("SELECT tbl6.*, CONCAT_WS('', tbl6.batch, ' - Avl.Qty: ', tbl6.balanceQty) AS batchwqty FROM (SELECT tbl5.pid, tbl5.pname, tbl5.batch, tbl5.expiry, tbl5.purchasedQty, tbl5.transferInQty, tbl5.transferOutQty, tbl5.pharmacyQty, tbl5.orderQty, (tbl5.pharmacyQty + tbl5.orderQty) AS billedQty, (tbl5.purchasedQty + tbl5.transferInQty) - (tbl5.transferOutQty + tbl5.pharmacyQty + tbl5.orderQty) AS balanceQty FROM (SELECT tbl4.*, IFNULL(SUM(CASE WHEN ph.deleted_at IS NULL AND ph.branch_id = ? THEN pd.qty END), 0) AS pharmacyQty FROM (SELECT tbl3.*, IFNULL(SUM(CASE WHEN o.deleted_at IS NULL AND o.branch_id = ? THEN od.qty END), 0) AS orderQty, 0 AS balanceQty, 0 AS billedQty FROM (SELECT tbl2.*, IFNULL(SUM(CASE WHEN t.deleted_at IS NULL AND t.to_branch = ? THEN td.qty END), 0) AS transferInQty, IFNULL(SUM(CASE WHEN t.deleted_at IS NULL AND t.from_branch = ? THEN td.qty END), 0) AS transferOutQty FROM (SELECT tbl1.pid, tbl1.pname, pd.batch, pd.expiry, IFNULL(SUM(CASE WHEN pur.deleted_at IS NULL AND $is_store = 1 THEN pd.qty END), 0) AS purchasedQty FROM (SELECT p.id AS pid, CONCAT_WS('-', p.name, p.code) AS pname FROM products AS p WHERE IF(? > 0 , p.id = ?, 1)) AS tbl1 LEFT JOIN purchase_details AS pd ON tbl1.pid = pd.product_id LEFT JOIN purchases AS pur ON pur.id = pd.purchase_id GROUP BY pid, pname, batch, expiry) AS tbl2 LEFT JOIN transfer_details AS td on tbl2.pid = td.product_id AND tbl2.batch = td.batch LEFT JOIN transfers AS t ON t.id = td.transfer_id GROUP BY tbl2.pid, tbl2.pname, tbl2.batch, tbl2.expiry, tbl2.purchasedQty) AS tbl3 LEFT JOIN order_details AS od ON od.product_id = tbl3.pid LEFT JOIN orders o ON o.id = od.order_id GROUP BY tbl3.pid, tbl3.pname, tbl3.batch, tbl3.expiry, tbl3.purchasedQty) AS tbl4 LEFT JOIN pharmacy_details AS pd on tbl4.pid = pd.product_id AND tbl4.batch = pd.batch LEFT JOIN pharmacies AS ph ON ph.id = pd.pharmacy_id GROUP BY tbl4.pid, tbl4.pname, tbl4.batch, tbl4.expiry) AS tbl5) AS tbl6 HAVING balanceQty > 0", [$branch, $branch, $branch, $branch, $product, $product]);
    return collect($data);
}

function getDayBook($date, $branch)
{
    $cashpmode = Extra::where('category', 'pmode')->where('name', 'Cash')->first()->id;
    $payments = Payment::leftJoin('orders AS o', 'payments.order_id', 'o.id')->leftJoin('registrations AS r', 'r.id', 'o.registration_id')->selectRaw("r.id, r.name AS cname, r.mrn, r.branch_id, r.status, 0 AS doc_fee_cash, 0 AS doc_fee_card, payments.created_at AS reg_date,'' AS docpmode, 0 AS ph_cash, 0 AS ph_card, '' AS ph_pmode, CASE WHEN payments.pmode = $cashpmode THEN payments.amount END AS advance_cash, CASE WHEN payments.pmode != $cashpmode THEN payments.amount END AS advance_card, payments.pmode AS advance_pmode, 0 AS balance, 0 AS total, 'payment' AS type")->whereNull('payments.deleted_at')->whereDate('payments.pdate', $date)->where('payments.branch_id', $branch);

    $regs = Registration::leftJoin('pharmacies AS p', 'registrations.id', 'p.registration_id')->leftJoin('orders AS o', 'registrations.id', 'o.registration_id')->selectRaw("registrations.id, registrations.name AS cname, registrations.mrn, registrations.branch_id, registrations.status, CASE WHEN registrations.doc_fee_pmode = $cashpmode THEN registrations.doc_fee END AS doc_fee_cash, CASE WHEN registrations.doc_fee_pmode != $cashpmode THEN registrations.doc_fee END AS doc_fee_card, registrations.doc_fee_pmode AS docpmode, registrations.created_at AS reg_date, CASE WHEN p.deleted_at IS NULL AND p.pmode = $cashpmode THEN p.total END AS ph_cash, CASE WHEN p.deleted_at IS NULL AND p.pmode != $cashpmode THEN p.total END AS ph_card, CASE WHEN p.deleted_at IS NULL THEN p.pmode END AS ph_pmode, CASE WHEN o.deleted_at IS NULL AND o.advance_pmode = $cashpmode THEN o.advance END AS advance_cash,
    CASE WHEN o.deleted_at IS NULL AND o.advance_pmode != $cashpmode THEN o.advance END AS advance_card, CASE WHEN o.deleted_at IS NULL THEN o.advance_pmode END AS advance_pmode, CASE WHEN o.deleted_at IS NULL THEN o.total-o.advance END AS balance, CASE WHEN o.deleted_at IS NULL THEN o.total END AS total, 'registration' AS type")->whereDate('registrations.created_at', $date)->where('registrations.branch_id', $branch)->whereNull('registrations.deleted_at')->unionall($payments)->get();
    return collect($regs);
}

function teamId()
{
    return 1;
}

function hsn($name)
{
    return Hsn::where('name', $name)->first();
}

function getRtypeId($rtype)
{
    return Extra::where('category', 'rtype')->where('name', $rtype)->first()->id;
}

function loggedDevice($agent)
{
    $devices = Extra::where('category', 'device')->orderBy('id')->get()->toArray();
    if ($agent->isMobile() && $agent->isAndroidOS()) {
        $device = $devices[1]['name'];
    } elseif ($agent->isTablet()) {
        $device = $devices[2]['name'];
    } elseif ($agent->isMobile() && $agent->isSafari()) {
        $device = $devices[3]['name'];
    } else {
        $device = $devices[0]['name'];
    }
    return $device;
}

function getOrderStatus($status, $type)
{
    return Extra::where('category', $type)->where('name', $status)->orderBy('id')->firstOrFail();
}

function createLoginLog($agent, $location)
{
    $devices = Extra::where('category', 'device')->orderBy('id')->get()->toArray();
    $device = $devices[0]['name'];
    $uid = Str::uuid();
    if ($agent->isMobile() && $agent->isAndroidOS()) {
        $device = $devices[1]['name'];
    } elseif ($agent->isTablet()) {
        $device = $devices[2]['name'];
    } elseif ($agent->isMobile() && $agent->isSafari()) {
        $device = $devices[3]['name'];
    }
    LoginLog::create([
        'user_id' => Auth::user()->id,
        'ip_address' => $location->ip,
        'user_agent' => $device,
        'country' => $location->countryName,
        'region' => $location->regionName,
        'city' => $location->cityName,
        'zipcode' => $location->zipCode,
        'lat' => $location->latitude,
        'lng' => $location->longitude,
        'login_session_id' => $uid,
        'logged_in_at' => Carbon::now(),
    ]);
    User::where('id', Auth::user()->id)->update([
        'login_session_id' => $uid,
    ]);
}

function getCurrentFinancialYear(): string
{
    $now = Carbon::now();
    $financialYearStartMonth = 4; // April

    if ($now->month >= $financialYearStartMonth) {
        $startYear = $now->year;
        $endYear = $now->year + 1;
    } else {
        $startYear = $now->year - 1;
        $endYear = $now->year;
    }

    return substr($startYear, 2, 2) . '-' . substr($endYear, 2, 2); // Format as YYYY/YY
}

function getDocFee($request)
{
    $fee = 0;
    $days = 7;
    $reg = Registration::where('mobile', $request->mobile)->selectRaw("IFNULL(DATEDIFF(now(), created_at), 0) as days")->latest()->first();
    $ctype = Extra::find($request->ctype);
    $diff = ($reg && $reg->days > 0) ? $reg->days : 0;
    if ($diff == 0 || $diff > $days):
        $fee = Doctor::find($request->doctor_id)->value('fee');
    endif;
    if (in_array($ctype->name, ['Surgery'])):
        $fee = 0;
    endif;
    return $fee;
}

function requiredRoles()
{
    return ['Administrator', 'Product Advisor', 'Doctor', 'Pharmacist', 'Optometrist'];
}

function fromBranches()
{
    $brs = Branch::when(!in_array(Auth::user()->roles->first()->name, ['Administrator']), function ($q) {
        return $q->where('id', Session::get('branch')->id);
    })->orderBy('name')->pluck('name', 'id');
    return $brs;
}

function toBranches()
{
    return Branch::whereNot('is_store', 1)->orderBy('name')->pluck('name', 'id');
}

function isExpenseExceeded($amount, $category, $type, $ie = null)
{
    $limit = Session::get('branch')->daily_expense_limit;
    $used = IncomeExpense::whereDate('ie_date', Carbon::today())->where('branch_id', Session::get('branch')->id)->where('category_id', $category)->sum('amount');
    if ($type == 'store'):
        $used = $used + $amount;
    else:
        $used = ($used + $amount) - $ie->amount;
    endif;
    return ($used > $limit) ? true : false;
}

function generateInvoice($order, $amount = 0)
{
    $ino = null;
    $due = getStoreDueAmount($order->registration_id, 0);
    if ($due == $amount):
        $ino = (Order::where('branch_id', Session::get('branch')->id)->max('invoice_number') > 0) ? Order::where('branch_id', Session::get('branch')->id)->max('invoice_number') + 1 : Branch::find(Session::get('branch')->id)->invoice_starts_with;
    else:
        throw new Exception("Cannot generate invoice, due / excess amount is ₹" . $due);
    endif;
    return $ino;
}

function getStoreDueAmount($regId, $amount)
{
    $order = Order::where('registration_id', $regId)->first();
    $paid = Payment::where('order_id', $order->id)->where('order_type', 'Store')->sum('amount');
    if ($amount > 0):
        return (($order->total + $amount) - ($order->advance + $paid));
    else:
        return ($order->total - ($order->advance + $paid));
    endif;
}

function updateOrderStatus($order, $is_invoice = false)
{
    $status = getOrderStatus('BKD', 'order')->id;
    if (!$order->invoice_number && $is_invoice):
        $status = getOrderStatus('DLVD', 'order')->id;
        $order->update([
            'invoice_number' => generateInvoice($order),
            'invoice_generated_at' => Carbon::now(),
            'invoice_generated_by' => Auth::id(),
        ]);
    endif;
    OrderStatus::create([
        'order_id' => $order->id,
        'mrn' => $order->registration->mrn,
        'status_id' => $status,
        'created_by' => Auth::id(),
        'updated_by' => Auth::id(),
    ]);
    $order->update(['status' => $status]);
}

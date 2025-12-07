<?php

/*function uniqueRegistrationId()
{
    do {
        $code = random_int(1000000, 9999999);
    } while (Ad::where("registration_id", $code)->first());

    return $code;
}*/

use App\Models\Doctor;
use App\Models\Extra;
use App\Models\Hsn;
use App\Models\IncomeExpense;
use App\Models\Order;
use App\Models\Registration;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;

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

/*function createLoginLog($agent, $location)
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
        'zip' => $location->zipCode,
        'lat' => $location->latitude,
        'lng' => $location->longitude,
        'login_session_id' => $uid,
        'login_at' => Carbon::now(),
    ]);
    User::where('id', Auth::user()->id)->update([
        'login_session_id' => $uid,
    ]);
}

function getUserBranches()
{
    return Branch::whereIn('id', UserBranch::where('user_id', Auth::id())->pluck('branch_id'))->get();
}

function hsns()
{
    return Hsn::orderBy('name')->get();
}*/

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

function generateInvoice($oid, $is_invoice)
{
    $ino = null;
    $idate = null;
    $order = Order::find($oid); // Existing Order
    if ($order && $order->invoice_number):
        $ino = $order->invoice_number;
        $idate = $order->invoice_generated_at;
    endif;
    if ($is_invoice && !$order->invoice_number):
    // Check pending payment
    endif;
    return array($ino, $idate);
}

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
use App\Models\Registration;

function teamId()
{
    return 1;
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
    $diff = Registration::where('mobile', $request->mobile)->selectRaw("IFNULL(DATEDIFF(now(), created_at), 0) as days")->latest()->first();
    $ctype = Extra::find($request->ctype);
    $diff = ($diff && $diff->days > 0) ? $diff->days : 0;
    if ($diff == 0 || $diff > $days):
        $fee = Doctor::find($request->doctor_id)->value('fee');
    endif;
    if (in_array($ctype->name, ['Surgery'])):
        $fee = 0;
    endif;
    return $fee;
}

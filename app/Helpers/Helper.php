<?php

/*function uniqueRegistrationId()
{
    do {
        $code = random_int(1000000, 9999999);
    } while (Ad::where("registration_id", $code)->first());

    return $code;
}*/

use App\Models\Extra;

function teamId()
{
    return 1;
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

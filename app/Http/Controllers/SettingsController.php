<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class SettingsController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('settings'), only: ['index', 'save']),
        ];
    }

    function index()
    {
        $settings = Setting::find(1);
        return view("admin.settings.index", compact('settings'));
    }

    function save(Request $request)
    {
        $inputs = $request->validate([
            "consultation_fee_waived_days" => "required",
            "consultation_fee_waived_days_for_surgery" => "required",
            "vehicle_fee_per_month" => "required",
            "pdct_advisor_commission_level" => "required",
            "invoice_due_amount_limit" => "required",
            "invoice_due_count_limit" => "required",
            "user_login_allowed_time_from" => "required",
            "user_login_allowed_time_to" => "required",
            "user_active_time_from" => "required",
            "user_active_time_to" => "required",
        ]);
        Setting::findorFail(1)->update($inputs);
        return redirect()->back()->with("success", "Settings updated successfully!");
    }
}

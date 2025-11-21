<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Extra;
use App\Models\User;
use App\Models\UserBranch;
use Exception;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;
use Stevebauman\Location\Facades\Location;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class AuthController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('dashboard'), only: ['index']),
        ];
    }

    function loginPage()
    {
        return view('login');
    }

    function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        try {
            $remember = $request->has('remember');
            if (Auth::attempt($credentials, $remember)):
                $agent = new Agent();
                $location = Location::get($request->ip);
                $user = User::find(Auth::user()->id);
                $devices = Extra::where('category', 'device')->whereIn('id', $user->devices()?->pluck('device_id'))->pluck('name')->toArray();
                if (in_array(loggedDevice($agent), $devices)):
                    //createLoginLog($agent, $location);
                    return redirect()->route('index')->with("success", "User logged in successfully");
                else:
                    Auth::logoutCurrentDevice();
                    return redirect()->back()->with("error", "User not allowed to logged into this device");
                endif;
            /*return redirect()->route('index')->with("success", "User logged in successfully");*/
            else:
                return redirect()->back()->with("error", "The provided credentials do not match with our records.")->withInput($request->all());
            endif;
        } catch (Exception $e) {
            return redirect()->back()->with("error", $e->getMessage())->withInput($request->all());
        }
    }

    function updateBranch(Request $request)
    {
        $branch = Branch::findOrFail($request->branch);
        Session::put('branch', $branch);
        if (Session::has('branch')) :
            return redirect()->route('index')
                ->withSuccess('User branch updated successfully!');
        else :
            return redirect()->route('index')
                ->withError('Please update branch!');
        endif;
    }

    function index()
    {
        $branches = Branch::whereIn('id', UserBranch::where('user_id', Auth::id())->pluck('branch_id'))->pluck('name', 'id');
        return view('admin.index', compact('branches'));
    }

    function logout(Request $request)
    {
        /*LoginLog::where('user_id', Auth::user()->id)->where('login_session_id', Auth::user()->login_session_id)->update([
            'logout_at' => Carbon::now(),
        ]);*/
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with("success", "User logged out successfully");
    }
}

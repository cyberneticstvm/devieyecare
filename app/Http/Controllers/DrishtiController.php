<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\LoginLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class DrishtiController extends Controller
{
    function dashboard()
    {
        $branches = userBranches();
        return view('admin.drishti.dashboard', compact('branches'));
    }

    function updateBranch(Request $request)
    {
        $branch = Branch::findOrFail($request->branch);
        Session::put('branch', $branch);
        LoginLog::where('user_id', Auth::user()->id)->where('login_session_id', Auth::user()->login_session_id)->update([
            'branch_id' => Session::get('branch')->id,
        ]);
        if (Session::has('branch')) :
            return redirect()->route('drishti.dashboard')
                ->withSuccess('User branch updated successfully!');
        else :
            return redirect()->route('drishti.dashboard')
                ->withError('Please update branch!');
        endif;
    }
}

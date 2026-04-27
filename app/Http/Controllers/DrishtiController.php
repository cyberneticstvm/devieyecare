<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DrishtiController extends Controller
{
    function dashboard()
    {
        $branches = userBranches();
        return view('admin.drishti.dashboard', compact('branches'));
    }
}

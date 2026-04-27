<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DrishtiController extends Controller
{
    function dashboard()
    {
        return view('admin.drishti.dashboard');
    }
}

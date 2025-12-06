<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class HelperController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('search-registration'), only: ['searchRegistration', 'searchRegistrationShow']),
        ];
    }

    function searchRegistration()
    {
        $registrations = [];
        $inputs = array('');
        return view('admin.search.registration', compact('registrations', 'inputs'));
    }

    function searchRegistrationShow(Request $request)
    {
        $data = $request->validate([
            'search_term' => 'required',
        ]);
        try {
            $inputs = array($request->search_term);
            $registrations = Registration::orWhere('mrn', $request->search_term)->orWhere('mobile', $request->search_term)->orWhere('name', $request->search_term)->get();
        } catch (Exception $e) {
            return redirect()->back()->with("error", $e->getMessage())->withInput($data);
        }
        return view('admin.search.registration', compact('registrations', 'inputs'));
    }
}

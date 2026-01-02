<?php

namespace App\Http\Controllers;

use App\Exports\ProductExport;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [];
    }

    function exportProduct(Request $request)
    {
        return Excel::download(new ProductExport, 'products.xlsx');
    }
}

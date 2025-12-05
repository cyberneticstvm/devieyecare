<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
    function getProductById(Request $request)
    {
        $product = Product::findOrFail($request->pdctId);
        return response()->json([
            'product' => $product,
        ]);
    }
}

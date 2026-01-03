<?php

use App\Models\Extra;
use App\Models\Order;
use App\Models\Pharmacy;
use App\Models\Registration;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;

function getDataCount()
{
    $registration = Registration::where('branch_id', Session::get('branch')?->id ?? 0)->whereDate('created_at', Carbon::today())->whereIn('rtype', Extra::where('category', 'rtype')->whereIn('name', ['New', 'Camp', 'Appointment'])->pluck('id'))->count();
    $review = Registration::where('branch_id', Session::get('branch')?->id ?? 0)->whereDate('created_at', Carbon::today())->whereIn('rtype', Extra::where('category', 'rtype')->whereIn('name', ['Review'])->pluck('id'))->count();
    $order = Order::where('branch_id', Session::get('branch')?->id ?? 0)->whereDate('created_at', Carbon::today())->count();
    $pharmacy = Pharmacy::where('branch_id', Session::get('branch')?->id ?? 0)->whereDate('created_at', Carbon::today())->count();
    return array($registration, $review, $order, $pharmacy);
}

function docFeePmodePending()
{
    $data = Registration::where('doc_fee', '>', 0)->whereNull('doc_fee_pmode')->where('branch_id', Session::get('branch')?->id ?? 0)->whereDate('created_at', Carbon::today())->latest()->get();
    return $data;
}

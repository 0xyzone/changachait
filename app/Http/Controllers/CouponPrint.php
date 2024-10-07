<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;

class CouponPrint extends Controller
{
    public function print(Order $order) {
        $pdf = app()->make(PDF::class)->loadView('invoices.invoice', [
            'order' => $order
        ]);

        return $pdf->stream('coupon_' . $order->id .'.pdf');
    }
}

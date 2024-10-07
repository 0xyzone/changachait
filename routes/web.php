<?php

use App\Http\Controllers\CouponPrint;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect(route('filament.app.pages.dashboard'));
});

Route::get('/invoices/{order}/print', [CouponPrint::class, 'print'])->name('invoice.print');

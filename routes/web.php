<?php

use App\Models\Item;
use App\Http\Controllers\CouponPrint;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect(route('filament.app.pages.dashboard'));
})->name('dashboard');

Route::get('/invoices/{order}/print', [CouponPrint::class, 'print'])->name('invoice.print');
Route::get('/menu', function () {
    $items = Item::all();
    return view('menu', compact('items'));
})->name('menu');
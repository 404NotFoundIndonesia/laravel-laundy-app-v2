<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::redirect('/', '/dashboard');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::resource('customer', \App\Http\Controllers\CustomerController::class);
    Route::delete('customer', [\App\Http\Controllers\CustomerController::class, 'destroyBulk'])->name('customer.destroy-bulk');

    Route::resource('supplier', \App\Http\Controllers\SupplierController::class);
    Route::delete('supplier', [\App\Http\Controllers\SupplierController::class, 'destroyBulk'])->name('supplier.destroy-bulk');
});

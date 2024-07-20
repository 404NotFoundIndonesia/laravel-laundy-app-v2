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

    Route::get('transaction', [\App\Http\Controllers\TransactionController::class, 'index'])->name('transaction.index');
    Route::get('transaction/create', [\App\Http\Controllers\TransactionController::class, 'create'])->name('transaction.create');
    Route::post('transaction', [\App\Http\Controllers\TransactionController::class, 'store'])->name('transaction.store');
    Route::get('transaction/{transaction}', [\App\Http\Controllers\TransactionController::class, 'show'])->name('transaction.show');
    Route::delete('transaction/{transaction}', [\App\Http\Controllers\TransactionController::class, 'destroy'])->name('transaction.destroy');
    Route::delete('transaction', [\App\Http\Controllers\TransactionController::class, 'destroyBulk'])->name('transaction.destroy-bulk');

    Route::resource('service', \App\Http\Controllers\ServiceController::class);
    Route::delete('service', [\App\Http\Controllers\ServiceController::class, 'destroyBulk'])->name('service.destroy-bulk');

    Route::get('customer/search', [\App\Http\Controllers\CustomerController::class, 'search'])->name('customer.search');
    Route::resource('customer', \App\Http\Controllers\CustomerController::class);
    Route::delete('customer', [\App\Http\Controllers\CustomerController::class, 'destroyBulk'])->name('customer.destroy-bulk');

    Route::resource('supplier', \App\Http\Controllers\SupplierController::class);
    Route::delete('supplier', [\App\Http\Controllers\SupplierController::class, 'destroyBulk'])->name('supplier.destroy-bulk');
});

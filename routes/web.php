<?php

use App\Http\Controllers\PreviewController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');

    // INVOICES
    Route::livewire('invoice', 'pages::invoice.index')->name('invoice.index');
    Route::livewire('invoice/create/{token?}', 'pages::invoice.create')
        ->name('invoice.create');

    // CUSTOMER
    Route::livewire('customer', 'pages::customer.index')->name('customer.index');
});

Route::get('invoice/preview/{token}', PreviewController::class)->name('invoice.preview');

require __DIR__.'/settings.php';

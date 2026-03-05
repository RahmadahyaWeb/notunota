<?php

use App\Http\Controllers\PreviewController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');

    Route::livewire('invoice', 'pages::invoice.index')->name('invoice.index');
    Route::livewire('invoice/create', 'pages::invoice.create')->name('invoice.create');
    Route::get('invoice/preview/{token}', PreviewController::class)->name('invoice.preview');
});

require __DIR__.'/settings.php';

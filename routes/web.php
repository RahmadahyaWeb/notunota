<?php

use Illuminate\Support\Facades\Route;

Route::livewire('/', 'pages::landing-page')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::livewire('dashboard', 'pages::dashboard')->name('dashboard');

    // INVOICES
    Route::livewire('invoice', 'pages::invoice.index')
        ->name('invoice.index');

    Route::livewire('invoice/create/{token?}', 'pages::invoice.create')
        ->name('invoice.create');

    // CUSTOMER
    Route::livewire('manage/customer', 'pages::customer.index')->name('customer.index');

    // PRODUCT
    Route::livewire('manage/product', 'pages::product.index')->name('product.index');

    // SETTING
    Route::livewire('manage/setting', 'pages::setting.index')->name('setting.index');

    // EMPLOYEE
    Route::livewire('manage/employee', 'pages::employee.index')->name('employee.index');
});

Route::livewire('invoice/preview/{token}', 'pages::invoice.preview')->name('invoice.preview');

Route::livewire('join/{token}', 'pages::join-business')->name('join-business');

require __DIR__.'/settings.php';

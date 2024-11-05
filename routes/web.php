<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});
Route::get('/proprietati-vanzare', \App\Livewire\SaleEstates::class)->name('sales-listings');

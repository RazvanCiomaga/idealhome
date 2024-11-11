<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});
Route::get('/proprietati-vanzare', function () {
    return view('pages.sale-estates');
})->name('sales-listings');

Route::get('/proprietati-inchiriere', function () {
    return view('pages.rent-estates');
})->name('rent-listings');

Route::get('/contact', function () {
    return view('pages.contact');
})->name('contact');

Route::get('/echipa', function () {
    return view('pages.team');
})->name('team');

Route::get('/{slug}', function ($slug) {
    return view('pages.estate', compact('slug'));
})->name('estate.show');

<?php

use App\Http\Controllers\Api\DataController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PlaceController;
use App\Http\Controllers\MapController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Auth::routes();

Route::get('/products/data-big', [DataController::class, 'productsBig'])->name('products.databig'); // DataTableBig
Route::get('/products/data-small', [DataController::class, 'productsSmall'])->name('products.datasmall'); // DataTableSmall
Route::get('/products/api/{id?}', [DataController::class, 'index'])->name('products.api'); // dashboard

Route::get('/', [HomeController::class, 'index'])->name('dashboard');
// Route::get('/jarak', [HomeController::class, 'jarak'])->name('jarak');
Route::resource('products', PlaceController::class);
Route::resource('shops', PlaceController::class);
Route::resource('transactions', PlaceController::class);

// Route::group(['middleware' => ['auth']], function () {
//     Route::get('/', [MapController::class, 'index'])->name('dashboard');
//     Route::get('/jarak', [mapController::class, 'jarak'])->name('jarak');
//     Route::resource('places', PlaceController::class);
// });

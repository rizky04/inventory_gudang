<?php

use App\Http\Controllers\CategoryProductController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StockProduct;
use App\Http\Controllers\StockProductController;
use App\Http\Controllers\VariantProductController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::middleware('auth')->group(function(){
    Route::prefix('master-data')->name('master-data.')->group(function(){
        Route::resource('category-product', CategoryProductController::class);
        Route::resource('product', ProductController::class);
        Route::resource('variant-product', VariantProductController::class);
        Route::resource('stock-product', StockProductController::class);
    });
});

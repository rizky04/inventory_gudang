<?php

use App\Http\Controllers\CategoryProductController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StockProduct;
use App\Http\Controllers\StockProductController;
use App\Http\Controllers\VariantProductController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatbotController;

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
    // Halaman utama chatbot
Route::get('/chatbot', [ChatbotController::class, 'index'])->name('chatbot.index');

// Endpoint untuk memproses chat dari user
Route::post('/chatbot/send', [ChatbotController::class, 'sendMessage'])->name('chatbot.send');

// Endpoint untuk menghapus riwayat obrolan (opsional tapi sangat berguna)
Route::post('/chatbot/clear', [ChatbotController::class, 'clear'])->name('chatbot.clear');
});

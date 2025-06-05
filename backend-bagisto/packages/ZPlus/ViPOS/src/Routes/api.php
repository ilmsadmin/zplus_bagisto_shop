<?php

use Illuminate\Support\Facades\Route;
use ZPlus\ViPOS\Http\Controllers\ProductController;
use ZPlus\ViPOS\Http\Controllers\CustomerController;
use ZPlus\ViPOS\Http\Controllers\OrderController;

Route::group(['middleware' => ['admin'], 'prefix' => 'api/vipos'], function () {
    
    // Product endpoints
    Route::controller(ProductController::class)->prefix('products')->group(function () {
        Route::get('/', 'index')->name('api.vipos.products.index');
        Route::get('/categories', 'categories')->name('api.vipos.products.categories');
        Route::get('/{identifier}', 'show')->name('api.vipos.products.show');
    });

    // Customer endpoints
    Route::controller(CustomerController::class)->prefix('customers')->group(function () {
        Route::get('/search', 'search')->name('api.vipos.customers.search');
        Route::post('/', 'store')->name('api.vipos.customers.store');
        Route::get('/{id}', 'show')->name('api.vipos.customers.show');
    });

    // Order endpoints
    Route::controller(OrderController::class)->prefix('orders')->group(function () {
        Route::post('/', 'store')->name('api.vipos.orders.store');
        Route::get('/recent', 'recent')->name('api.vipos.orders.recent');
        Route::get('/{id}', 'show')->name('api.vipos.orders.show');
    });
});
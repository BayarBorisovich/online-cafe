<?php

use App\Http\Controllers\Admin\CategoryController;

use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\ApiControllers\MainController;
use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'Admin', 'prefix' => 'admin'], function () {
    Route::group(['prefix' => 'category'], function () {
        Route::post('/create', [CategoryController::class, 'create'])->name('admin.category.create');
        Route::get('/get', [CategoryController::class, 'getCategories'])->name('admin.category.get');
        Route::patch('/update/{category}', [CategoryController::class, 'update'])->name('admin.category.update');
        Route::delete('/delete/{category}', [CategoryController::class, 'delete'])->name('admin.category.delete');
    });
    Route::group(['prefix' => 'product'], function () {
        Route::post('/create', [ProductController::class, 'create'])->name('admin.product.create');
        Route::get('/get', [ProductController::class, 'getProducts'])->name('admin.product.get');
        Route::patch('/update/{product}', [ProductController::class, 'update'])->name('admin.product.update');
        Route::delete('/delete/{product}', [ProductController::class, 'delete'])->name('admin.product.delete');
    });
});

Route::group(['prefix' => 'main'], function () {
    Route::get('/category/products', [MainController::class, 'getProducts']);
    Route::get('/product/{productId}', [MainController::class, 'getProduct']);
});


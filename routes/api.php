<?php

use App\Http\Controllers\Admin\CategoryController;

use App\Http\Controllers\ApiControllers\MainController;
use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'Admin', 'prefix' => 'admin'], function () {
    Route::group(['prefix' => 'category'], function () {
        Route::get('/get', [CategoryController::class, 'getCategories'])->name('admin.category.get');
        Route::post('/create', [CategoryController::class, 'create'])->name('admin.category.create');
        Route::patch('/update/{category}', [CategoryController::class, 'update'])->name('admin.category.update');
        Route::delete('/delete/{category}', [CategoryController::class, 'delete'])->name('admin.category.delete');
    });
});

Route::group(['prefix' => 'main'], function () {
    Route::get('/category/products', [MainController::class, 'getProducts']);
    Route::get('/product/{productId}', [MainController::class, 'getProduct']);
});


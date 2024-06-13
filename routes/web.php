<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\IndexController;
use App\Http\Controllers\CartController;

use App\Http\Controllers\MainController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

//Route::get('/', function () {
//    return view('welcome');
//});

Auth::routes();


Route::group(['prefix' => 'email'], function () {

    Route::get('/verify', function () {
        return view('auth.verify-email');
    })->middleware('auth')->name('verification.notice');

    Route::get('/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();

        return redirect('/main');
    })->middleware(['auth', 'signed'])->name('verification.verify');

    Route::post('/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();

        return back()->with('message', 'Verification link sent!');
    })->middleware(['auth', 'throttle:6,1'])->name('verification.send');

});

Route::group(['namespace' => 'Admin', 'prefix' => 'admin'], function () {
    Route::get('/', [IndexController::class, 'index'])->name('admin.index');
    Route::group(['prefix' => 'category'], function () {
        Route::get('/', [CategoryController::class, 'index'])->name('admin.category');
    });
    Route::group(['prefix' => 'product'], function () {
        Route::get('/', [ProductController::class, 'index'])->name('admin.product');
    });

});

Route::group(['middleware' => 'auth'], function () {

    Route::group(['prefix' => 'main'], function () {
        Route::get('/', [MainController::class, 'main'])->name('main');
    });

    Route::group(['prefix' => 'cart'], function () {
        Route::get('/', [CartController::class, 'getCart'])->name('cart');
        Route::post('/create/{productId}', [CartController::class, 'addProducts']);
        Route::patch('/plus/{productId}', [CartController::class, 'addPlus']);
        Route::patch('/minus/{productId}', [CartController::class, 'addMinus']);
        Route::get('/products', [CartController::class, 'getProducts']);
        Route::get('/total', [CartController::class, 'totalInTheBasket']);
        Route::delete('/delete/{cartProduct}', [CartController::class, 'removeProducts']);

    });

    Route::group(['prefix' => 'order'], function () {
        Route::get('/', [OrderController::class, 'getOrder'])->name('order');
        Route::post('/create', [OrderController::class, 'createOrder']);
        Route::get('/item', [OrderController::class, 'getOrderItems'])->name('items');
        Route::get('/item/json', [OrderController::class, 'getOrders']);
        Route::get('/test', [ProductController::class, 'test']);
    });

    Route::post('/payments/callback', [PaymentController::class, 'callback'])->name('callback');
});


Route::match(['get', 'post'], '/test', [TestController::class, 'test'])->name('test');



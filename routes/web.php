<?php

use App\Http\Controllers\CartController;

use App\Http\Controllers\MainController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
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

Route::group(['middleware' => 'auth'], function () {

    Route::group(['prefix' => 'main'], function () {
        Route::get('/', [MainController::class, 'main'])->name('main');
        Route::get('/json', [MainController::class, 'getProducts']);
        Route::get('/product/{productId}', [MainController::class, 'getProduct']);
        Route::get('/cartProduct', [MainController::class, 'getCartProducts']);
    });

    Route::group(['prefix' => 'cart'], function (){
        Route::get('/', [CartController::class, 'getCart'])->name('cart');
        Route::post('/create/{productId}', [CartController::class, 'addProducts']);
        Route::patch('/plus/{productId}', [CartController::class, 'addPlus']);
        Route::patch('/minus/{productId}', [CartController::class, 'addMinus']);
        Route::get('/products', [CartController::class, 'getProducts']);
        Route::get('/total', [CartController::class, 'totalInTheBasket']);
        Route::delete('/delete/{productId}', [CartController::class, 'removeProducts']);

    });

    Route::group(['prefix' => 'order'], function (){
        Route::get('/', [OrderController::class, 'getOrder'])->name('order');
        Route::post('/create', [OrderController::class, 'createOrder']);
        Route::get('/item', [OrderController::class, 'getOrderItems'])->name('items');
        Route::get('/item/json', [OrderController::class, 'getOrders']);
        Route::get('/test', [ProductController::class, 'test']);
    });
});


Route::get('/test', [ProductController::class, 'test']);



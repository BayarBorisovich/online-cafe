<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

//Route::get('/', function () {
//    return view('welcome');
//});

Auth::routes();

Route::get('/home', [App\Http\Controllers\MainController::class, 'index'])->name('home');

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

use Illuminate\Foundation\Auth\EmailVerificationRequest;

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/main');
})->middleware(['auth', 'signed'])->name('verification.verify');

use Illuminate\Http\Request;

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');


Route::get('/main', [MainController::class, 'main'])->name('main');
Route::get('/main/json', [MainController::class, 'getProducts']);

Route::get('/cart', [CartController::class, 'getCart'])->name('cart');
Route::get('/cart/json', [CartController::class, 'getProducts']);
Route::post('/cart/{productId}', [CartController::class, 'addProducts']);
Route::delete('/cart/delete/{productId}', [CartController::class, 'removeProducts']);



Route::get('/test', [ProductController::class, 'test']);



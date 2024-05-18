<?php

namespace App\Http\Controllers;



use App\Models\Cart;
use App\Services\CartService;
use App\Services\PaymentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    private PaymentService $paymentService;
    private CartService  $cartService;
    public function __construct(PaymentService $paymentService, CartService $cartService)
    {
        $this->paymentService = $paymentService;
        $this->cartService = $cartService;
    }
    public function test(): RedirectResponse
    {
        $user = Auth::user();

        $cart = $user->carts()->first();

        if (!isset($cart)) {
            $cart = Cart::query()->create([
                'user_id' => $user->id,
            ]);
            dd('empty');

        }
        dd('no empty');
    }

}

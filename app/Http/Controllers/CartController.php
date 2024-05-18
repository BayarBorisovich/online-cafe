<?php

namespace App\Http\Controllers;


use App\Models\Cart;
use App\Models\CartProduct;
use App\Services\CartService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    private CartService $cartService;
    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }
    public function getCart(): View
    {
        return view('cart');
    }

    public function getProducts(): JsonResponse
    {
        $products = $this->cartService->getProducts();

        return response()->json([
            'products' => $products
        ]);
    }

//    public function addPlus(int $productId): JsonResponse
//    {
//        $product = CartProduct::query()->where('product_id', $productId)->get();
//
//        if (!$product->isEmpty()) {
//            $product->toQuery()->update([
//                'quantity' => $product->first()->quantity + 1
//            ]);
//        }
//
//        return response()->json([]);
//    }

    public function addMinus(int $productId): JsonResponse
    {
        $product = CartProduct::query()->where('product_id', $productId)->get();

        if (!$product->isEmpty()) {

            if ($product->first()->quantity === 1) {
                $product->first()->delete();
                return response()->json('empty');
            }

            $product->toQuery()->update([
                'quantity' => $product->first()->quantity - 1
            ]);
        }

        return response()->json([]);

    }

    public function addProducts(int $productId): Response
    {
        $user = Auth::user();

        $cart = $user->carts()->first();

        if (!isset($cart)) {
            $cart = Cart::query()->create([
                'user_id' => $user->id,
            ]);

        }

        $product = CartProduct::query()->where('product_id', $productId)->get();

        if ($product->isEmpty()) {
            CartProduct::query()->create([
                'cart_id' => $cart->id,
                'product_id' => $productId,
                'quantity' => 1,
            ]);

        } else {
            $product->toQuery()->update([
                'quantity' => $product->first()->quantity + 1
            ]);
        }
        return response([]);
    }

    public function totalInTheBasket(): JsonResponse
    {
        $totalInTheBasket = $this->cartService->totalInTheBasket();

        return response()->json([
            'totalQuantity' => $totalInTheBasket ? $totalInTheBasket['totalQuantity'] : 0,
            'orderSum' => $totalInTheBasket ? $totalInTheBasket['orderSum'] : 0,
        ]);

    }

    public function removeProducts(int $productId): Response
    {
        CartProduct::query()->where('product_id', $productId)->delete();

        return response([]);
    }
}

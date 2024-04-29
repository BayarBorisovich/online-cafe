<?php

namespace App\Http\Controllers;


use App\Models\Cart;
use App\Models\CartProduct;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function getCart(): View
    {
        return view('cart');
    }

    public function getProducts(): JsonResponse
    {
        $products = User::find(Auth::id())
            ->carts()
            ->with('products')
            ->first()
            ->products()->with('product')->get();

        return response()->json([
            'products' => $products
        ]);
    }

    public function addPlus(int $productId): JsonResponse
    {
        $product = CartProduct::where('product_id', $productId)->get();

        if (!$product->isEmpty()) {
            $product->toQuery()->update([
                'quantity' => $product->first()->quantity + 1
            ]);
        }

        return response()->json([]);
    }

    public function addMinus(int $productId): JsonResponse
    {
        $product = CartProduct::where('product_id', $productId)->get();

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
        $id = Auth::id();

        $cart = Cart::find($id);

        if (empty($cart)) {
            $cart = Cart::create([
                'user_id' => $id,
            ]);
        }

        $product = CartProduct::where('product_id', $productId)->get();

        if ($product->isEmpty()) {
            CartProduct::create([
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
        $products = User::find(Auth::id())
            ->carts()
            ->with('products')
            ->first()
            ->products()->with('product')->get();

        $orderSum = [];
        $totalQuantity = [];
        foreach ($products as $cartProduct) {
            $totalQuantity[] = $cartProduct->quantity;
            $orderSum[] = $cartProduct->product->price * $cartProduct->quantity;
        }

        return response()->json([
            'totalQuantity' => array_sum($totalQuantity),
            'orderSum' => round(array_sum($orderSum), 2)
        ]);

    }

    public function removeProducts(int $productId): Response
    {
        CartProduct::where('product_id', $productId)->delete();

        return response([]);
    }
}

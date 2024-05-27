<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;

class CartService
{
    public function getProducts()
    {
        return Auth::user()
            ->carts()
            ->with('products')
            ->first()
            ->products()->with('product')->orderBy('created_at', 'desc')->get();
    }
    public function totalInTheBasket(): array|null
    {
        $products = $this->getProducts();

        if ($products->isEmpty()) {
            return null;
        }

        $orderSum = [];
        $totalQuantity = [];
        foreach ( $products as $cartProduct) {
            $totalQuantity[] = $cartProduct->quantity;
            $orderSum[] = $cartProduct->product->price * $cartProduct->quantity;
        }

        return [
            'totalQuantity' => array_sum($totalQuantity),
            'orderSum' => round(array_sum($orderSum), 2)
        ];
    }
}

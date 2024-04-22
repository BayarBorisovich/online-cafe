<?php

namespace App\Http\Controllers;

use App\Models\CartProduct;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function test()
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

        dd(round(array_sum($orderSum)), 2);
    }
}

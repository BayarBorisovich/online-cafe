<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
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
        $categories = Category::with('products')->get()->sort()->values();

        $cartProducts = User::find(Auth::id())
           ->carts()
           ->with('products')
           ->first()->products;

        dd($cartProducts);

        foreach ($categories as $category) {
            echo "<br>";
            echo $category->name . "<br>";
            echo "<br>";
            foreach ($category->products as $categoryProduct) {
                echo $categoryProduct->name . "<br>";
                echo $categoryProduct->price . "<br>";
                foreach ($cartProducts as $cartProduct) {
                    if ($categoryProduct->id === $cartProduct->product_id) {
                        echo $cartProduct->quantity . "<br>";
                    }
                }

            }

        }

//        dd($categories);
    }
}

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
        $products = User::find(1)
            ->carts()
            ->with('products')
            ->first()
            ->products()->with('product')->get();

        dd($products);
    }
}

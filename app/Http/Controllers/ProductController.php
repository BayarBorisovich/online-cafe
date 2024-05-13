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
        $products = Auth::user()
            ->orders()
            ->with('items')
            ->first()
            ->items()->with('product')->get();

        dd($products);
    }
}

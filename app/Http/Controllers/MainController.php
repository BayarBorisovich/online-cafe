<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MainController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function main(): View
    {
        return view('main.index');
    }

    public function getProducts(): JsonResponse
    {
        $categories = Category::with('products')->get()->sort()->values();


        return response()->json([
            'categories' => $categories
        ]);
    }
    public function getProduct(int $productId): JsonResponse
    {
        $product = Product::find($productId);

        return response()->json([
            'product' => $product
        ]);
    }
    public function getCartProducts(): JsonResponse
    {
        $cartProducts = User::find(Auth::id())
            ->carts()
            ->with('products')
            ->first()->products;

        return response()->json([
            'cartProducts' => $cartProducts
        ]);
    }
}

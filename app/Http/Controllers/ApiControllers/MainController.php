<?php

namespace App\Http\Controllers\ApiControllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\JsonResponse;

class MainController extends Controller
{

    public function getProducts(): JsonResponse
    {
        $categories = Category::query()->with('products')->get()->sort()->values();

        return response()->json([
            'category' => $categories
        ]);
    }
    public function getProduct(int $productId): JsonResponse
    {
        $product = Product::query()->find($productId);

        return response()->json([
            'product' => $product
        ]);
    }
}

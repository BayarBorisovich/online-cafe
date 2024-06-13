<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(): View
    {
        return view('admin.product.index');
    }

    public function create(ProductRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();
            Product::query()->create($data);
        } catch (\Throwable $exception) {
            Log::channel('daily')->error('Произошла ошибка при создании категории ' . $exception->getMessage() . ' ' . $exception->getLine());

            return response()->json(['error' => 'Произошла ошибка при создании категории']);
        }

        return response()->json(['success' => 'Категория успешно добавлена']);
    }
    public function update(ProductRequest $request, Product $product): JsonResponse
    {
        $data = $request->validated();
        $product->update($data);

        return response()->json();
    }

    public function delete()
    {

    }

    public function getProducts(): JsonResponse
    {
        $products = Product::all();

        return response()->json($products);
    }
}

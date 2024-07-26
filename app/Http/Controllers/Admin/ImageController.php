<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ImageRequest;
use App\Http\Requests\ProductRequest;
use App\Models\CategoryProduct;
use App\Models\Product;
use http\Env\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class ImageController extends Controller
{
    public function index(): View
    {
        return view('admin.product.index');
    }

    public function create(ImageRequest $request): JsonResponse
    {
       dd($request);

        return response()->json(['success' => 'Продукт успешно добавлен']);
    }
    public function update(ProductRequest $request, Product $product): JsonResponse
    {
        try {
            $data = $request->validated();

            $categoryId = $data['category_id'];

            unset($data['category_id']);

            DB::beginTransaction();

            try {
                $product->update($data);

                $product->category()->sync($categoryId);

            } catch (\Exception $exception) {
                DB::rollBack();
                Log::channel('daily')->error('Произошла ошибка при изменении продукта ' . $exception->getMessage() . ' ' . $exception->getLine());

                return response()->json(['error_when_changing' => 'Произошла ошибка при изменении продукта']);
            }
            DB::commit();
        } catch (\Throwable $exception) {
            Log::channel('daily')->error('Произошла ошибка при добавлении продукта ' . $exception->getMessage() . ' ' . $exception->getLine());

            return response()->json(['error_when_changing' => 'Произошла ошибка при добавлении продукта']);
        }

        return response()->json(['successfully_changed' => 'Продукт успешно изменен']);
    }

    public function delete(Product $product): JsonResponse
    {
        try {
            $product->category()->detach();

            $product->delete();
        } catch (\Throwable $exception) {
            Log::channel('daily')->error('Произошла ошибка при удалении продукта ' . $exception->getMessage() . ' ' . $exception->getLine());

            return response()->json(['error_when_deleting' => 'Произошла ошибка при удалении продукта']);
        }


        return response()->json(['successfully deleted' => 'Продукт успешно удален']);
    }

    public function getProducts(): JsonResponse
    {
        $products = Product::with('category')->get();

        return response()->json($products);
    }
}

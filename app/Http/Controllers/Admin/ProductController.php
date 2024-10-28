<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Image;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(): View
    {
        return view('admin.product.index');
    }

    public function create(ProductRequest $request): JsonResponse
    {
        $data = $request->validated();

        try {
            $categoryId = $data['category_id'];
            $images = $data['images'];
            unset($data['category_id']);
            unset($data['images']);

            DB::beginTransaction();

            try {
                if ($data->isNotEmpty()) {
                    $product = Product::query()->create($data);
                    $product->category()->attach($categoryId);
                }


                if ($images->isNotEmpty()) {
                    foreach ($images as $image) {
                        $name = md5(Carbon::now() . '_' . $image->getClientOriginalName()) . '.' . $image->getClientOriginalExtension();
                        $path = Storage::disk('public')->putFileAs('/images', $image, $name);

                        if (isset($product->name)) {
                            Image::create([
                                'name' => $product->name,
                                'path' => $path,
                                'url' => url('/storage/' . $path),
                                'product_id' => $product->id
                            ]);
                        }

                    }
                }

            } catch (\Exception $exception) {
                DB::rollBack();
                Log::channel('daily')->error('Произошла ошибка при добавлении продукта ' . $exception->getMessage() . ' ' . $exception->getLine());

                return response()->json(['error' => 'Произошла ошибка при добавлении продукта']);
            }
            DB::commit();

        } catch (\Throwable $exception) {
            Log::channel('daily')->error('Произошла ошибка при добавлении продукта ' . $exception->getMessage() . ' ' . $exception->getLine());

            return response()->json(['error' => 'Произошла ошибка при добавлении продукта']);
        }

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

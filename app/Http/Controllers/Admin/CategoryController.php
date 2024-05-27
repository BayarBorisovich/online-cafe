<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(): View
    {
        return view('admin.category.index');
    }

    public function create(CategoryRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();
            Category::query()->create($data);
        } catch (\Throwable $exception) {
            Log::channel('daily')->error('Произошла ошибка при создании категории ' . $exception->getMessage() . ' ' . $exception->getLine());

            return response()->json(['error' => 'Произошла ошибка при создании категории']);
        }

        return response()->json(['success' => 'Категория успешно добавлена']);
    }
    public function update(CategoryRequest $request, Category $category): JsonResponse
    {
        $data = $request->validated();
        $category->update($data);

        return response()->json();
    }

    public function delete(Category $category): JsonResponse
    {
        $category->delete();

        return response()->json();
    }

    public function getCategories(): JsonResponse
    {
        $categories = Category::query()->orderBy('id', 'asc')->get();

        return response()->json($categories);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function test()
    {
        $categories = Category::with('products')->get();

//        $categories = Category::all();

        foreach ($categories as $category) {
            echo '<br>';
            echo $category->name . '<br>';
            echo '<br>';
            foreach ($category->products as $product) {
                echo $product->name . '<br>';
            }
        }
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'structure', 'description', 'weight', 'price'];

    public function category(): belongsToMany
    {
        return $this->belongsToMany(Category::class, 'category_products');
    }

    /**
     * Get the carts that contain the product.
     */
    public function carts(): BelongsToMany
    {
        return $this->belongsToMany(Cart::class, 'cart_product');
    }
}

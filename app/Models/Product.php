<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'structure', 'description', 'weight', 'price'];

    protected static function boot(): void
    {
        parent::boot();

        static::deleting(function ($product) {
            // Удаляем файлы изображений из папки
            foreach ($product->images as $image) {
                if ($image->path) {
                    Storage::delete($image->path);
                }
            }
            // Удаляем записи изображений из базы данных
            $product->images()->delete();
        });
    }

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

    public function images(): HasMany
    {
        return $this->hasMany(Image::class);
    }
}

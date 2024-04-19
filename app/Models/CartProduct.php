<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CartProduct extends Model
{
    use HasFactory;

    protected $fillable = ['cart_id', 'product_id', 'quantity'];

    /**
     * Get the cart that contains the product.
     */
    public function cart(): BelongsTo
    {
        return $this->belongsTo(Cart::class);
    }

    /**
     * Get the product in the cart.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}

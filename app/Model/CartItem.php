<?php

namespace App\Model;

use App\Model\Cart;
use App\Model\Product;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $fillable = ['product_id', 'cart_id', 'quantity'];

    public function cart() {
        return $this->belongsTo(Cart::class);
    }

    public function product() {
        return $this->hasOne(Product::class);
    }
}

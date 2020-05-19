<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = ['id', 'content', 'key', 'userID'];

    public function items() {
        return $this->hasMany('App\Model\CartItem', 'cart_id');
    }
}

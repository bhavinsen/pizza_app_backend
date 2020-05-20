<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
     protected $fillable = ['products', 'totalPrice', 'userID','transactionID','name','address'];
}

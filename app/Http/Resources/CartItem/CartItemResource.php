<?php

namespace App\Http\Resources\CartItem;

use App\Model\Product;
use Illuminate\Http\Resources\Json\JsonResource;

class CartItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $product = Product::find($this->product_id);

        return [
            'product_id' => $this->product_id,
            'sku' => $product->sku,
            'price' => $product->price,
            'name' => $product->name,
            'detail' => $product->detail,
            'image' => $product->slug,
            'quantity' => $this->quantity,
            'item_id' => $this->id
        ];
    }
}

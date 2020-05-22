<?php

namespace Tests\Unit;

use App\Http\Resources\Product\ProductCollection;
use Tests\TestCase;

class ProductTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_can_list_products()
    {
        $products = factory(\App\Model\Product::class, 2)->create()->map(function($product){
            return $product;
        });

        $this->get(route('products.index'))
             ->assertStatus(200)
             ->assertJson(new ProductCollection($products->toArray())->all())
             ->assertJsonStructure([
                  '*' => ['id', 'name', 'sku', 'slug', 'detail', 'created_at', 'updated_at']
             ]);
    }
}

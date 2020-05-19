<?php

use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\Model\Product::create([
           'name'   => 'Margherita',
           'sku'    => 'margherita',
           'slug'   => 'https://images.dominos.co.in/new_margherita_2502.jpg',
           'detail' => 'A classic delight with 100% Real mozzarella cheese.',
           'price'  => '23'
        ]);

        App\Model\Product::create([
           'name'   => 'Cheese n Corn',
           'sku'    => 'cheese-n-corn',
           'slug'   => 'https://images.dominos.co.in/new_cheese_n_corn.jpg',
           'detail' => 'Sweet & Juicy Golden corn and 100% real mozzarella cheese in a delectable combination!',
           'price'  => '26'
        ]);

        App\Model\Product::create([
           'name'   => 'Cheese n Tomato',
           'sku'    => 'cheese-n-tomato',
           'slug'   => 'https://images.dominos.co.in/cheese_and_tomato.png',
           'detail' => 'A delectable combination of cheese and juicy tomato.',
           'price'  => '29'
        ]);

        App\Model\Product::create([
           'name'   => 'Achari Do Pyaza',
           'sku'    => 'achari-do-pyaza',
           'slug'   => 'https://images.dominos.co.in/cheese_and_tomato.png',
           'detail' => 'Tangy & spicy achari flavours on a super cheesy onion pizza- as desi as it gets!',
           'price'  => '33'
        ]);

        App\Model\Product::create([
           'name'   => 'Double Cheese Margherita',
           'sku'    => 'double-cheese-margherita',
           'slug'   => 'https://images.dominos.co.in/double_cheese_margherita_2502.jpg',
           'detail' => 'A classic delight loaded with extra 100% real mozzarella cheese.',
           'price'  => '36'
        ]);

        App\Model\Product::create([
           'name'   => 'Fresh Veggie',
           'sku'    => 'fresh-veggie',
           'slug'   => 'https://images.dominos.co.in/double_cheese_margherita_2502.jpg',
           'detail' => 'Delectable combination of onion & capsicum, a veggie lovers pick.',
           'price'  => '39'
        ]);

        App\Model\Product::create([
           'name'   => 'Paneer Makhani',
           'sku'    => 'paneer-makhani',
           'slug'   => 'https://images.dominos.co.in/updated_paneer_makhani.jpg',
           'detail' => 'Flavorful twist of spicy makhani sauce topped with paneer & capsicum.',
           'price'  => '42'
        ]);
    }
}

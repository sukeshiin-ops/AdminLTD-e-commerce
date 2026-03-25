<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\ProductInventory;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\StockHistory;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {

        User::factory(3)->create();


        $this->call(CategorySeeder::class);

        // ✅ 3. Products
        Product::factory(5)->create();


        ProductVariant::factory(5)->create();


        Attribute::factory(2)->create();


        AttributeValue::factory(5)->create();


        ProductInventory::factory(5)->create();

 

        Order::factory(5)->create();


        OrderDetail::factory(5)->create();


    }
}

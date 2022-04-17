<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

//        Product::factory(20)->create();

//        Category::factory(10)->create();

        $products = Product::all();

        foreach ($products as $product) {
            $categories = Category::all()->random(rand(2,10));
            foreach ($categories as $category) {
                ProductCategory::factory(1)->create([
                    'product_id' => $product->id,
                    'category_id' => $category->id
                ]);
            }
        }


    }
}

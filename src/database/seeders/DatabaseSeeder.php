<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Arr;
use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call(CategorySeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(UserSeeder::class);


        User::factory(10)->create();

        Product::factory(30)->create()->each(function ($product) {
            $categoryIds = Category::pluck('id')->toArray();
            $product->categories()->attach(Arr::random($categoryIds, rand(1, 3)));
        });
    }
}

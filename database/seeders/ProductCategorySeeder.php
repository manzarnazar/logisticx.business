<?php

namespace Database\Seeders;

use App\Models\Backend\Charges\ProductCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $productCategories = [
            'KG',
            'Mobile',
            'Laptops',
            'Refrigerators',
            'Microwaves',
            'Accessories',
        ];

        $productCategories = collect($productCategories);
        $productCategories->each(fn ($category) => ProductCategory::create(['name' => $category, 'position' => rand(1, 10)]));
    }
}

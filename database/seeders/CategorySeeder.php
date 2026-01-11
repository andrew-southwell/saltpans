<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Breakfast',
                'description' => 'Start your day right with these delicious breakfast recipes.',
                'slug' => 'breakfast',
            ],
            [
                'name' => 'Lunch',
                'description' => 'Satisfying midday meals to keep you going.',
                'slug' => 'lunch',
            ],
            [
                'name' => 'Dinner',
                'description' => 'Hearty evening meals for the whole family.',
                'slug' => 'dinner',
            ],
            [
                'name' => 'Dessert',
                'description' => 'Sweet treats to satisfy your cravings.',
                'slug' => 'dessert',
            ],
            [
                'name' => 'Appetizers',
                'description' => 'Perfect starters for any occasion.',
                'slug' => 'appetizers',
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Recipe;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RecipeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $breakfast = Category::where('slug', 'breakfast')->first();
        $lunch = Category::where('slug', 'lunch')->first();
        $dinner = Category::where('slug', 'dinner')->first();
        $dessert = Category::where('slug', 'dessert')->first();

        $recipes = [
            [
                'category_id' => $breakfast->id,
                'title' => 'Classic Pancakes',
                'description' => 'Fluffy, golden pancakes perfect for a weekend breakfast. Serve with maple syrup and fresh berries.',
                'ingredients' => [
                    '1 cup all-purpose flour',
                    '2 tablespoons sugar',
                    '2 teaspoons baking powder',
                    '1/2 teaspoon salt',
                    '1 cup milk',
                    '1 large egg',
                    '2 tablespoons melted butter',
                ],
                'instructions' => [
                    'In a large bowl, whisk together flour, sugar, baking powder, and salt.',
                    'In another bowl, beat the egg, then add milk and melted butter.',
                    'Pour wet ingredients into dry ingredients and stir until just combined.',
                    'Heat a griddle or pan over medium heat and grease lightly.',
                    'Pour 1/4 cup batter for each pancake and cook until bubbles form on top.',
                    'Flip and cook until golden brown on the other side.',
                    'Serve warm with your favorite toppings.',
                ],
                'prep_time' => 10,
                'cook_time' => 15,
                'servings' => 4,
                'image' => 'https://picsum.photos/seed/pancakes/800/600',
            ],
            [
                'category_id' => $lunch->id,
                'title' => 'Caesar Salad',
                'description' => 'A classic Caesar salad with crisp romaine lettuce, homemade croutons, and creamy dressing.',
                'ingredients' => [
                    '1 head romaine lettuce, chopped',
                    '1/2 cup grated Parmesan cheese',
                    '1 cup croutons',
                    '2 anchovy fillets',
                    '2 cloves garlic, minced',
                    '1/4 cup olive oil',
                    '2 tablespoons lemon juice',
                    '1 teaspoon Dijon mustard',
                ],
                'instructions' => [
                    'Wash and dry the romaine lettuce, then chop into bite-sized pieces.',
                    'Make the dressing by mashing anchovies and garlic together.',
                    'Whisk in olive oil, lemon juice, and Dijon mustard.',
                    'Toss lettuce with dressing in a large bowl.',
                    'Add Parmesan cheese and croutons.',
                    'Toss gently and serve immediately.',
                ],
                'prep_time' => 15,
                'cook_time' => 0,
                'servings' => 4,
                'image' => 'https://picsum.photos/seed/salad/800/600',
            ],
            [
                'category_id' => $dinner->id,
                'title' => 'Spaghetti Carbonara',
                'description' => 'Creamy Italian pasta dish with eggs, cheese, pancetta, and black pepper.',
                'ingredients' => [
                    '1 pound spaghetti',
                    '6 ounces pancetta, diced',
                    '4 large eggs',
                    '1 cup grated Parmesan cheese',
                    '4 cloves garlic, minced',
                    'Freshly ground black pepper',
                    'Salt to taste',
                ],
                'instructions' => [
                    'Bring a large pot of salted water to a boil and cook spaghetti according to package directions.',
                    'While pasta cooks, heat a large pan and cook pancetta until crispy.',
                    'In a bowl, whisk together eggs and Parmesan cheese.',
                    'Drain pasta, reserving 1 cup of pasta water.',
                    'Add hot pasta to the pan with pancetta, remove from heat.',
                    'Quickly toss in egg mixture, adding pasta water as needed to create a creamy sauce.',
                    'Season with black pepper and serve immediately.',
                ],
                'prep_time' => 10,
                'cook_time' => 20,
                'servings' => 4,
                'image' => 'https://picsum.photos/seed/pasta/800/600',
            ],
            [
                'category_id' => $dessert->id,
                'title' => 'Chocolate Chip Cookies',
                'description' => 'Classic homemade chocolate chip cookies that are crispy on the outside and chewy on the inside.',
                'ingredients' => [
                    '2 1/4 cups all-purpose flour',
                    '1 teaspoon baking soda',
                    '1 teaspoon salt',
                    '1 cup butter, softened',
                    '3/4 cup granulated sugar',
                    '3/4 cup brown sugar',
                    '2 large eggs',
                    '2 teaspoons vanilla extract',
                    '2 cups chocolate chips',
                ],
                'instructions' => [
                    'Preheat oven to 375°F (190°C).',
                    'In a medium bowl, whisk together flour, baking soda, and salt.',
                    'In a large bowl, cream together butter and both sugars until light and fluffy.',
                    'Beat in eggs and vanilla extract.',
                    'Gradually mix in flour mixture until just combined.',
                    'Stir in chocolate chips.',
                    'Drop rounded tablespoons of dough onto ungreased baking sheets.',
                    'Bake for 9-11 minutes or until golden brown.',
                    'Cool on baking sheet for 2 minutes before removing to wire rack.',
                ],
                'prep_time' => 15,
                'cook_time' => 11,
                'servings' => 24,
                'image' => 'https://picsum.photos/seed/cookies/800/600',
            ],
        ];

        foreach ($recipes as $recipeData) {
            $recipe = Recipe::where('slug', \Illuminate\Support\Str::slug($recipeData['title']))->first();
            
            if ($recipe) {
                // Update existing recipe with image
                $recipe->update(['image' => $recipeData['image']]);
            } else {
                // Create new recipe if it doesn't exist
                Recipe::create($recipeData);
            }
        }
    }
}

<?php

namespace App\Actions;

use App\Models\Recipe;
use App\Services\Gemini;
use App\Enums\AiOutputFormat;

class RegenerateRecipe
{
    public static function handle(Recipe $recipe)
    {

        $aiProvider = new Gemini();

        $aiProvider->outputFormat(AiOutputFormat::JSON)
            ->identity('A copywriter with a deep understanding of writing engaging and SEO friendly recipes descriptions.')
            ->addContext('Recipe Name', $recipe->title)
            ->addContext('Recipe Description', $recipe->description)
            ->addContext('Recipe Ingredients', $recipe->recipeIngredients->pluck('display_text')->implode(', '))
            ->addContext('Current Recipe Instructions', implode("\n", $recipe->instructions));

        $aiProvider->setPrompt('
        ## Introduction
        Your task is to rewrite the recipe name, recipe description and instructions using the recipe information, optimised for a UK audience.

        ## Recipe name requirements

        - Create a clear, engaging recipe title suitable for a UK recipe website.
        - Avoid unnecessary marketing fluff.

        ## Recipe description requirements

        - Write a detailed, accurate, and informative description. The description provided has come from a competitor website so should not be used directly.
        - Use clear UK English spelling and terminology.

        ## Recipe instructions requirements
        - The instructions provided have come from a competitor website so should not be used directly.
        - Rewrite the instructions to be more engaging and SEO friendly.
        - The instructions can be in a different order to the original instructions so long as it makes sense
        - Additional instructions can be added to the instructions array to make it more engaging and SEO friendly

        ## Output format
        - Return the final result as a JSON object with exactly five fields:
            - "name" - the recipe title as a plain string
            - "description" - the recipe description as a plain string
            - "instructions" - the recipe instructions as an array of strings
            - "prep_time" - the recipe prep time as an integer (minutes)
            - "cook_time" - the recipe cook time as an integer (minutes)
        - Do not include any additional commentary, explanations, or fields outside the JSON object.

        If you do not have enough information to enrich the recipe or there is any other issue with the recipe, return the following JSON object replacing the reason with the reason why the recipe was not returned:
        {
            "error": "{reason why the recipe was not returned}"
        }
        ');

        try {
            $response = $aiProvider->ask();

            if (empty($response['error'])) {
                $recipe->update([
                    'title' => $response['name'],
                    'description' => $response['description'],
                    'instructions' => $response['instructions'],
                    'prep_time' => $response['prep_time'] ?? 0,
                    'cook_time' => $response['cook_time'] ?? 0,
                ]);
            }

            return $response;
        } catch (\Exception $e) {

            return [
                'error' => $e->getMessage(),
            ];
        }
    }
}

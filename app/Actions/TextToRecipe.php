<?php

namespace App\Actions;

use App\Models\Recipe;
use App\Services\Gemini;
use App\Enums\AiOutputFormat;

class TextToRecipe
{
    public static function handle(string $text)
    {

        dd($text);
        $aiProvider = new Gemini();

        $aiProvider->outputFormat(AiOutputFormat::JSON)
            ->identity('A general AI assistant with a deep understanding of text and data extraction.')
            ->addContext('Input text', $text);

        $aiProvider->setPrompt('
        ## Introduction
        Your task is to understand the input text which is from a PDF document and extract the recipe name, recipe description, instructions and ingredients using the recipe information provided.

        ## Output format
        - Return the final result as a JSON object with exactly six fields:
            - "name" - the recipe title as a plain string
            - "description" - the recipe description as a plain string
            - "instructions" - the recipe instructions as an array of strings
            - "ingredients" - the recipe ingredients as an array of strings
            - "prep_time" - the recipe prep time as an integer (minutes). Guess the prep time if not provided.
            - "cook_time" - the recipe cook time as an integer (minutes). Guess the cook time if not provided.
        - Do not include any additional commentary, explanations, or fields outside the JSON object.

        If you do not have enough information to extract the recipe information, return the following JSON object replacing the reason with the reason why the recipe information was not extracted:
        {
            "error": "{reason why the recipe information was not extracted}"
        }
        ');

        try {
            $response = $aiProvider->ask();


            if (empty($response['error']) && !empty($response['name'])) {

                $recipe = Recipe::create([
                    'title' => $response['name'],
                    'description' => $response['description'],
                    'instructions' => $response['instructions'],
                    'prep_time' => $response['prep_time'] ?? 0,
                    'cook_time' => $response['cook_time'] ?? 0,
                    'servings' => 1,
                ]);

                foreach ($response['ingredients'] as $ingredient) {
                    $recipe->recipeIngredients()->create([
                        'display_text' => $ingredient,
                        'quantity' => 1,
                        'unit' => 'whole',
                    ]);
                }
            }

            return $response;
        } catch (\Exception $e) {

            dd($e->getMessage(), $e->getLine(), $response, $text);
            return [
                'error' => $e->getMessage(),
            ];
        }
    }
}

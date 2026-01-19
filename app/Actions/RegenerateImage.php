<?php

namespace App\Actions;

use App\Models\Recipe;
use App\Services\Gemini;
use App\Enums\AiOutputFormat;
use Illuminate\Support\Facades\Storage;

class RegenerateImage
{
    public static function handle(Recipe $recipe, $prompt = null)
    {

        $aiProvider = new Gemini();

        $aiProvider->outputFormat(AiOutputFormat::IMAGE)
            ->identity('A professional food photographer with a deep understanding of food photography.')
            ->addContext('Recipe Name', $recipe->title)
            ->addContext('Recipe Description', $recipe->description)
            ->addContext('Recipe Ingredients', $recipe->recipeIngredients->pluck('display_text')->implode(', '))
            ->addContext('Recipe Instructions', implode("\n", $recipe->instructions));

        if (!empty($recipe->image)) {
            $aiProvider->addImageContext(base64_encode(file_get_contents(Storage::disk('public')->path($recipe->image))));
        }

        $prompt = '
       Create a picture of this dish using the recipe information provided. A competitor picture may have been provided, this should be used for reference but should not be used directly. 
       If an image has been provided, ensure the scene is different as well as the plate and composition of the image. 
       The picture should be a high quality, professional food photograph. It should be in an appropriate style for a UK recipe website.
    ' . $prompt;
        $aiProvider->setPrompt($prompt);

        try {
            return $aiProvider->ask();
        } catch (\Exception $e) {

            dd($e->getMessage());
            return [
                'error' => $e->getMessage(),
            ];
        }
    }
}

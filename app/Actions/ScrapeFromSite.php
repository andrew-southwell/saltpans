<?php

namespace App\Actions;

use App\Models\Recipe;
use Illuminate\Support\Str;

class ScrapeFromSite
{
    public static function scrape($url)
    {

        $html = file_get_contents($url);

        //look for the schema.org   
        $dom = new \DOMDocument();

        // Suppress errors for malformed HTML (common on real-world websites)
        // This prevents warnings/errors from breaking the script
        libxml_use_internal_errors(true);

        // Load HTML - the @ operator suppresses warnings, but libxml_use_internal_errors
        // is the proper way to handle this
        $dom->loadHTML($html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        // Clear libxml errors (they're expected with real-world HTML)
        libxml_clear_errors();

        $xpath = new \DOMXPath($dom);
        $recipes = $xpath->query('//script[@type="application/ld+json"]');
        foreach ($recipes as $recipe) {
            $json = json_decode($recipe->textContent, true);
            if ($json['@type'] == 'Recipe') {

                $instructions = [];
                foreach ($json['recipeInstructions'] as $instruction) {
                    $instructions[] = $instruction['text'];
                }

                if (!empty($json['image'][0]['url'])) {

                    $name = Str::slug($json['name'] ?? 'Untitled') . '-' . rand(1000000, 9999999) . '.jpg';
                    file_put_contents(storage_path('app/public/recipes/' . $name), file_get_contents($json['image'][0]['url']));
                    $image = 'recipes/' . $name;
                } else {
                    $image = null;
                }

                $recipe = Recipe::create([
                    'title' => $json['name'] ?? 'Untitled',
                    'slug' => Str::slug($json['name'] ?? 'Untitled'),
                    'description' => $json['description'] ?? 'No description',
                    'instructions' => $instructions,
                    'prep_time' => self::parseDuration($json['prepTime'] ?? 0),
                    'cook_time' => self::parseDuration($json['cookTime'] ?? 0),
                    'servings' => $json['recipeYield'] ?? 0,
                    'image' => $image,
                    'source' => $url,
                ]);

                foreach ($json['recipeIngredient'] as $ingredient) {
                    $recipe->recipeIngredients()->create([
                        'display_text' => $ingredient,
                        'quantity' => 1,
                        'unit' => 'whole',
                    ]);
                }
            }
        }
    }

    private static function parseDuration($duration)
    {
        $duration = str_replace('PT', '', $duration);
        $minutes = 0;
        if (preg_match('/(\d+)H/', $duration, $matches)) {
            $minutes += (int)$matches[1] * 60;
        }
        return $minutes;
    }
}

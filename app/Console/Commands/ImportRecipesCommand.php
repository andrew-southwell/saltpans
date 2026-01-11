<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Recipe;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImportRecipesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'recipes:import {--file=storage/rkapp/recipes.html : Path to the recipes.html file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import recipes from recipes.html file';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $filePath = $this->option('file');
        
        // Convert relative paths to absolute
        if (!str_starts_with($filePath, '/') && !preg_match('/^[A-Z]:/', $filePath)) {
            $filePath = base_path($filePath);
        }
        
        if (!file_exists($filePath)) {
            $this->error("File not found: {$filePath}");
            return Command::FAILURE;
        }

        $this->info("Reading recipes from: {$filePath}");
        
        $html = file_get_contents($filePath);
        
        // Load HTML into DOMDocument
        libxml_use_internal_errors(true);
        $dom = new \DOMDocument();
        $dom->loadHTML('<?xml encoding="UTF-8">' . $html);
        libxml_clear_errors();
        
        $xpath = new \DOMXPath($dom);
        
        // Find all recipe-details divs
        $recipeNodes = $xpath->query("//div[@class='recipe-details']");
        
        $this->info("Found {$recipeNodes->length} recipes to process");
        
        $imported = 0;
        $skipped = 0;
        $errors = 0;
        
        // Get or create a default category
        $defaultCategory = Category::first();
        if (!$defaultCategory) {
            $defaultCategory = Category::create([
                'name' => 'Uncategorized',
                'description' => 'Recipes without a specific category',
            ]);
            $this->info("Created default category: Uncategorized");
        }
        
        foreach ($recipeNodes as $recipeNode) {
            try {
                $recipeData = $this->extractRecipeData($recipeNode, $xpath);
                
                if (!$recipeData) {
                    $errors++;
                    continue;
                }
                
                // Check if recipe already exists
                $existingRecipe = Recipe::where('title', $recipeData['title'])
                    ->orWhere('slug', Str::slug($recipeData['title']))
                    ->first();
                
                if ($existingRecipe) {
                    $this->warn("Skipping existing recipe: {$recipeData['title']}");
                    $skipped++;
                    continue;
                }
                
                // Copy image if it exists
                if (!empty($recipeData['image'])) {
                    $imagePath = $this->copyImage($recipeData['image']);
                    $recipeData['image'] = $imagePath;
                }
                
                // Set category (use default for now, could be enhanced to parse categories from HTML)
                $recipeData['category_id'] = $defaultCategory->id;
                
                // Create recipe
                Recipe::create($recipeData);
                
                $this->info("Imported: {$recipeData['title']}");
                $imported++;
                
            } catch (\Exception $e) {
                $this->error("Error processing recipe: " . $e->getMessage());
                $errors++;
            }
        }
        
        $this->newLine();
        $this->info("Import complete!");
        $this->info("Imported: {$imported}");
        $this->info("Skipped: {$skipped}");
        $this->info("Errors: {$errors}");
        
        return Command::SUCCESS;
    }
    
    /**
     * Extract recipe data from a recipe node
     */
    private function extractRecipeData($recipeNode, $xpath)
    {
        // Extract title
        $titleNode = $xpath->query(".//h2[@itemprop='name']", $recipeNode)->item(0);
        if (!$titleNode) {
            return null;
        }
        $title = html_entity_decode(trim($titleNode->textContent), ENT_QUOTES | ENT_HTML5, 'UTF-8');
        
        // Extract image
        $imageNode = $xpath->query(".//img[@class='recipe-photo']", $recipeNode)->item(0);
        $image = null;
        if ($imageNode && $imageNode->hasAttribute('src')) {
            $image = $imageNode->getAttribute('src');
            // Remove 'images/' prefix if present
            $image = str_replace('images/', '', $image);
        }
        
        // Extract servings
        $servingsNode = $xpath->query(".//span[@itemprop='recipeYield']", $recipeNode)->item(0);
        $servings = $servingsNode ? (int)trim($servingsNode->textContent) : 1;
        
        // Extract prep time (from meta tag PT20M format)
        $prepTimeNode = $xpath->query(".//meta[@itemprop='prepTime']", $recipeNode)->item(0);
        $prepTime = 0;
        if ($prepTimeNode && $prepTimeNode->hasAttribute('content')) {
            $prepTime = $this->parseDuration($prepTimeNode->getAttribute('content'));
        }
        
        // Extract cook time
        $cookTimeNode = $xpath->query(".//meta[@itemprop='cookTime']", $recipeNode)->item(0);
        $cookTime = 0;
        if ($cookTimeNode && $cookTimeNode->hasAttribute('content')) {
            $cookTime = $this->parseDuration($cookTimeNode->getAttribute('content'));
        }
        
        // Extract ingredients
        $ingredientsNode = $xpath->query(".//div[@itemprop='recipeIngredients']", $recipeNode)->item(0);
        $ingredients = [];
        if ($ingredientsNode) {
            $ingredientNodes = $xpath->query(".//p", $ingredientsNode);
            foreach ($ingredientNodes as $ingredientNode) {
                $ingredient = html_entity_decode(trim($ingredientNode->textContent), ENT_QUOTES | ENT_HTML5, 'UTF-8');
                if (!empty($ingredient)) {
                    $ingredients[] = $ingredient;
                }
            }
        }
        
        // Extract instructions
        $instructionsNode = $xpath->query(".//div[@itemprop='recipeDirections']", $recipeNode)->item(0);
        $instructions = [];
        if ($instructionsNode) {
            $instructionNodes = $xpath->query(".//p", $instructionsNode);
            foreach ($instructionNodes as $instructionNode) {
                $instruction = html_entity_decode(trim($instructionNode->textContent), ENT_QUOTES | ENT_HTML5, 'UTF-8');
                if (!empty($instruction)) {
                    $instruction = $this->removeStepNumber($instruction);
                    $instructions[] = $instruction;
                }
            }
        }
        
        // Create description from first instruction or use a default
        $description = !empty($instructions) ? Str::limit($instructions[0], 200) : 'Delicious recipe';
        
        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'description' => $description,
            'ingredients' => $ingredients,
            'instructions' => $instructions,
            'prep_time' => $prepTime,
            'cook_time' => $cookTime,
            'servings' => $servings,
            'image' => $image,
        ];
    }
    
    /**
     * Remove numbered prefixes from instruction steps (e.g., "1. ", "2. ", "1)", etc.)
     */
    private function removeStepNumber($instruction)
    {
        // Remove patterns like "1. ", "2. ", "10. " at the start
        $instruction = preg_replace('/^\d+\.\s+/', '', $instruction);
        
        // Remove patterns like "1) ", "2) ", "10) " at the start
        $instruction = preg_replace('/^\d+\)\s+/', '', $instruction);
        
        // Remove patterns like "(1) ", "(2) " at the start
        $instruction = preg_replace('/^\(\d+\)\s+/', '', $instruction);
        
        return trim($instruction);
    }
    
    /**
     * Parse ISO 8601 duration (PT20M) to minutes
     */
    private function parseDuration($duration)
    {
        // Remove PT prefix
        $duration = str_replace('PT', '', $duration);
        
        $minutes = 0;
        
        // Extract hours
        if (preg_match('/(\d+)H/', $duration, $matches)) {
            $minutes += (int)$matches[1] * 60;
        }
        
        // Extract minutes
        if (preg_match('/(\d+)M/', $duration, $matches)) {
            $minutes += (int)$matches[1];
        }
        
        return $minutes;
    }
    
    /**
     * Copy image from rkapp/images to public storage
     */
    private function copyImage($imageName)
    {
        // rkapp folder is directly in storage/, not storage/app/
        $sourcePath = base_path("storage/rkapp/images/{$imageName}");
        $destinationPath = "recipes/{$imageName}";
        
        if (!file_exists($sourcePath)) {
            $this->warn("Image not found: {$sourcePath}");
            return null;
        }
        
        // Ensure directory exists
        Storage::disk('public')->makeDirectory('recipes');
        
        // Copy file
        Storage::disk('public')->put($destinationPath, file_get_contents($sourcePath));
        
        return $destinationPath;
    }
}


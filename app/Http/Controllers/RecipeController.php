<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Http\Request;

class RecipeController extends Controller
{
    public function index()
    {
        $recipes = Recipe::with('category')
            ->latest()
            ->where('published', true)
            ->where('featured', true)
            ->paginate(12);

        return view('recipes.index', compact('recipes'));
    }

    public function show($slug)
    {
        $recipe = Recipe::with(['category', 'relatedRecipes.category'])
            ->where('slug', $slug)
            ->firstOrFail();

        // Get manually selected related recipe IDs to exclude from auto-generated
        $manualRelatedIds = $recipe->relatedRecipes->pluck('id')->toArray();
        $excludeIds = array_merge([$recipe->id], $manualRelatedIds);

        // Extract meaningful words from the recipe title
        $titleWords = $this->extractTitleWords($recipe->title);

        // Find recipes that share any words in their title
        $autoRelatedRecipes = collect();

        if (!empty($titleWords)) {
            $autoRelatedRecipes = Recipe::with('category')
                ->where('id', '!=', $recipe->id)
                ->whereNotIn('id', $excludeIds)
                ->where('published', true)
                ->where(function ($query) use ($titleWords) {
                    foreach ($titleWords as $word) {
                        $query->orWhere('title', 'like', '%' . $word . '%');
                    }
                })
                ->limit(6)
                ->get();
        }

        return view('recipes.show', compact('recipe', 'autoRelatedRecipes'));
    }

    /**
     * Extract meaningful words from a recipe title
     * Filters out common stop words
     */
    private function extractTitleWords(string $title): array
    {
        // Common stop words to filter out
        $stopWords = ['the', 'a', 'an', 'and', 'or', 'but', 'in', 'on', 'at', 'to', 'for', 'of', 'with', 'by', 'from', 'as', 'is', 'was', 'are', 'were', 'be', 'been', 'being', 'have', 'has', 'had', 'do', 'does', 'did', 'will', 'would', 'should', 'could', 'may', 'might', 'must', 'can'];

        // Convert to lowercase and split into words
        $words = preg_split('/\s+/', strtolower($title));

        // Filter out stop words and words shorter than 3 characters
        $words = array_filter($words, function ($word) use ($stopWords) {
            $word = trim($word, '.,!?;:()[]{}"\'-');
            return strlen($word) >= 3 && !in_array($word, $stopWords);
        });

        return array_values($words);
    }

    public function search(Request $request)
    {
        $searchTerm = $request->get('q', '');

        $recipes = Recipe::with('category')
            ->where('published', true)
            ->where(function ($q) use ($searchTerm) {
                $q->where('title', 'like', '%' . $searchTerm . '%')
                    ->orWhere('description', 'like', '%' . $searchTerm . '%')
                    // ->orWhere('ingredients', 'like', '%' . $query . '%')
                    ->orWhere('instructions', 'like', '%' . $searchTerm . '%')
                    ->orWhereHas('recipeIngredients', function ($query) use ($searchTerm) {
                        $query->where('display_text', 'like', '%' . $searchTerm . '%');
                    });
            })
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('recipes.search', compact('recipes', 'searchTerm'));
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Recipe extends Model
{
    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'description',
        'ingredients',
        'instructions',
        'prep_time',
        'cook_time',
        'servings',
        'image',
    ];

    protected function casts(): array
    {
        return [
            'ingredients' => 'array',
            'instructions' => 'array',
        ];
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($recipe) {
            if (!isset($recipe->slug) || empty($recipe->slug)) {
                $recipe->slug = Str::slug($recipe->title);
            }
        });

        static::updating(function ($recipe) {
            if ($recipe->isDirty('title') && (empty($recipe->slug) || !isset($recipe->slug))) {
                $recipe->slug = Str::slug($recipe->title);
            }
        });
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function relatedRecipes(): BelongsToMany
    {
        return $this->belongsToMany(
            Recipe::class,
            'recipe_related_recipes',
            'recipe_id',
            'related_recipe_id'
        )->withTimestamps();
    }

    /**
     * Attach related recipes to this recipe
     * 
     * @param array|int $recipeIds Array of recipe IDs or single recipe ID
     * @return void
     */
    public function attachRelatedRecipes($recipeIds): void
    {
        $recipeIds = is_array($recipeIds) ? $recipeIds : [$recipeIds];
        
        // Filter out self-reference
        $recipeIds = array_filter($recipeIds, fn($id) => $id != $this->id);
        
        $this->relatedRecipes()->syncWithoutDetaching($recipeIds);
    }

    /**
     * Sync related recipes (replace all existing with new ones)
     * 
     * @param array|int $recipeIds Array of recipe IDs or single recipe ID
     * @return void
     */
    public function syncRelatedRecipes($recipeIds): void
    {
        $recipeIds = is_array($recipeIds) ? $recipeIds : [$recipeIds];
        
        // Filter out self-reference
        $recipeIds = array_filter($recipeIds, fn($id) => $id != $this->id);
        
        $this->relatedRecipes()->sync($recipeIds);
    }
}

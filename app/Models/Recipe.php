<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Recipe extends Model
{
    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'description',
        'instructions',
        'prep_time',
        'cook_time',
        'published',
        'featured',
        'source',
        'servings',
        'image',
    ];

    protected function casts(): array
    {
        return [
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

            $recipe->added_by = Auth::user()->id ?? null;
        });

        static::updating(function ($recipe) {
            if ($recipe->isDirty('title') && (empty($recipe->slug) || !isset($recipe->slug))) {
                $recipe->slug = Str::slug($recipe->title);
            }

            //Make sure the instructions are an array            
            $instructions = [];

            foreach ($recipe->instructions as $instruction) {

                foreach (explode("\n", $instruction) as $line) {
                    if (strlen(trim($line)) > 3) {
                        $instructions[] = $line;
                    }
                }
            }

            $recipe->instructions = $instructions;
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

    public function recipeIngredients(): HasMany
    {
        return $this->hasMany(RecipeIngredient::class);
    }
}

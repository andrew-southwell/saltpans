<?php

namespace App\Models;

use Illuminate\Support\Str;
use App\Enums\IngredientUom;
use App\Enums\IngredientType;
use App\Models\RecipeIngredient;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Ingredient extends Model
{
    protected $fillable = [
        'name',
        'type',
        'uom',
    ];

    protected function casts(): array
    {
        return [
            'type' => IngredientType::class,
            'uom' => IngredientUom::class,
        ];
    }

    public function recipeIngredients(): HasMany
    {
        return $this->hasMany(RecipeIngredient::class);
    }
}

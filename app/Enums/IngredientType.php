<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum IngredientType: string implements HasLabel, HasColor
{
    case Staple = 'staple';
    case CupboardStaple = 'cupboard_staple';
    case RecipeSpecific = 'recipe_specific';

    public function getLabel(): string
    {
        return match ($this) {
            self::Staple => 'Staple',
            self::CupboardStaple => 'Cupboard Staple',
            self::RecipeSpecific => 'Recipe Specific',
        };
    }
    public function getColor(): string
    {
        return match ($this) {
            self::Staple => 'info',
            self::CupboardStaple => 'success',
            self::RecipeSpecific => 'warning',
        };
    }
    public function getDescription(): string
    {
        return match ($this) {
            self::Staple => 'Something that the average person always has in the pantry',
            self::CupboardStaple => 'Something that the average person usually will have in the cupboard',
            self::RecipeSpecific => 'Something that is typically bought for a specific recipe',
        };
    }
    public static function getDescriptions(): array
    {

        $descriptions = [];

        foreach (self::cases() as $case) {
            $descriptions[$case->value] = $case->getDescription();
        }

        return $descriptions;
    }
}

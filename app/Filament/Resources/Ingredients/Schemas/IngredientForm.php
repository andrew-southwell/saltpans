<?php

namespace App\Filament\Resources\Ingredients\Schemas;

use App\Enums\IngredientUom;
use Filament\Schemas\Schema;
use App\Enums\IngredientType;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;

class IngredientForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components(self::components());
    }

    public static function components(): array
    {
        return [
            TextInput::make('name')
                ->required()
                ->maxLength(255)
                ->unique(ignoreRecord: true),
            Radio::make('type')
                ->enum(IngredientType::class)
                ->options(IngredientType::class)
                ->descriptions(IngredientType::getDescriptions())
                ->default(IngredientType::RecipeSpecific),
            Select::make('uom')
                ->enum(IngredientUom::class)
                ->options(IngredientUom::class)
                ->default(IngredientUom::Grams),
        ];
    }
}

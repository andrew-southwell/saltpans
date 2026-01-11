<?php

namespace App\Filament\Resources\Recipes\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class RecipeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('category_id')
                    ->relationship('category', 'name')
                    ->required()
                    ->searchable()
                    ->preload(),
                TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(function (string $operation, $state, $set) {
                        if ($operation === 'create') {
                            $set('slug', Str::slug($state));
                        }
                    }),
                TextInput::make('slug')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true)
                    ->dehydrated(),
                Textarea::make('description')
                    ->required()
                    ->rows(3)
                    ->columnSpanFull(),
                Repeater::make('ingredients')
                    ->simple(
                        TextInput::make('ingredient')
                            ->label('Ingredient')
                            ->required()
                    )
                    ->defaultItems(1)
                    ->addActionLabel('Add Ingredient')
                    ->required()
                    ->columnSpanFull(),
                Repeater::make('instructions')
                    ->simple(
                        Textarea::make('instruction')
                            ->label('Step')
                            ->rows(3)
                            ->required()
                    )
                    ->defaultItems(1)
                    ->addActionLabel('Add Step')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('prep_time')
                    ->label('Prep Time (minutes)')
                    ->required()
                    ->numeric()
                    ->minValue(0),
                TextInput::make('cook_time')
                    ->label('Cook Time (minutes)')
                    ->required()
                    ->numeric()
                    ->minValue(0),
                TextInput::make('servings')
                    ->required()
                    ->numeric()
                    ->minValue(1),
                FileUpload::make('image')
                    ->image()
                    ->disk('public')
                    ->directory('recipes')
                    ->visibility('public')
                    ->imageEditor()
                    ->columnSpanFull(),
                Select::make('relatedRecipes')
                    ->relationship(
                        name: 'relatedRecipes',
                        titleAttribute: 'title',
                        modifyQueryUsing: function ($query, $record) {
                            // Exclude the current recipe from the options
                            if ($record) {
                                $query->where('recipes.id', '!=', $record->id);
                            }
                            return $query;
                        }
                    )
                    ->multiple()
                    ->searchable()
                    ->preload()
                    ->label('Related Recipes')
                    ->helperText('Select recipes that are related to this one')
                    ->columnSpanFull(),
            ]);
    }
}

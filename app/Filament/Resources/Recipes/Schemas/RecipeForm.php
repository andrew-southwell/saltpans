<?php

namespace App\Filament\Resources\Recipes\Schemas;

use App\Models\Ingredient;
use Illuminate\Support\Str;
use App\Enums\IngredientUom;
use Filament\Schemas\Schema;
use App\Models\RecipeIngredient;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Repeater\TableColumn;
use Filament\Forms\Components\RichEditor\MentionProvider;
use App\Filament\Resources\Ingredients\Schemas\IngredientForm;

class RecipeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                Grid::make(10)
                    ->schema([
                        Section::make('Recipe Details')
                            ->heading('Recipe Details')
                            ->schema([
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
                                Toggle::make('published')
                                    ->default(true)
                                    ->label('Published'),
                                Toggle::make('featured')
                                    ->default(false)
                                    ->label('Featured On Homepage'),
                                Textarea::make('description')
                                    ->required()
                                    ->rows(3)
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
                                    ->columnSpanFull()
                            ])->columnSpan(4),
                        Section::make('Recipe Instructions')
                            ->heading('Recipe Instructions')
                            ->schema([

                                Repeater::make('instructions')
                                    ->simple(
                                        Textarea::make('instruction')
                                            ->label('Step')
                                            ->rows(3)
                                    )
                                    ->defaultItems(1)
                                    ->addActionLabel('Add Step')
                                    ->required()
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
                                    ->helperText('Select recipes that are related such as making fresh pasta, the perfect mash, home made curry mix etc. ')
                                    ->columnSpanFull(),
                            ])->columnSpan(6),
                    ])->columnSpanFull(),
                Section::make('Recipe Ingredients')
                    ->heading('Recipe Ingredients')
                    ->schema([
                        Repeater::make('recipeIngredients')
                            ->relationship('recipeIngredients')
                            ->table([
                                TableColumn::make('Ingredient')->width('35%'),
                                TableColumn::make('Amount')->width('10%'),
                                TableColumn::make('Unit')->width('20%'),
                                TableColumn::make('Display Text')->width('35%'),
                            ])
                            ->schema([
                                Select::make('ingredient_id')
                                    ->relationship('ingredient', 'name')
                                    ->label('Ingredient')
                                    ->reactive()
                                    ->createOptionForm(IngredientForm::components())
                                    ->afterStateUpdated(function ($state, $set, $get) {
                                        $ingredient = Ingredient::find($state)->uom;
                                        if ($ingredient) {
                                            $set('unit', $ingredient->value);
                                        }

                                        self::updateDisplayText($set, $get);
                                    })
                                    ->searchable()
                                    ->preload(),

                                TextInput::make('amount')
                                    ->label('Amount')
                                    ->numeric()
                                    ->afterStateUpdated(function ($state, $set, $get) {
                                        self::updateDisplayText($set, $get);
                                    })
                                    ->default(1)
                                    ->reactive(),
                                Select::make('unit')
                                    ->label('Unit')
                                    ->options(IngredientUom::class)
                                    ->reactive()
                                    ->afterStateUpdated(function ($state, $set, $get) {
                                        self::updateDisplayText($set, $get);
                                    }),
                                TextInput::make('display_text')
                                    ->label('Display Text')
                                    ->columnSpanFull(),
                            ])
                            ->defaultItems(1)
                            ->addActionLabel('Add Ingredient')
                            ->reorderable()
                    ])
                    ->columnSpanFull(),

            ]);
    }

    public static function updateDisplayText($set, $get): void
    {
        $ingredientId = $get('ingredient_id');
        $amount = $get('amount');
        $unit = $get('unit');

        if ($ingredientId && $amount) {
            $ingredient = \App\Models\Ingredient::find($ingredientId);

            if ($amount > 1) {
                $set('display_text', "{$amount}{$unit->getDisplayLabel()} {$ingredient->name}");
            } else {
                $set('display_text', "{$amount}{$unit->getDisplayLabelSingular()} {$ingredient->name}");
            }
        }
    }
}

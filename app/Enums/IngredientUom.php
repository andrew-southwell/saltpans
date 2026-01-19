<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum IngredientUom: string implements HasLabel
{
    case Each = 'each';
    case Grams = 'grams';
    case Kilograms = 'kilograms';
    case Litres = 'litres';
    case Millilitres = 'millilitres';
    case Pieces = 'pieces';
    case Cups = 'cups';
    case Teaspoons = 'teaspoons';
    case Tablespoons = 'tablespoons';
    case Tins = 'tins';
    case Ounces = 'ounces';
    case Pounds = 'pounds';
    case Cans = 'cans';
    case Bottles = 'bottles';
    case Boxes = 'boxes';
    case Bags = 'bags';
    case Sachets = 'sachets';
    case Rolls = 'rolls';
    case Sheets = 'sheets';
    case Squares = 'squares';
    case Whole = 'whole';

    public function getLabel(): string
    {
        return match ($this) {
            self::Each => 'Each',
            self::Grams => 'Grams',
            self::Kilograms => 'Kilograms',
            self::Litres => 'Litres',
            self::Millilitres => 'Millilitres',
            self::Pieces => 'Pieces',
            self::Cups => 'Cups',
            self::Teaspoons => 'Teaspoons',
            self::Tablespoons => 'Tablespoons',
            self::Tins => 'Tins',
            self::Ounces => 'Ounces',
            self::Pounds => 'Pounds',
            self::Cans => 'Cans',
            self::Bottles => 'Bottles',
            self::Boxes => 'Boxes',
            self::Bags => 'Bags',
            self::Sachets => 'Sachets',
            self::Rolls => 'Rolls',
            self::Sheets => 'Sheets',
            self::Squares => 'Squares',
            self::Whole => 'Whole',
        };
    }

    public function getDisplayLabel(): string
    {
        return match ($this) {
            self::Each => '',
            self::Grams => 'g of',
            self::Kilograms => 'kg of',
            self::Litres => 'l of',
            self::Millilitres => 'ml of',
            self::Pieces => ' pieces of',
            self::Cups => ' cups of',
            self::Teaspoons => ' tsp of',
            self::Tablespoons => ' tbsp of',
            self::Tins => ' tins of',
            self::Ounces => ' oz of',
            self::Pounds => ' lbs. of',
            self::Cans => ' cans of',
            self::Bottles => ' bottles ',
            self::Boxes => ' boxes of',
            self::Bags => ' bags of',
            self::Sachets => ' sachets of',
            self::Rolls => ' rolls of',
            self::Sheets => ' sheets of',
            self::Squares => ' squares of',
            self::Whole => ' whole',
        };
    }

    public function getDisplayLabelSingular(): string
    {
        return match ($this) {
            self::Each => '',
            self::Grams => 'g of',
            self::Kilograms => 'kg of',
            self::Litres => 'l of',
            self::Millilitres => 'ml of',
            self::Pieces => ' peice of',
            self::Cups => ' cup of',
            self::Teaspoons => ' tsp of',
            self::Tablespoons => ' tbsp of',
            self::Tins => ' tin of',
            self::Ounces => ' oz of',
            self::Pounds => ' lb of',
            self::Cans => ' can of',
            self::Bottles => ' bottle of',
            self::Boxes => ' box of',
            self::Bags => ' bag of',
            self::Sachets => ' sachet of',
            self::Rolls => ' roll of',
            self::Sheets => ' sheet of',
            self::Squares => ' square of',
            self::Whole => ' whole',
        };
    }
}

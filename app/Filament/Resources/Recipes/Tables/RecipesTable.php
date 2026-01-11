<?php

namespace App\Filament\Resources\Recipes\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class RecipesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                    ->disk('public')
                    ->visibility('public')
                    ->circular()
                    ->size(50),
                TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('category.name')
                    ->searchable()
                    ->sortable()
                    ->badge(),
                TextColumn::make('description')
                    ->limit(50)
                    ->wrap()
                    ->toggleable(),
                TextColumn::make('prep_time')
                    ->label('Prep')
                    ->numeric()
                    ->sortable()
                    ->suffix(' min'),
                TextColumn::make('cook_time')
                    ->label('Cook')
                    ->numeric()
                    ->sortable()
                    ->suffix(' min'),
                TextColumn::make('servings')
                    ->numeric()
                    ->sortable()
                    ->suffix(' servings'),
                TextColumn::make('slug')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}

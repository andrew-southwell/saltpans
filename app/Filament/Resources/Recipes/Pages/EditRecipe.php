<?php

namespace App\Filament\Resources\Recipes\Pages;

use App\Models\Recipe;
use Filament\Actions\Action;
use App\Actions\RegenerateRecipe;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\Recipes\RecipeResource;

class EditRecipe extends EditRecord
{
    protected static string $resource = RecipeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            Action::make('regenerate')
                ->label('Regenerate Recipe')
                ->action(function (Recipe $recipe) {
                    RegenerateRecipe::handle($recipe);
                }),
        ];
    }
}

<?php

namespace App\Filament\Resources\Recipes\Pages;

use App\Models\Recipe;
use Filament\Actions\Action;
use App\Actions\RegenerateImage;
use App\Actions\RegenerateRecipe;
use Filament\Actions\DeleteAction;
use Illuminate\Support\Facades\Storage;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\Recipes\RecipeResource;
use Filament\Forms\Components\TextInput;

class EditRecipe extends EditRecord
{
    protected static string $resource = RecipeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            Action::make('regenerate')
                ->label('Regenerate Recipe')
                ->icon('heroicon-o-pencil')
                ->action(function (Recipe $recipe) {
                    RegenerateRecipe::handle($recipe);
                }),
            Action::make('regenerate-image')
                ->label('Regenerate Image')
                ->icon('heroicon-o-photo')
                ->visible(fn(Recipe $record) => $record->image)
                ->action(function (Recipe $recipe) {

                    $image = RegenerateImage::handle($recipe);

                    if (!empty($image)) {
                        file_put_contents(Storage::disk('public')->path($recipe->image), base64_decode($image));
                    }
                }),
            Action::make('regenerate-new-image')
                ->label('Regenerate New Image')
                ->icon('heroicon-o-photo')
                ->schema([
                    TextInput::make('prompt')
                        ->label('Prompt')
                        ->helperText('If you wish to customise the prompt for generating the image, enter it here. Leave empty to use system defaults')
                        ->maxLength(1000)
                ])
                ->visible(fn(Recipe $record) => empty($record->image))
                ->action(function (Recipe $recipe, $data) {
                    $image = RegenerateImage::handle($recipe, $data['prompt']);

                    if (!empty($image)) {
                        file_put_contents(Storage::disk('public')->path('recipes/' . $recipe->slug . '.jpg'), base64_decode($image));
                        $recipe->update([
                            'image' => 'recipes/' . $recipe->slug . '.jpg'
                        ]);

                        //refresh
                    }
                }),
        ];
    }
}

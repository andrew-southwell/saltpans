<?php

namespace App\Filament\Resources\Recipes\Pages;

use App\Actions\PdfToText;
use Illuminate\Support\Str;
use Filament\Actions\Action;
use App\Actions\TextToRecipe;
use App\Actions\ScrapeFromSite;
use Filament\Actions\CreateAction;
use Illuminate\Support\Facades\Storage;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\Recipes\RecipeResource;

class ListRecipes extends ListRecords
{
    protected static string $resource = RecipeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
            Action::make('import')
                ->label('Import from PDF')
                ->icon('heroicon-o-document-text')
                ->modalHeading('Import from PDF')
                ->modalDescription('Upload a PDF file to import recipes from.')
                ->schema([
                    FileUpload::make('pdf')
                        ->required()
                        ->directory('imports'),
                ])
                ->action(function (array $data) {

                    $text = PdfToText::handle(Storage::path($data['pdf']));
                    dd($text);
                    $recipes = TextToRecipe::handle($text);
                }),
            Action::make('scrape')
                ->label('Scrape from site')
                ->icon('heroicon-o-globe-alt')
                ->modalHeading('Scrape from site')
                ->modalDescription('Enter the URL of the site to scrape recipes from.')
                ->schema([
                    TextInput::make('url')
                        ->url()
                        ->required(),
                ])->action(function (array $data) {
                    ScrapeFromSite::scrape($data['url']);
                }),
        ];
    }
}

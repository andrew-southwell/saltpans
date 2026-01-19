<?php

use App\Actions\PdfToText;
use App\Actions\TextToRecipe;
use App\Services\ScrapeFromSite;
use App\Actions\RegenerateRecipe;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\CategoryController;

Route::get('/', [RecipeController::class, 'index'])->name('recipes.index');
Route::get('/search', [RecipeController::class, 'search'])->name('recipes.search');
Route::get('/categories/{slug}', [CategoryController::class, 'show'])->name('categories.show');
Route::get('/recipes/{slug}', [RecipeController::class, 'show'])->name('recipes.show');

// Route::get('/scrape', [ScrapeFromSite::class, 'scrape'])->name('scrape');
// Route::get('/regenerate-recipe/{recipe:id} ', [RegenerateRecipe::class, 'handle'])->name('regenerate-recipe');
// Route::get('/test', function () {
//     // PdfToText::handle(storage_path('app/private/imports/01KFAX7K1DQXPQTQTAHBSYW676.pdf'));
//     TextToRecipe::handle(file_get_contents(storage_path('app/private/imports/text.txt')));
// })->name('test');

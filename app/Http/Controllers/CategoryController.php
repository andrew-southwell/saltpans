<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function show($slug)
    {
        $category = Category::where('slug', $slug)
            ->with(['recipes' => function ($query) {
                $query->where('published', true);
            }])
            ->firstOrFail();

        $recipes = $category->recipes()
            ->where('published', true)
            ->latest()
            ->paginate(12);

        return view('categories.show', compact('category', 'recipes'));
    }
}

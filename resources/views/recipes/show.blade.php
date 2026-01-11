@extends('layouts.app')

@section('title', $recipe->title)

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <!-- Back Link -->
    <a href="{{ route('recipes.index') }}" 
       class="inline-flex items-center text-xs font-sans font-light text-[#999] hover:text-[#1a1a1a] mb-12 transition-colors group uppercase tracking-wider">
        <svg class="w-3 h-3 mr-2 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 19l-7-7 7-7"></path>
        </svg>
        Back to Recipes
    </a>

    <!-- Recipe Header -->
    <div class="mb-16 text-center">
        <div class="mb-8">
            <a href="{{ route('categories.show', $recipe->category->slug) }}" 
               class="inline-block text-xs font-sans font-light text-[#999] hover:text-[#1a1a1a] transition-colors uppercase tracking-[0.2em]">
                {{ $recipe->category->name }}
            </a>
        </div>
        <h1 class="text-5xl md:text-6xl lg:text-7xl font-serif text-[#1a1a1a] mb-8 leading-[1.1] font-normal">
            {{ $recipe->title }}
        </h1>
        <div class="max-w-2xl mx-auto mb-12">
            <div class="flex items-center justify-center gap-8 text-xs font-sans font-light text-[#666] uppercase tracking-wider">
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>Prep: {{ $recipe->prep_time }} min</span>
                </div>
                <div class="w-px h-4 bg-[#e5e5e5]"></div>
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>Cook: {{ $recipe->cook_time }} min</span>
                </div>
                <div class="w-px h-4 bg-[#e5e5e5]"></div>
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    <span>{{ $recipe->servings }} servings</span>
                </div>
            </div>
        </div>
        <p class="text-lg md:text-xl font-elegant text-[#666] max-w-3xl mx-auto leading-relaxed font-light">
            {{ $recipe->description }}
        </p>
    </div>

    <!-- Recipe Image -->
    @if($recipe->image)
        <div class="mb-16 overflow-hidden">
            <img src="{{ str_starts_with($recipe->image, 'http') ? $recipe->image : '/' . $recipe->image }}" alt="{{ $recipe->title }}" class="w-full h-auto">
        </div>
    @endif

    <div class="grid lg:grid-cols-2 gap-20 lg:gap-24">
        <!-- Ingredients -->
        <div class="bg-white">
            <h2 class="text-2xl font-serif text-[#1a1a1a] mb-8 pb-4 border-b border-[#e5e5e5] font-normal">
                Ingredients
            </h2>
            <ul class="space-y-5">
                @if(is_array($recipe->ingredients))
                    @foreach($recipe->ingredients as $ingredient)
                        <li class="flex items-start gap-4 text-[#666] font-sans text-base font-light leading-relaxed">
                            <span class="text-[#999] mt-1.5 text-xs">•</span>
                            <span class="flex-1">{{ $ingredient }}</span>
                        </li>
                    @endforeach
                @else
                    <li class="text-[#666] font-sans text-base font-light leading-relaxed">{{ $recipe->ingredients }}</li>
                @endif
            </ul>
        </div>

        <!-- Instructions -->
        <div class="bg-white">
            <h2 class="text-2xl font-serif text-[#1a1a1a] mb-8 pb-4 border-b border-[#e5e5e5] font-normal">
                Instructions
            </h2>
            <ol class="space-y-8">
                @if(is_array($recipe->instructions))
                    @foreach($recipe->instructions as $index => $instruction)
                        <li class="flex gap-6">
                            <span class="flex-shrink-0 w-8 h-8 rounded-full bg-[#1a1a1a] text-white flex items-center justify-center font-serif text-sm font-normal">
                                {{ $index + 1 }}
                            </span>
                            <span class="text-[#666] font-sans text-base font-light leading-relaxed pt-0.5 flex-1">{{ $instruction }}</span>
                        </li>
                    @endforeach
                @else
                    <li class="text-[#666] font-sans text-base font-light leading-relaxed">{{ $recipe->instructions }}</li>
                @endif
            </ol>
        </div>
    </div>

    <!-- Manually Selected Related Recipes -->
    @if($recipe->relatedRecipes->count() > 0)
        <div class="mt-24 pt-16 border-t border-[#e5e5e5]">
            <h2 class="text-3xl font-serif text-[#1a1a1a] mb-12 font-normal">
                Related Recipes
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-12">
                @foreach($recipe->relatedRecipes as $relatedRecipe)
                    <a href="{{ route('recipes.show', $relatedRecipe->slug) }}" 
                       class="bg-white border border-[#e5e5e5] overflow-hidden hover:border-[#1a1a1a] transition-all duration-300 group">
                        @if($relatedRecipe->image)
                            <div class="aspect-video bg-[#f5f5f5] overflow-hidden">
                                <img src="{{ str_starts_with($relatedRecipe->image, 'http') ? $relatedRecipe->image : '/' . $relatedRecipe->image }}" alt="{{ $relatedRecipe->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            </div>
                        @else
                            <div class="aspect-video bg-[#f5f5f5] flex items-center justify-center">
                                <svg class="w-12 h-12 text-[#999]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                            </div>
                        @endif
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-3">
                                <span class="text-xs font-sans font-light uppercase tracking-wider text-[#999]">
                                    {{ $relatedRecipe->category->name }}
                                </span>
                                <span class="text-xs font-sans font-light text-[#999]">
                                    {{ $relatedRecipe->prep_time + $relatedRecipe->cook_time }} min
                                </span>
                            </div>
                            <h3 class="text-lg font-serif text-[#1a1a1a] mb-2 group-hover:text-[#666] transition-colors font-normal">
                                {{ $relatedRecipe->title }}
                            </h3>
                            <p class="text-sm font-sans font-light text-[#666] line-clamp-2 leading-relaxed">
                                {{ $relatedRecipe->description }}
                            </p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Auto-Generated Related Recipes -->
    @if(isset($autoRelatedRecipes) && $autoRelatedRecipes->count() > 0)
        <div class="mt-24 pt-16 border-t border-[#e5e5e5]">
            <h2 class="text-3xl font-serif text-[#1a1a1a] mb-4 font-normal">
                You Might Also Like
            </h2>
            <p class="text-sm font-sans font-light text-[#999] mb-12">
                Recipes with similar names
            </p>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-12">
                @foreach($autoRelatedRecipes as $autoRecipe)
                    <a href="{{ route('recipes.show', $autoRecipe->slug) }}" 
                       class="bg-white border border-[#e5e5e5] overflow-hidden hover:border-[#1a1a1a] transition-all duration-300 group">
                        @if($autoRecipe->image)
                            <div class="aspect-video bg-[#f5f5f5] overflow-hidden">
                                <img src="{{ str_starts_with($autoRecipe->image, 'http') ? $autoRecipe->image : '/' . $autoRecipe->image }}" alt="{{ $autoRecipe->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            </div>
                        @else
                            <div class="aspect-video bg-[#f5f5f5] flex items-center justify-center">
                                <svg class="w-12 h-12 text-[#999]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                            </div>
                        @endif
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-3">
                                <span class="text-xs font-sans font-light uppercase tracking-wider text-[#999]">
                                    {{ $autoRecipe->category->name }}
                                </span>
                                <span class="text-xs font-sans font-light text-[#999]">
                                    {{ $autoRecipe->prep_time + $autoRecipe->cook_time }} min
                                </span>
                            </div>
                            <h3 class="text-lg font-serif text-[#1a1a1a] mb-2 group-hover:text-[#666] transition-colors font-normal">
                                {{ $autoRecipe->title }}
                            </h3>
                            <p class="text-sm font-sans font-light text-[#666] line-clamp-2 leading-relaxed">
                                {{ $autoRecipe->description }}
                            </p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection


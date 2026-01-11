@extends('layouts.app')

@section('title', $category->name)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
    <!-- Category Header -->
    <div class="mb-16 text-center">
        <a href="{{ route('recipes.index') }}" 
           class="inline-flex items-center text-xs font-sans font-light text-[#999] hover:text-[#1a1a1a] mb-10 transition-colors group uppercase tracking-wider">
            <svg class="w-3 h-3 mr-2 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 19l-7-7 7-7"></path>
            </svg>
            Back to All Recipes
        </a>
        <h1 class="text-5xl md:text-6xl lg:text-7xl font-serif text-[#1a1a1a] mb-8 leading-[1.1] font-normal">
            {{ $category->name }}
        </h1>
        @if($category->description)
            <p class="text-lg md:text-xl font-elegant text-[#666] max-w-2xl mx-auto leading-relaxed font-light">
                {{ $category->description }}
            </p>
        @endif
    </div>

    <!-- Recipes Grid -->
    @if($recipes->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-12 mb-16">
            @foreach($recipes as $recipe)
                <a href="{{ route('recipes.show', $recipe->slug) }}" 
                   class="bg-white border border-[#e5e5e5] overflow-hidden hover:border-[#1a1a1a] transition-all duration-300 group">
                    @if($recipe->image)
                        <div class="aspect-video bg-[#f5f5f5] overflow-hidden">
                            <img src="{{ $recipe->image }}" alt="{{ $recipe->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        </div>
                    @else
                        <div class="aspect-video bg-[#f5f5f5] flex items-center justify-center">
                            <svg class="w-12 h-12 text-[#999]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                        </div>
                    @endif
                    <div class="p-8">
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-xs font-sans font-light uppercase tracking-wider text-[#999]">
                                {{ $recipe->category->name }}
                            </span>
                            <span class="text-xs font-sans font-light text-[#999]">
                                {{ $recipe->prep_time + $recipe->cook_time }} min
                            </span>
                        </div>
                        <h2 class="text-xl font-serif text-[#1a1a1a] mb-3 group-hover:text-[#666] transition-colors font-normal">
                            {{ $recipe->title }}
                        </h2>
                        <p class="text-sm font-sans font-light text-[#666] line-clamp-2 leading-relaxed mb-6">
                            {{ $recipe->description }}
                        </p>
                        <div class="flex items-center gap-4 text-xs font-sans font-light text-[#999] pt-6 border-t border-[#e5e5e5]">
                            <span>{{ $recipe->servings }} servings</span>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-16 flex justify-center">
            {{ $recipes->links() }}
        </div>
    @else
        <div class="text-center py-20">
            <p class="text-lg font-sans font-light text-[#666]">No recipes found in this category. Check back soon!</p>
        </div>
    @endif
</div>
@endsection


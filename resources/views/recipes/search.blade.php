@extends('layouts.app')

@section('title', 'Search Results')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
    <!-- Search Header -->
    <div class="mb-16 text-center">
        <h1 class="text-5xl md:text-6xl lg:text-7xl font-serif text-[#1a1a1a] mb-8 leading-[1.1] font-normal">
            Search Results
        </h1>
        @if($query)
            <p class="text-lg md:text-xl font-elegant text-[#666] max-w-2xl mx-auto leading-relaxed font-light">
                Results for "<span class="font-normal text-[#1a1a1a]">{{ $query }}</span>"
            </p>
        @else
            <p class="text-lg md:text-xl font-elegant text-[#666] max-w-2xl mx-auto leading-relaxed font-light">
                Enter a search term to find recipes
            </p>
        @endif
    </div>

    <!-- Search Form -->
    <div class="max-w-2xl mx-auto mb-16">
        <form action="{{ route('recipes.search') }}" method="GET" class="relative">
            <input type="text" 
                   name="q" 
                   value="{{ $query }}"
                   placeholder="Search recipes..." 
                   class="w-full pl-12 pr-4 py-4 text-base font-sans font-light text-[#1a1a1a] border border-[#e5e5e5] focus:outline-none focus:border-[#1a1a1a] transition-colors"
                   autocomplete="off"
                   autofocus>
            <svg class="absolute left-4 top-1/2 transform -translate-y-1/2 w-5 h-5 text-[#999]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
        </form>
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
    @elseif($query)
        <div class="text-center py-20">
            <p class="text-lg font-sans font-light text-[#666] mb-4">No recipes found matching "{{ $query }}".</p>
            <p class="text-sm font-sans font-light text-[#999]">Try a different search term or <a href="{{ route('recipes.index') }}" class="text-[#1a1a1a] hover:underline">browse all recipes</a>.</p>
        </div>
    @else
        <div class="text-center py-20">
            <p class="text-lg font-sans font-light text-[#666]">Enter a search term above to find recipes.</p>
        </div>
    @endif
</div>
@endsection



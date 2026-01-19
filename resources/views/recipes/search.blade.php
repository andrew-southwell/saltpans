@extends('layouts.app')

@section('title', 'Search Results')

@section('content')
	<div class="mx-auto max-w-7xl px-4 py-20 sm:px-6 lg:px-8">
		<!-- Search Header -->
		<div class="mb-16 text-center">
			<h1 class="mb-8 font-serif text-5xl font-normal leading-[1.1] text-[#1a1a1a] md:text-6xl lg:text-7xl">
				Search Results
			</h1>
			@if ($query)
				<p class="font-elegant mx-auto max-w-2xl text-lg font-light leading-relaxed text-[#666] md:text-xl">
					Results for "<span class="font-normal text-[#1a1a1a]">{{ $query }}</span>"
				</p>
			@else
				<p class="font-elegant mx-auto max-w-2xl text-lg font-light leading-relaxed text-[#666] md:text-xl">
					Enter a search term to find recipes
				</p>
			@endif
		</div>

		<!-- Search Form -->
		<div class="mx-auto mb-16 max-w-2xl">
			<form action="{{ route('recipes.search') }}" method="GET" class="relative">
				<input type="text" name="q" value="{{ $query }}" placeholder="Search recipes..."
					class="w-full border border-[#e5e5e5] py-4 pl-12 pr-4 font-sans text-base font-light text-[#1a1a1a] transition-colors focus:border-[#1a1a1a] focus:outline-none"
					autocomplete="off" autofocus>
				<svg class="absolute left-4 top-1/2 h-5 w-5 -translate-y-1/2 transform text-[#999]" fill="none"
					stroke="currentColor" viewBox="0 0 24 24">
					<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
						d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
				</svg>
			</form>
		</div>

		<!-- Recipes Grid -->
		@if ($recipes->count() > 0)
			<div class="mb-16 grid grid-cols-1 gap-12 md:grid-cols-2 lg:grid-cols-3">
				@foreach ($recipes as $recipe)
					<a href="{{ route('recipes.show', $recipe->slug) }}"
						class="group overflow-hidden border border-[#e5e5e5] bg-white transition-all duration-300 hover:border-[#1a1a1a]">
						@if ($recipe->image)
							<div class="aspect-video overflow-hidden bg-[#f5f5f5]">
								<img src="{{ $recipe->image }}" alt="{{ $recipe->title }}"
									class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105">
							</div>
						@else
							<div class="flex aspect-video items-center justify-center bg-[#f5f5f5]">
								<svg class="h-12 w-12 text-[#999]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
								</svg>
							</div>
						@endif
						<div class="p-8">
							<div class="mb-4 flex items-center justify-between">
								<span class="font-sans text-xs font-light uppercase tracking-wider text-[#999]">
									{{ $recipe->category->name }}
								</span>
								<span class="font-sans text-xs font-light text-[#999]">
									{{ $recipe->prep_time + $recipe->cook_time }} min
								</span>
							</div>
							<h2 class="mb-3 font-serif text-xl font-normal text-[#1a1a1a] transition-colors group-hover:text-[#666]">
								{{ $recipe->title }}
							</h2>
							<p class="mb-6 line-clamp-2 font-sans text-sm font-light leading-relaxed text-[#666]">
								{{ $recipe->description }}
							</p>
							<div class="flex items-center gap-4 border-t border-[#e5e5e5] pt-6 font-sans text-xs font-light text-[#999]">
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
			<div class="py-20 text-center">
				<p class="mb-4 font-sans text-lg font-light text-[#666]">No recipes found matching "{{ $query }}".</p>
				<p class="font-sans text-sm font-light text-[#999]">Try a different search term or <a
						href="{{ route('recipes.index') }}" class="text-[#1a1a1a] hover:underline">browse all recipes</a>.</p>
			</div>
		@else
			<div class="py-20 text-center">
				<p class="font-sans text-lg font-light text-[#666]">Enter a search term above to find recipes.</p>
			</div>
		@endif
	</div>
@endsection

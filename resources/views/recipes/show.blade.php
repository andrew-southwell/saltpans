@extends('layouts.app')

@section('title', $recipe->title)

@section('content')
	<div class="mx-auto max-w-6xl px-4 py-16 sm:px-6 lg:px-8">
		<!-- Back Link -->
		<a href="{{ route('recipes.index') }}"
			class="group mb-12 inline-flex items-center font-sans text-xs font-light uppercase tracking-wider text-[#999] transition-colors hover:text-[#1a1a1a]">
			<svg class="mr-2 h-3 w-3 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor"
				viewBox="0 0 24 24">
				<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 19l-7-7 7-7"></path>
			</svg>
			Back to Recipes
		</a>

		<!-- Recipe Header -->
		<div class="mb-16 text-center">

			<!-- Two Column Layout with first being 40% width and second being 60% width    -->
			<div class="grid grid-cols-1 gap-12 md:grid-cols-[55%_45%]">


				<div>
					<div class="mb-8">
						<a href="{{ route('categories.show', $recipe->category->slug) }}"
							class="inline-block font-sans text-xs font-light uppercase tracking-[0.2em] text-[#999] transition-colors hover:text-[#1a1a1a]">
							{{ $recipe->category->name }}
						</a>
					</div>
					<h1 class="mb-8 font-serif text-5xl font-normal leading-[1.1] text-[#1a1a1a] md:text-6xl lg:text-7xl">
						{{ $recipe->title }}
					</h1>
					<div class="mx-auto mb-12 max-w-2xl">
						<div
							class="flex items-center justify-center gap-8 font-sans text-xs font-light uppercase tracking-wider text-[#666]">
							<div class="flex items-center gap-2">
								<svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
										d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
								</svg>
								<span>Prep: {{ $recipe->prep_time }} min</span>
							</div>
							<div class="h-4 w-px bg-[#e5e5e5]"></div>
							<div class="flex items-center gap-2">
								<svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
										d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
								</svg>
								<span>Cook: {{ $recipe->cook_time }} min</span>
							</div>
							<div class="h-4 w-px bg-[#e5e5e5]"></div>
							<div class="flex items-center gap-2">
								<svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
										d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
									</path>
								</svg>
								<span>{{ $recipe->servings }} servings</span>
							</div>
						</div>
					</div>
					<p class="font-elegant mx-auto max-w-3xl text-lg font-light leading-relaxed text-[#666] md:text-xl">
						{{ $recipe->description }}
					</p>

				</div>
				<div class="mb-16 overflow-hidden">
					<img src="{{ str_starts_with($recipe->image, 'http') ? $recipe->image : '/' . $recipe->image }}"
						alt="{{ $recipe->title }}" class="aspect-square rounded-lg object-cover">
				</div>
			</div>
		</div>



		{{-- <div class="mb-8">
				<a href="{{ route('categories.show', $recipe->category->slug) }}"
					class="inline-block font-sans text-xs font-light uppercase tracking-[0.2em] text-[#999] transition-colors hover:text-[#1a1a1a]">
					{{ $recipe->category->name }}
				</a>
			</div>
			<h1 class="mb-8 font-serif text-5xl font-normal leading-[1.1] text-[#1a1a1a] md:text-6xl lg:text-7xl">
				{{ $recipe->title }}
			</h1>
			<div class="mx-auto mb-12 max-w-2xl">
				<div
					class="flex items-center justify-center gap-8 font-sans text-xs font-light uppercase tracking-wider text-[#666]">
					<div class="flex items-center gap-2">
						<svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
								d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
						</svg>
						<span>Prep: {{ $recipe->prep_time }} min</span>
					</div>
					<div class="h-4 w-px bg-[#e5e5e5]"></div>
					<div class="flex items-center gap-2">
						<svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
								d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
						</svg>
						<span>Cook: {{ $recipe->cook_time }} min</span>
					</div>
					<div class="h-4 w-px bg-[#e5e5e5]"></div>
					<div class="flex items-center gap-2">
						<svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
								d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
							</path>
						</svg>
						<span>{{ $recipe->servings }} servings</span>
					</div>
				</div>
			</div>
			<p class="font-elegant mx-auto max-w-3xl text-lg font-light leading-relaxed text-[#666] md:text-xl">
				{{ $recipe->description }}
			</p>
		</div> --}}

		<!-- Recipe Image -->
		{{-- @if ($recipe->image)
			<div class="mb-16 overflow-hidden">
				<img src="{{ str_starts_with($recipe->image, 'http') ? $recipe->image : '/' . $recipe->image }}"
					alt="{{ $recipe->title }}" class="h-auto w-full">
			</div>
		@endif --}}

		<div class="grid gap-20 lg:grid-cols-2 lg:gap-24">
			<!-- Ingredients -->
			<div class="bg-white">
				<h2 class="mb-8 border-b border-[#e5e5e5] pb-4 font-serif text-2xl font-normal text-[#1a1a1a]">
					Ingredients
				</h2>
				<ul class="space-y-5">


					@foreach ($recipe->recipeIngredients as $recipeIngredient)
						<li class="flex items-start gap-4 font-sans text-base font-light leading-relaxed text-[#666]">
							<span class="mt-1.5 text-xs text-[#999]">•</span>
							<span class="flex-1">{{ $recipeIngredient->display_text }}</span>
						</li>
					@endforeach

				</ul>
			</div>

			<!-- Instructions -->
			<div class="bg-white">
				<h2 class="mb-8 border-b border-[#e5e5e5] pb-4 font-serif text-2xl font-normal text-[#1a1a1a]">
					Instructions
				</h2>
				<ol class="space-y-8">
					@if (is_array($recipe->instructions))
						@foreach ($recipe->instructions as $index => $instruction)
							<li class="flex gap-6">
								<span
									class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-full bg-[#1a1a1a] font-serif text-sm font-normal text-white">
									{{ $index + 1 }}
								</span>
								<span
									class="flex-1 pt-0.5 font-sans text-base font-light leading-relaxed text-[#666]">{{ $instruction }}</span>
							</li>
						@endforeach
					@else
						<li class="font-sans text-base font-light leading-relaxed text-[#666]">{{ $recipe->instructions }}</li>
					@endif
				</ol>
			</div>
		</div>

		<!-- Manually Selected Related Recipes -->
		@if ($recipe->relatedRecipes->count() > 0)
			<div class="mt-24 border-t border-[#e5e5e5] pt-16">
				<h2 class="mb-12 font-serif text-3xl font-normal text-[#1a1a1a]">
					Related Recipes
				</h2>
				<div class="grid grid-cols-1 gap-12 md:grid-cols-2 lg:grid-cols-3">
					@foreach ($recipe->relatedRecipes as $relatedRecipe)
						@include('recipes.partials.recipe-card', ['recipe' => $relatedRecipe])
					@endforeach
				</div>
			</div>
		@endif

		<!-- Auto-Generated Related Recipes -->
		@if (isset($autoRelatedRecipes) && $autoRelatedRecipes->count() > 0)
			<div class="mt-24 border-t border-[#e5e5e5] pt-16">
				<h2 class="mb-4 font-serif text-3xl font-normal text-[#1a1a1a]">
					You Might Also Like
				</h2>
				<p class="mb-12 font-sans text-sm font-light text-[#999]">
					Recipes with similar names
				</p>
				<div class="grid grid-cols-1 gap-12 md:grid-cols-2 lg:grid-cols-3">
					@foreach ($autoRelatedRecipes as $autoRecipe)
						@include('recipes.partials.recipe-card', ['recipe' => $autoRecipe])
					@endforeach
				</div>
			</div>
		@endif
	</div>
@endsection

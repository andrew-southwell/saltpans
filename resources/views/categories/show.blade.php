@extends('layouts.app')

@section('title', $category->name)

@section('content')
	<div class="mx-auto max-w-7xl px-4 py-20 sm:px-6 lg:px-8">
		<!-- Category Header -->
		<div class="mb-16 text-center">
			<a href="{{ route('recipes.index') }}"
				class="group mb-10 inline-flex items-center font-sans text-xs font-light uppercase tracking-wider text-[#999] transition-colors hover:text-[#1a1a1a]">
				<svg class="mr-2 h-3 w-3 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor"
					viewBox="0 0 24 24">
					<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 19l-7-7 7-7"></path>
				</svg>
				Back to All Recipes
			</a>
			<h1 class="mb-8 font-serif text-5xl font-normal leading-[1.1] text-[#1a1a1a] md:text-6xl lg:text-7xl">
				{{ $category->name }}
			</h1>
			@if ($category->description)
				<p class="font-elegant mx-auto max-w-2xl text-lg font-light leading-relaxed text-[#666] md:text-xl">
					{{ $category->description }}
				</p>
			@endif
		</div>

		<!-- Recipes Grid -->
		@if ($recipes->count() > 0)
			<div class="mb-16 grid grid-cols-1 gap-12 md:grid-cols-2 lg:grid-cols-3">
				@foreach ($recipes as $recipe)
					@include('recipes.partials.recipe-card', ['recipe' => $recipe])
				@endforeach
			</div>

			<!-- Pagination -->
			<div class="mt-16 flex justify-center">
				{{ $recipes->links() }}
			</div>
		@else
			<div class="py-20 text-center">
				<p class="font-sans text-lg font-light text-[#666]">No recipes found in this category. Check back soon!</p>
			</div>
		@endif
	</div>
@endsection

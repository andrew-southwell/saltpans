@extends('layouts.app')

@section('title', 'Home')

@section('content')
	<div class="mx-auto max-w-7xl px-4 py-20 sm:px-6 lg:px-8">
		<!-- Hero Section -->
		<div class="mb-20 text-center">
			<h1 class="mb-8 font-serif text-5xl font-normal leading-[1.1] text-[#1a1a1a] md:text-6xl lg:text-7xl">
				Welcome to Salt Pans
			</h1>
			<p class="font-elegant mx-auto max-w-2xl text-lg font-light leading-relaxed text-[#666] md:text-xl">
				Not your traditional recipie site, this is receipies we make and enjoy every day.
				This site is designed to allow us to plan our weekly meals and generate a shopping list for the week ahead.
				We hope you enjoy the recipes and find them useful.
			</p>
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
				<p class="font-sans text-lg font-light text-[#666]">No recipes found. Check back soon!</p>
			</div>
		@endif
	</div>
@endsection

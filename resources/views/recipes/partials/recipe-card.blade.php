<a href="{{ route('recipes.show', $recipe->slug) }}"
	class="group overflow-hidden rounded-lg border border-[#e5e5e5] bg-white transition-all duration-300 hover:border-[#1a1a1a]">
	@if ($recipe->image)
		<div class="aspect-square overflow-hidden rounded-lg bg-[#f5f5f5]">
			<img src="{{ str_starts_with($recipe->image, 'http') ? $recipe->image : '/' . $recipe->image }}"
				alt="{{ $recipe->title }}"
				class="aspect-square h-full w-full rounded-lg object-cover transition-transform duration-500 group-hover:scale-105">
		</div>
	@else
		<div class="flex aspect-square items-center justify-center bg-[#f5f5f5]">
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

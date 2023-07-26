<div class="bg-white shadow-sm rounded-md sm:p-6 p-3 flex flex-wrap gap-2 justify-center sm:justify-start">
    @if (!count($categories))
        <div class="w-full text-center text-zinc-400 font-semibold text-lg">No results.</div>
    @else
        @foreach ($categories as $category)
            <x-category-chip :category="$category" />
        @endforeach
    @endif
</div>

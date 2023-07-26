<div class="bg-white shadow-sm rounded-md sm:p-6 p-3 flex flex-wrap gap-4 justify-center sm:justify-start">
    @if (!count($tags))
        <div class="w-full text-center text-zinc-400 font-semibold text-lg">No results.</div>
    @else
        @foreach ($tags as $tag)
            <x-tag-chip :tag="$tag" />
        @endforeach
    @endif
</div>

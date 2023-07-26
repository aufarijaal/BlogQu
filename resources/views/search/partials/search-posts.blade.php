<div class="bg-white shadow-sm rounded-md sm:p-6 p-3 flex flex-wrap gap-2 justify-center">
    @if (!count($posts))
        <div class="w-full text-center text-zinc-400 font-semibold text-lg">No results.</div>
    @else
        @foreach ($posts as $post)
            <x-post-card :post="$post" />
        @endforeach
    @endif
</div>

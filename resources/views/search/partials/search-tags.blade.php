<div class="bg-white dark:bg-zinc-800 shadow-sm rounded-md sm:p-6 p-3 flex flex-wrap gap-4 justify-center sm:justify-start">
    @if (!count($tags))
        <div class="w-full text-center text-zinc-400 font-semibold text-lg">No results.</div>
    @else
        @foreach ($tags as $tag)
            <x-tag-chip :tag="$tag" />
        @endforeach
    @endif
</div>
<div class="w-full mt-4 flex justify-center gap-2">
    @if (count($tags))
        @if ($hasPrevPage)
            <a class="bg-white w-max px-3 py-1.5 rounded-md text-sm flex gap-1 items-center shadow-sm"
                href="{{ route('search.tags', ['q' => $query, 'page' => $prevPage]) }}">
                <svg class="rotate-180 w-5 h-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                    viewBox="0 0 24 24">
                    <path fill="currentColor" d="M12.6 12L8 7.4L9.4 6l6 6l-6 6L8 16.6l4.6-4.6Z" />
                </svg>
                Prev
            </a>
        @endif
        @if ($hasNextPage)
            <a class="bg-white w-max px-3 py-1.5 rounded-md text-sm flex gap-1 items-center shadow-sm"
                href="{{ route('search.tags', ['q' => $query, 'page' => $nextPage]) }}">
                Next
                <svg class="rotate-0 w-5 h-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                    viewBox="0 0 24 24">
                    <path fill="currentColor" d="M12.6 12L8 7.4L9.4 6l6 6l-6 6L8 16.6l4.6-4.6Z" />
                </svg>
            </a>
        @endif
    @endif
</div>

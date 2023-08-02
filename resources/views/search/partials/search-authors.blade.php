<div class="flex flex-col justify-center gap-2 p-3 bg-white dark:bg-zinc-800 rounded-md shadow-sm sm:p-6">
    @if (!count($authors))
        <div class="w-full text-lg font-semibold text-center text-zinc-400">No results.</div>
    @else
        @foreach ($authors as $author)
            <a class="author-card shadow-sm h-[120px] rounded-md bg-white dark:bg-zinc-800 dark:border-zinc-600 border flex p-4 gap-3 overflow-hidden"
                href="{{ route('authors.visit', [$author->author_username]) }}">
                <div class="flex items-center flex-shrink-0">
                    @if (!is_null($author->author_pp))
                        <img class="rounded-full w-14 h-14" src="{{ asset('/storage/' . $author->author_pp) }}"
                            alt="{{ $author->author_name . '\'s profile picture' }}">
                    @else
                        <div
                            class="flex items-center justify-center flex-shrink-0 rounded-full cursor-pointer w-14 h-14 bg-zinc-200">
                            <x-icons.user-outline class="w-7 h-7 text-zinc-400" />
                        </div>
                    @endif
                </div>
                <div class="flex flex-col self-center flex-grow gap-2">
                    <div class="flex flex-col">
                        <div class="text-lg font-bold font-barlow line-clamp-1 dark:text-white">{{ $author->author_name }}
                        </div>
                        <div class="text-xs text-zinc-400">{{ $author->author_username }}</div>
                    </div>
                    <div class="line-clamp-2 text-zinc-500 text-sm w-[95%]">{{ $author->author_bio }}</div>
                </div>
            </a>
        @endforeach
    @endif
</div>
<div class="w-full mt-4 flex justify-center gap-2">
    @if (count($authors))
        @if ($hasPrevPage)
            <a class="bg-white w-max px-3 py-1.5 rounded-md text-sm flex gap-1 items-center shadow-sm"
                href="{{ route('search.authors', ['q' => $query, 'page' => $prevPage]) }}">
                <svg class="rotate-180 w-5 h-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                    viewBox="0 0 24 24">
                    <path fill="currentColor" d="M12.6 12L8 7.4L9.4 6l6 6l-6 6L8 16.6l4.6-4.6Z" />
                </svg>
                Prev
            </a>
        @endif
        @if ($hasNextPage)
            <a class="bg-white w-max px-3 py-1.5 rounded-md text-sm flex gap-1 items-center shadow-sm"
                href="{{ route('search.authors', ['q' => $query, 'page' => $nextPage]) }}">
                Next
                <svg class="rotate-0 w-5 h-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                    viewBox="0 0 24 24">
                    <path fill="currentColor" d="M12.6 12L8 7.4L9.4 6l6 6l-6 6L8 16.6l4.6-4.6Z" />
                </svg>
            </a>
        @endif
    @endif
</div>

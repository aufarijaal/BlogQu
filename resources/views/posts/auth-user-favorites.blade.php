<x-root-layout>
    <x-slot name="head">
        <title>Saved Posts</title>
    </x-slot>

    <x-slot name="body">
        <div class="max-w-5xl min-h-screen mx-auto py-20 sm:px-0 px-2">
            <div>
                <h2 class="text-2xl sm:text-4xl font-bold text-zinc-400 text-center mb-6 mt-8">Saved Posts</h2>
            </div>
            <div class="bg-white dark:bg-zinc-800 p-6 rounded-md shadow-sm flex flex-wrap gap-2 justify-center">
                @if (count($posts) == 0)
                    <div class="text-zinc-400 text-lg">No posts</div>
                @else
                    @foreach ($posts as $post)
                        <x-post-card :post="$post" />
                    @endforeach
                @endif
            </div>

            {{-- Paginator --}}
            <div class="w-full mt-4 flex justify-center gap-2">
                @if (count($posts))
                    @if ($hasPrevPage)
                        <a class="bg-white w-max px-3 py-1.5 rounded-md text-sm flex gap-1 items-center shadow-sm"
                            href="{{ route('favorites.current_user', ['page' => $prevPage]) }}">
                            <svg class="rotate-180 w-5 h-5" xmlns="http://www.w3.org/2000/svg" width="24"
                                height="24" viewBox="0 0 24 24">
                                <path fill="currentColor" d="M12.6 12L8 7.4L9.4 6l6 6l-6 6L8 16.6l4.6-4.6Z" />
                            </svg>
                            Prev
                        </a>
                    @endif
                    @if ($hasNextPage)
                        <a class="bg-white w-max px-3 py-1.5 rounded-md text-sm flex gap-1 items-center shadow-sm"
                            href="{{ route('favorites.current_user', ['page' => $nextPage]) }}">
                            Next
                            <svg class="rotate-0 w-5 h-5" xmlns="http://www.w3.org/2000/svg" width="24"
                                height="24" viewBox="0 0 24 24">
                                <path fill="currentColor" d="M12.6 12L8 7.4L9.4 6l6 6l-6 6L8 16.6l4.6-4.6Z" />
                            </svg>
                        </a>
                    @endif
                @endif
            </div>
        </div>
    </x-slot>

    <x-slot name="script">

    </x-slot>
</x-root-layout>

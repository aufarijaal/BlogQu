<x-root-layout>
    <x-slot name="head">
        <title>{{ $tag->name }}</title>
    </x-slot>

    <x-slot name="body">
        <div class="max-w-7xl mx-auto py-20 flex flex-col gap-6 min-h-screen" id="post-by-tag-page-wrrooter">
            <div
                class="flex text-cyan-500 shadow-sm gap-2 items-center bg-cyan-100 w-max h-max py-2 px-4 justify-center self-center rounded-md sm:scale-100 scale-75">
                <x-icons.tag class="w-10 h-10" />
                <h2 class="text-3xl font-bold">
                    {{ $tag->name }}
                </h2>
            </div>
            <div class="bg-white dark:bg-zinc-800 sm:p-6 p-2 rounded-none sm:rounded-md shadow-sm flex gap-2 flex-wrap justify-center">
                @if (count($posts) == 0)
                    <div class="text-zinc-300 text-3xl font-bold">No Posts</div>
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
                            href="{{ route('post_by_tag', ['tagSlug' => $tag->slug, 'page' => $prevPage]) }}">
                            <svg class="rotate-180 w-5 h-5" xmlns="http://www.w3.org/2000/svg" width="24"
                                height="24" viewBox="0 0 24 24">
                                <path fill="currentColor" d="M12.6 12L8 7.4L9.4 6l6 6l-6 6L8 16.6l4.6-4.6Z" />
                            </svg>
                            Prev
                        </a>
                    @endif
                    @if ($hasNextPage)
                        <a class="bg-white w-max px-3 py-1.5 rounded-md text-sm flex gap-1 items-center shadow-sm"
                            href="{{ route('post_by_tag', ['tagSlug' => $tag->slug, 'page' => $nextPage]) }}">
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
    </x-app-layout>

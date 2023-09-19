<x-root-layout>
    <x-slot name="head">
        <title>{{ "@$author->author_username ($author->author_name)" }} &middot; BlogQu</title>
    </x-slot>

    <x-slot name="body">
        <div class="flex flex-col max-w-5xl min-h-screen gap-6 py-20 mx-auto">
            <div class="flex flex-col items-center gap-4 p-6 bg-white dark:bg-zinc-800 rounded-none shadow-sm sm:rounded-md">
                <div>
                    @if (!is_null($author->author_pp))
                        <img class="w-20 h-20 rounded-full" src="{{ asset(str_contains($author->author_pp, 'http') ? $author->author_pp : '/storage/' . $author->author_pp) }}"
                            alt="{{ $author->author_name . '\'s profile picture' }}">
                    @else
                        <div
                            class="flex items-center justify-center flex-shrink-0 w-16 h-16 rounded-full cursor-pointer bg-zinc-200">
                            <x-icons.user-outline class="w-7 h-7 text-zinc-400" />
                        </div>
                    @endif
                </div>
                <div class="flex flex-col items-center gap-1">
                    <div class="text-2xl font-bold font-barlow dark:text-white">{{ $author->author_name }}</div>
                    <div class="text-sm text-zinc-400">{{ $author->author_username }}</div>
                    <div class="text-sm text-zinc-400">Joined
                        {{ \Illuminate\Support\Carbon::createFromFormat('Y-m-d H:i:s', $author->joined_at)->diffForHumans() }}
                    </div>
                </div>
                <div>
                    <p class="text-sm text-justify dark:text-zinc-300">{{ $author->author_bio }}</p>
                </div>
            </div>

            <div class="flex flex-col overflow-hidden bg-white dark:bg-zinc-800 rounded-none shadow-sm sm:rounded-md"
                x-data="{ tab: 'posts' }">
                <div class="flex h-10">
                    <div :class="['flex justify-center items-center w-full font-semibold border-b cursor-pointer dark:border-zinc-600', tab === 'posts' ?
                        'text-cyan-500 bg-cyan-50 border-cyan-500 dark:bg-cyan-800 dark:border-cyan-700 dark:text-cyan-100' : 'text-zinc-500'
                    ]"
                        @click="tab = 'posts'">Posts</div>
                    <div :class="['flex justify-center items-center w-full font-semibold border-b cursor-pointer dark:border-zinc-600', tab === 'about' ?
                        'text-cyan-500 bg-cyan-50 border-cyan-500 dark:bg-cyan-800 dark:border-cyan-700 dark:text-cyan-100' : 'text-zinc-500'
                    ]"
                        @click="tab = 'about'">About</div>
                </div>

                <div class="flex flex-wrap justify-center gap-4 p-6" x-show="tab === 'posts'">
                    @foreach ($posts as $post)
                        <x-post-card :post="$post" />
                    @endforeach
                </div>

                <div class="p-6" x-show="tab === 'about'">
                    <p class="dark:text-white">{{ $author->author_about }}</p>
                </div>
            </div>

            {{-- Paginator --}}
            <div class="w-full mt-4 flex justify-center gap-2">
                @if (count($posts))
                    @if ($hasPrevPage)
                        <a class="bg-white w-max px-3 py-1.5 rounded-md text-sm flex gap-1 items-center shadow-sm"
                            href="{{ route('authors.visit', ['username' => $author->author_username, 'page' => $prevPage]) }}">
                            <svg class="rotate-180 w-5 h-5" xmlns="http://www.w3.org/2000/svg" width="24"
                                height="24" viewBox="0 0 24 24">
                                <path fill="currentColor" d="M12.6 12L8 7.4L9.4 6l6 6l-6 6L8 16.6l4.6-4.6Z" />
                            </svg>
                            Prev
                        </a>
                    @endif
                    @if ($hasNextPage)
                        <a class="bg-white w-max px-3 py-1.5 rounded-md text-sm flex gap-1 items-center shadow-sm"
                            href="{{ route('authors.visit', ['username' => $author->author_username, 'page' => $nextPage]) }}">
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

<x-root-layout>
    <x-slot name="head">
        <title>Search</title>
    </x-slot>

    <x-slot name="body">
        <div class="max-w-5xl min-h-screen py-20 mx-auto px-2 sm:px-0">
            <div class="text-2xl sm:text-4xl font-bold text-zinc-400 text-center mb-6 mt-8" id="search-query">Results for
                "{{ $query }}"
            </div>
            <div class="grid grid-cols-4 gap-2 mb-4" id="search-tabs">
                <x-search-tab href="{{ route('search.posts', ['q' => $query]) }}" :active="request()->routeIs('search.posts')">Posts</x-search-tab>
                <x-search-tab href="{{ route('search.categories', ['q' => $query]) }}" :active="request()->routeIs('search.categories')">Categories
                </x-search-tab>
                <x-search-tab href="{{ route('search.tags', ['q' => $query]) }}" :active="request()->routeIs('search.tags')">Tags</x-search-tab>
                <x-search-tab href="{{ route('search.authors', ['q' => $query]) }}" :active="request()->routeIs('search.authors')">Authors
                </x-search-tab>
            </div>

            @if ($tab == 'posts')
                <div class="bg-white shadow-sm rounded-md sm:p-6 p-3 flex flex-wrap gap-2 justify-center">
                    @foreach ($posts as $post)
                        <x-post-card :post="$post" />
                    @endforeach
                </div>
            @elseif ($tab == 'categories')
                <div class="bg-white shadow-sm rounded-md sm:p-6 p-3 flex flex-wrap gap-2 justify-center sm:justify-start">
                    @foreach ($categories as $category)
                        <x-category-chip :category="$category" />
                    @endforeach
                </div>
            @elseif ($tab == 'tags')
                <div class="bg-white shadow-sm rounded-md sm:p-6 p-3 flex flex-wrap gap-4 justify-center sm:justify-start">
                    @foreach ($tags as $tag)
                        <x-tag-chip :tag="$tag" />
                    @endforeach
                </div>
            @elseif ($tab == 'authors')
                <div class="bg-white shadow-sm rounded-md sm:p-6 p-3 flex flex-col gap-2 justify-center">
                    @foreach ($authors as $author)
                        <a class="author-card shadow-sm h-[120px] rounded-md bg-white border flex p-4 gap-3 overflow-hidden" href="{{ route('authors.visit', [$author->author_username]) }}">
                            <div class="flex-shrink-0 flex items-center">
                                <img class="w-14 h-14 rounded-full" src="{{ $author->author_pp }}" alt="{{ $author->author_name . '\'s profile picture' }}">
                            </div>
                            <div class="flex-grow flex flex-col gap-2 self-center">
                                <div class="flex flex-col">
                                    <div class="font-bold font-barlow text-lg line-clamp-1">{{ $author->author_name }}</div>
                                    <div class="text-zinc-400 text-xs">{{ $author->author_username }}</div>
                                </div>
                                <div class="line-clamp-2 text-zinc-500 text-sm w-[95%]">{{ $author->author_bio }}</div>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </x-slot>

    <x-slot name="script">
    </x-slot>
</x-root-layout>

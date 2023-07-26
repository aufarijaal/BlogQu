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
                <x-search-tab href="{{ route('search.posts', ['q' => $query]) }}" :active="request()->routeIs('search.posts')">
                    Posts
                </x-search-tab>
                <x-search-tab href="{{ route('search.categories', ['q' => $query]) }}" :active="request()->routeIs('search.categories')">
                    Categories
                </x-search-tab>
                <x-search-tab href="{{ route('search.tags', ['q' => $query]) }}" :active="request()->routeIs('search.tags')">
                    Tags
                </x-search-tab>
                <x-search-tab href="{{ route('search.authors', ['q' => $query]) }}" :active="request()->routeIs('search.authors')">
                    Authors
                </x-search-tab>
            </div>

            @if ($tab == 'posts')
                @include('search.partials.search-posts')
            @elseif ($tab == 'categories')
                @include('search.partials.search-categories')
            @elseif ($tab == 'tags')
                @include('search.partials.search-tags')
            @elseif ($tab == 'authors')
                @include('search.partials.search-authors')
            @endif
        </div>
    </x-slot>

    <x-slot name="script">
    </x-slot>
</x-root-layout>

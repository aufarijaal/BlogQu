<x-root-layout>
    <x-slot name="head">
        <title>My Posts</title>
    </x-slot>

    <x-slot name="body">
        <div class="max-w-4xl min-h-screen mx-auto py-20 sm:px-0 px-2">
            <div>
                <h2 class="text-2xl sm:text-4xl font-bold text-zinc-400 text-center mb-6 mt-8">My Posts</h2>
            </div>
            <div class="py-2 flex justify-end">
                <x-dropdown>
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                            <div>Sort by</div>

                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        <x-dropdown-link :href="route('posts.my', ['sort' => 'title'])">Title</x-dropdown-link>
                        <x-dropdown-link :href="route('posts.my', ['sort' => 'status'])">Status</x-dropdown-link>
                        <x-dropdown-link :href="route('posts.my', ['sort' => 'newest'])">Newest</x-dropdown-link>
                        <x-dropdown-link :href="route('posts.my', ['sort' => 'oldest'])">Oldest</x-dropdown-link>
                        <x-dropdown-link :href="route('posts.my', ['sort' => 'recent-update'])">Recently Updated</x-dropdown-link>
                    </x-slot>
                </x-dropdown>
            </div>
            <div class="bg-white p-6 rounded-md shadow-sm flex flex-col gap-2">
                @foreach ($posts as $post)
                    <x-post-bar :post="$post" />
                @endforeach
            </div>
        </div>
    </x-slot>

    <x-slot name="script">

    </x-slot>
</x-root-layout>

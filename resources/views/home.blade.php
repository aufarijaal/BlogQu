<x-root-layout>
    <x-slot name="head">
        <title>BlogQu</title>
    </x-slot>

    <x-slot name="body">
        <div class="flex flex-col gap-10 py-20 mx-auto max-w-7xl" id="home-page-wrapper">
            <div class="flex flex-col gap-4 px-2 py-6 bg-white dark:bg-zinc-800 rounded-none shadow-sm sm:px-6 sm:rounded-md"
                id="home-posts-wrapper">
                <div class="flex items-center justify-center dark:text-white gap-1 text-2xl font-bold sm:justify-start ">
                    Popular Posts
                </div>
                <div class="flex flex-wrap justify-center gap-2">
                    @foreach ($posts as $post)
                        <x-post-card :post="$post" />
                    @endforeach
                </div>
            </div>
            <div class="flex flex-col gap-4 px-2 py-6 bg-white dark:bg-zinc-800 rounded-none shadow-sm sm:px-6 sm:rounded-md"
                id="home-categories-wrapper">
                <div class="flex items-center justify-center dark:text-white gap-1 text-2xl font-bold sm:justify-start ">
                    Popular Categories
                </div>
                <div class="flex flex-wrap justify-center gap-2 sm:justify-start">
                    @foreach ($categories as $category)
                        <x-category-chip :category="$category" />
                    @endforeach
                </div>
            </div>
            <div class="flex flex-col gap-4 px-2 py-6 bg-white dark:bg-zinc-800 rounded-none shadow-sm sm:px-6 sm:rounded-md"
                id="home-tags-wrapper">
                <div class="flex items-center justify-center dark:text-white gap-1 text-2xl font-bold sm:justify-start ">
                    Popular Tags
                </div>
                <div class="flex flex-wrap justify-center gap-2 sm:justify-start">
                    @foreach ($tags as $tag)
                        <x-tag-chip :tag="$tag" />
                    @endforeach
                </div>
            </div>
        </div>
    </x-slot>

    <x-slot name="script">
    </x-slot>
</x-root-layout>

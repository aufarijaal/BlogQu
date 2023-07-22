<x-root-layout>
    <x-slot name="head">
        <title>BlogQu</title>
    </x-slot>

    <x-slot name="body">
        <div class="max-w-7xl mx-auto py-20 flex flex-col gap-10" id="home-page-wrapper">
            <div class="bg-white sm:px-6 px-2 py-6 rounded-none sm:rounded-md shadow-sm flex flex-col gap-4"
                id="home-posts-wrapper">
                <div class="font-bold text-2xl sm:justify-start justify-center flex items-center gap-1 ">
                    <x-icons.fire class="w-7 h-7"/>
                    Posts
                </div>
                <div class="flex gap-2 flex-wrap justify-center">
                    @foreach ($posts as $post)
                        <x-post-card :post="$post" />
                    @endforeach
                </div>
            </div>
            <div class="bg-white sm:px-6 px-2 py-6 rounded-none sm:rounded-md shadow-sm flex flex-col gap-4"
                id="home-categories-wrapper">
                <div class="font-bold text-2xl sm:justify-start justify-center flex items-center gap-1 ">
                    <x-icons.fire class="w-7 h-7"/>
                    Categories
                </div>
                <div class="flex flex-wrap justify-center sm:justify-start gap-2">
                    @foreach ($categories as $category)
                        <x-category-chip :category="$category" />
                    @endforeach
                </div>
            </div>
            <div class="bg-white sm:px-6 px-2 py-6 rounded-none sm:rounded-md shadow-sm flex flex-col gap-4"
                id="home-tags-wrapper">
                <div class="font-bold text-2xl sm:justify-start justify-center flex items-center gap-1 ">
                    <x-icons.fire class="w-7 h-7"/>
                    Tags
                </div>
                <div class="flex flex-wrap justify-center sm:justify-start gap-2">
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

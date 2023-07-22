<x-root-layout>
    <x-slot name="head">
        <title>{{ $tagName }}</title>
    </x-slot>

    <x-slot name="body">
        <div class="max-w-7xl mx-auto py-20 flex flex-col gap-6 min-h-screen" id="post-by-tag-page-wrrooter">
            <div class="flex text-cyan-500 shadow-sm gap-2 items-center bg-cyan-100 w-max h-max py-2 px-4 justify-center self-center rounded-md sm:scale-100 scale-75">
                <x-icons.tag class="w-10 h-10" />
                <h2 class="text-3xl font-bold">
                    {{ $tagName }}
                </h2>
            </div>
            <div class="bg-white sm:p-6 p-2 rounded-none sm:rounded-md shadow-sm flex gap-2 flex-wrap justify-center">
                @if (count($posts) == 0)
                    <div class="text-zinc-300 text-3xl font-bold">No Posts</div>
                @else
                    @foreach ($posts as $post)
                        <x-post-card :post="$post" />
                    @endforeach
                @endif
            </div>
        </div>
    </x-slot>

    <x-slot name="script">

    </x-slot>
    </x-app-layout>

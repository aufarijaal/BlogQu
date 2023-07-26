<x-root-layout>
    <x-slot name="head">
        <title>Saved Posts</title>
    </x-slot>

    <x-slot name="body">
        <div class="max-w-5xl min-h-screen mx-auto py-20 sm:px-0 px-2">
            <div>
                <h2 class="text-2xl sm:text-4xl font-bold text-zinc-400 text-center mb-6 mt-8">Saved Posts</h2>
            </div>
            <div class="bg-white p-6 rounded-md shadow-sm flex flex-wrap gap-2 justify-center">
                @if (count($posts) == 0)
                    <div class="text-zinc-400 text-lg">No posts</div>
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
</x-root-layout>

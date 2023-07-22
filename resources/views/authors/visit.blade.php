<x-root-layout>
    <x-slot name="head">
        <title>{{ "$author->author_name (@$author->author_username)" }} &middot; BlogQu</title>
    </x-slot>

    <x-slot name="body">
        <div class="max-w-5xl min-h-screen mx-auto py-20 flex flex-col gap-6">
            <div class="bg-white shadow-sm rounded-none sm:rounded-md p-6 flex flex-col items-center gap-4">
                <div>
                    <img class="w-20 h-20 rounded-full" src="{{ $author->author_pp }}"
                        alt="{{ $author->author_name . '\'s profile picture' }}">
                </div>
                <div class="flex flex-col items-center gap-1">
                    <div class="font-bold font-barlow text-2xl">{{ $author->author_name }}</div>
                    <div class="text-zinc-400 text-sm">{{ $author->author_username }}</div>
                    <div class="text-zinc-400 text-sm">Joined {{ \Illuminate\Support\Carbon::createFromFormat('Y-m-d H:i:s', $author->joined_at)->diffForHumans() }}</div>
                </div>
                <div>
                    <p class="text-sm text-justify">{{ $author->author_bio }}</p>
                </div>
            </div>

            <div class="bg-white shadow-sm rounded-none sm:rounded-md flex flex-col overflow-hidden"
                x-data="{ tab: 'posts' }">
                <div class="h-10 flex">
                    <div :class="['flex justify-center items-center w-full font-semibold border-b cursor-pointer', tab === 'posts' ?
                        'text-cyan-500 bg-cyan-50 border-cyan-500' : 'text-zinc-500'
                    ]"
                        @click="tab = 'posts'">Posts</div>
                    <div :class="['flex justify-center items-center w-full font-semibold border-b cursor-pointer', tab === 'about' ?
                        'text-cyan-500 bg-cyan-50 border-cyan-500' : 'text-zinc-500'
                    ]"
                        @click="tab = 'about'">About</div>
                </div>

                <div class="p-6 flex flex-wrap gap-4 justify-center" x-show="tab === 'posts'">
                    @foreach ($posts as $post)
                        <x-post-card :post="$post" />
                    @endforeach
                </div>

                <div class="p-6" x-show="tab === 'about'">
                    <p>{{ $author->author_about }}</p>
                </div>
            </div>
        </div>
    </x-slot>

    <x-slot name="script">

    </x-slot>
</x-root-layout>

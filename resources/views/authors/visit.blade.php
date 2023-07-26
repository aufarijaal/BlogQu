<x-root-layout>
    <x-slot name="head">
        <title>{{ "@$author->author_username ($author->author_name)" }} &middot; BlogQu</title>
    </x-slot>

    <x-slot name="body">
        <div class="flex flex-col max-w-5xl min-h-screen gap-6 py-20 mx-auto">
            <div class="flex flex-col items-center gap-4 p-6 bg-white rounded-none shadow-sm sm:rounded-md">
                <div>
                    @if (!is_null($author->author_pp))
                        <img class="w-20 h-20 rounded-full" src="{{ asset('/storage/' . $author->author_pp) }}"
                            alt="{{ $author->author_name . '\'s profile picture' }}">
                    @else
                        <div
                            class="flex items-center justify-center flex-shrink-0 w-16 h-16 rounded-full cursor-pointer bg-zinc-200">
                            <x-icons.user-outline class="w-7 h-7 text-zinc-400" />
                        </div>
                    @endif
                </div>
                <div class="flex flex-col items-center gap-1">
                    <div class="text-2xl font-bold font-barlow">{{ $author->author_name }}</div>
                    <div class="text-sm text-zinc-400">{{ $author->author_username }}</div>
                    <div class="text-sm text-zinc-400">Joined
                        {{ \Illuminate\Support\Carbon::createFromFormat('Y-m-d H:i:s', $author->joined_at)->diffForHumans() }}
                    </div>
                </div>
                <div>
                    <p class="text-sm text-justify">{{ $author->author_bio }}</p>
                </div>
            </div>

            <div class="flex flex-col overflow-hidden bg-white rounded-none shadow-sm sm:rounded-md"
                x-data="{ tab: 'posts' }">
                <div class="flex h-10">
                    <div :class="['flex justify-center items-center w-full font-semibold border-b cursor-pointer', tab === 'posts' ?
                        'text-cyan-500 bg-cyan-50 border-cyan-500' : 'text-zinc-500'
                    ]"
                        @click="tab = 'posts'">Posts</div>
                    <div :class="['flex justify-center items-center w-full font-semibold border-b cursor-pointer', tab === 'about' ?
                        'text-cyan-500 bg-cyan-50 border-cyan-500' : 'text-zinc-500'
                    ]"
                        @click="tab = 'about'">About</div>
                </div>

                <div class="flex flex-wrap justify-center gap-4 p-6" x-show="tab === 'posts'">
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

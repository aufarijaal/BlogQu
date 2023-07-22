<x-root-layout>
    <x-slot name="head">
        <title>{{ $post->post_title }}</title>
    </x-slot>

    <x-slot name="body">
        <div class="max-w-3xl min-h-screen mx-auto sm:pt-20 py-20 flex flex-col gap-6" x-data="{ showComments: true }">
            <div class="bg-white p-10 pt-28 sm:pt-10 shadow-sm sm:rounded-md flex flex-col gap-4 items-start">
                <a class="category-chip" title="{{ $post->category_name }}"
                    href="{{ route('post_by_category', ['categorySlug' => $post->category_slug]) }}">{{ $post->category_name }}</a>
                <h1 class="text-4xl md:text-5xl font-bold font-barlow">{{ $post->post_title }}</h1>
                <div class="flex items-center gap-2">
                    <img class="w-10 h-10 rounded-full" src="{{ $post->author_pp }}"
                        alt="{{ $post->author_name . '\'s profile picture' }}">
                    <a href="{{ route('authors.visit', [$post->author_username, 'page' => 1]) }}"
                        class="font-semibold">{{ $post->author_name }}</a>
                </div>
                <div>
                    <div class="text-zinc-400">
                        {{ \Illuminate\Support\Carbon::createFromFormat('Y-m-d H:i:s', $post->updated_at)->diffForHumans() }}
                    </div>
                </div>

                @if ($post->post_thumbnail)
                    <div class="self-center">
                        <img src="{{ $post->post_thumbnail }}" alt="{{ $post->post_title . '\'s thumbnail' }}">
                    </div>
                @endif

                {{-- Body --}}
                <div class="h-px w-full bg-zinc-300"></div>
                <div>
                    <p>{{ $post->post_body }}</p>
                </div>

                <div class="h-px w-full bg-zinc-300"></div>

                {{-- Footer --}}
                <div>
                    {{-- Tags --}}
                    <div>
                        @if (!is_null($tags))
                            @foreach ($tags as $tag)
                                <a class="tag-chip" title="{{ $tag['name'] }}"
                                    href="{{ route('post_by_tags.index', ['tagSlug' => $tag['slug']]) }}">{{ $tag['name'] }}</a>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>

            {{-- Like, Fav, Toggle Comment section --}}
            <div
                class="bg-white shadow-sm sm:rounded-md flex p-4 pt-5 min-w-[200px] gap-4 items-center justify-around w-max h-max mx-auto">
                <form class="flex flex-col items-center gap-2"
                    action="{{ !is_null($like) ? route('likes.destroy') : route('likes.store') }}" method="post"
                    title="{{ !is_null($like) ? 'Unlike' : 'Like' }}">
                    @csrf
                    @if (!is_null($like))
                        @method('delete')
                    @endif

                    <input type="hidden" name="post-id" value="{{ $post->post_id }}">
                    <button type="submit">
                        @if (!is_null($like))
                            <x-icons.heart-fill class="w-8 h-8 text-rose-400 hover:text-rose-500 transition" />
                        @else
                            <x-icons.heart-outline class="w-8 h-8 text-zinc-400 hover:text-rose-500 transition" />
                        @endif
                    </button>
                    <div class="text-sm text-zinc-400">{{ $likeCount }}</div>
                </form>

                <form class="flex flex-col items-center gap-2"
                    action="{{ !is_null($favorite) ? route('favorites.destroy') : route('favorites.store') }}"
                    method="post" title="{{ !is_null($favorite) ? 'Unsave' : 'Save' }}">
                    @csrf
                    @if (!is_null($favorite))
                        @method('delete')
                    @endif

                    <input type="hidden" name="post-id" value="{{ $post->post_id }}">
                    <button type="submit">
                        @if (!is_null($favorite))
                            <x-icons.bookmark-fill class="w-8 h-8 text-green-400 hover:text-green-500 transition" />
                        @else
                            <x-icons.bookmark-outline class="w-8 h-8 text-zinc-400 hover:text-green-500 transition" />
                        @endif
                    </button>
                    <div class="text-sm text-zinc-400">{{ $favoriteCount }}</div>
                </form>

                <div class="flex flex-col items-center gap-2" title="Toggle open comments section">
                    <button @click="showComments = !showComments">
                        <x-icons.comment class="w-8 h-8 text-zinc-400 hover:text-cyan-500 transition" />
                    </button>
                    <div class="text-sm text-zinc-400">{{ $commentsCount }}</div>
                </div>
            </div>

            {{-- Comments section --}}
            @include("components.post-comment-display")

            {{-- 'Written by' card --}}
            @include("components.written-by-card")


            {{-- More by --}}
            @include("components.more-by-card")
        </div>
    </x-slot>

    <x-slot name="script">

    </x-slot>
</x-root-layout>

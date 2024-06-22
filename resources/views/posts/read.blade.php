<x-root-layout>
    <x-slot name="head">
        <title>{{ $post->post_title }}</title>
        <link rel="stylesheet"
            href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/11.7.0/styles/stackoverflow-dark.min.css">
        <style>
            .hljs-container {
                position: relative;
                overflow: hidden
            }

            .hljs-container:hover .copy-btn {
                transform: translateX(0);
            }

            .copy-btn {
                transition: transform 50ms ease-out;
                position: absolute;
                transform: translateX(calc(100% + 1.125em));
                top: 1em;
                right: 1em;
                background: none;
                border: 1px solid #ffffff22;
                cursor: pointer;
                width: 28px;
                height: 28px;
                border-radius: 5px;
                z-index: 1;
                background-color: var(--hljs-theme-background);
                background-repeat: no-repeat;
                background-size: 20px;
                background-position: center center;
            }

            .copy-btn[data-copied=true] {
                background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='1em' height='1em' viewBox='0 0 24 24'%3E%3Cg fill='none' stroke='%23ffffff' stroke-linecap='round' stroke-linejoin='round'%3E%3Cg stroke-width='2'%3E%3Cpath stroke-dasharray='66' stroke-dashoffset='66' d='M12 3H19V21H5V3H12Z'%3E%3Canimate fill='freeze' attributeName='stroke-dashoffset' dur='0.15s' values='66;0'/%3E%3C/path%3E%3Cpath stroke-dasharray='10' stroke-dashoffset='10' d='M9 13L11 15L15 11'%3E%3Canimate fill='freeze' attributeName='stroke-dashoffset' begin='0.25s' dur='0.05s' values='10;0'/%3E%3C/path%3E%3C/g%3E%3Cpath stroke-dasharray='12' stroke-dashoffset='12' d='M14.5 3.5V6.5H9.5V3.5'%3E%3Canimate fill='freeze' attributeName='stroke-dashoffset' begin='0.175s' dur='0.05s' values='12;0'/%3E%3C/path%3E%3C/g%3E%3C/svg%3E");
            }

            .copy-btn[data-copied=false] {
                background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='1em' height='1em' viewBox='0 0 24 24'%3E%3Cg fill='none' stroke='%23ffffff' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath stroke-dasharray='66' stroke-dashoffset='66' stroke-width='2' d='M12 3H19V21H5V3H12Z'%3E%3Canimate fill='freeze' attributeName='stroke-dashoffset' dur='0.15s' values='66;0'/%3E%3C/path%3E%3Cpath stroke-dasharray='12' stroke-dashoffset='12' d='M14.5 3.5V6.5H9.5V3.5'%3E%3Canimate fill='freeze' attributeName='stroke-dashoffset' begin='0.175s' dur='0.05s' values='12;0'/%3E%3C/path%3E%3C/g%3E%3C/svg%3E");
            }
        </style>
    </x-slot>

    <x-slot name="body">
        <div class="flex flex-col max-w-5xl min-h-screen gap-6 py-20 mx-auto sm:pt-20" x-data="{ showComments: true }">
            <div
                class="flex flex-col items-start gap-4 p-10 bg-white dark:bg-zinc-800 shadow-sm pt-28 sm:pt-10 sm:rounded-md">
                {{-- Link to edit the post if current user is authenticated --}}
                @if (Auth::user() && Auth::user()->id == $post->author_id)
                    <form action="{{ route('posts.edit', ['postId' => $post->post_id]) }}" method="get">
                        <button type="submit"
                            class="flex items-center justify-center px-3 py-1.5 gap-2 font-semibold text-sm text-teal-500 border border-teal-500 rounded-full bg-teal-50"
                            title="Edit post">
                            <x-icons.pencil class="w-5 h-5" />
                            Edit this post
                        </button>
                    </form>
                @endif

                <a class="category-chip" title="{{ $post->category_name }}"
                    href="{{ route('post_by_category', ['categorySlug' => $post->category_slug]) }}">{{ $post->category_name }}</a>
                <h1 class="text-4xl font-bold font-barlow dark:text-white">{{ $post->post_title }}</h1>
                <div class="flex items-center gap-2">
                    @if (!is_null($post->author_pp))
                        <img class="w-10 h-10 rounded-full"
                            src="{{ asset(str_contains($post->author_pp, 'http') ? $post->author_pp : '/storage/' . $post->author_pp) }}"
                            alt="{{ $post->author_name . '\'s profile picture' }}">
                    @else
                        <div
                            class="flex items-center justify-center flex-shrink-0 w-10 h-10 rounded-full cursor-pointer bg-zinc-200">
                            <x-icons.user-outline class="w-4 h-4 text-zinc-400" />
                        </div>
                    @endif
                    <a href="{{ route('authors.visit', [$post->author_username, 'page' => 1]) }}"
                        class="font-semibold dark:text-white">{{ $post->author_name }}</a>
                </div>
                <div>
                    <div class="text-zinc-400">
                        {{ \Illuminate\Support\Carbon::createFromFormat('Y-m-d H:i:s', $post->updated_at)->diffForHumans() }}
                    </div>
                </div>

                @if ($post->post_thumbnail)
                    <div class="self-center">
                        <img class="max-h-[400px]"
                            src="{{ asset(str_contains($post->post_thumbnail, 'http') ? $post->post_thumbnail : '/storage/' . $post->post_thumbnail) }}"
                            alt="{{ $post->post_title . '\'s thumbnail' }}">
                    </div>
                @endif

                {{-- Body --}}
                <div class="w-full h-px bg-zinc-300 dark:bg-zinc-600"></div>
                <div
                    class="w-full post-body-wrapper dark:text-white prose max-w-none prose-a:text-teal-500 prose-h1:text-xl prose-sm prose-strong:text-black dark:prose-strong:text-white prose-code:text-xs prose-pre:m-0">
                    {!! $post->post_body !!}
                </div>

                <div class="w-full h-px bg-zinc-300 dark:bg-zinc-600"></div>

                {{-- Footer --}}
                <div>
                    {{-- Tags --}}
                    <div>
                        @if (!is_null($tags))
                            @foreach ($tags as $tag)
                                <a class="tag-chip" title="{{ $tag['name'] }}"
                                    href="{{ route('post_by_tag', ['tagSlug' => $tag['slug']]) }}">{{ $tag['name'] }}</a>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>

            {{-- Like, Fav, Toggle Comment section --}}
            <div
                class="bg-white dark:bg-zinc-800 shadow-sm sm:rounded-md flex p-4 pt-5 min-w-[200px] gap-4 items-center justify-around w-max h-max mx-auto">
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
                            <x-icons.heart-fill class="w-8 h-8 transition text-rose-400 hover:text-rose-500" />
                        @else
                            <x-icons.heart-outline class="w-8 h-8 transition text-zinc-400 hover:text-rose-500" />
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
                            <x-icons.bookmark-fill class="w-8 h-8 text-teal-400 transition hover:text-teal-500" />
                        @else
                            <x-icons.bookmark-outline class="w-8 h-8 transition text-zinc-400 hover:text-teal-500" />
                        @endif
                    </button>
                    <div class="text-sm text-zinc-400">{{ $favoriteCount }}</div>
                </form>

                <div class="flex flex-col items-center gap-2" title="Toggle open comments section">
                    <button @click="showComments = !showComments">
                        <x-icons.comment class="w-8 h-8 transition text-zinc-400 hover:text-teal-500" />
                    </button>
                    <div class="text-sm text-zinc-400">{{ $commentsCount }}</div>
                </div>
            </div>

            {{-- Comments section --}}
            @include('components.post-comment-display')

            {{-- 'Written by' card --}}
            @include('components.written-by-card')


            {{-- More by --}}
            @include('components.more-by-card')
        </div>
    </x-slot>

    <x-slot name="script">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.7.0/highlight.min.js"></script>
    </x-slot>
</x-root-layout>

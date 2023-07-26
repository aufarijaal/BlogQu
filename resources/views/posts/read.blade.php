<x-root-layout>
    <x-slot name="head">
        <title>{{ $post->post_title }}</title>
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/11.7.0/styles/stackoverflow-dark.min.css">
    </x-slot>

    <x-slot name="body">
        <div class="flex flex-col max-w-5xl min-h-screen gap-6 py-20 mx-auto sm:pt-20" x-data="{ showComments: false }">
            <div class="flex flex-col items-start gap-4 p-10 bg-white shadow-sm pt-28 sm:pt-10 sm:rounded-md">
                {{-- Link to edit the post if current user is authenticated --}}
                @if (Auth::user() && Auth::user()->id == $post->author_id)
                    <form action="{{ route('posts.edit', ['postId' => $post->post_id]) }}" method="get">
                        <button type="submit" class="flex items-center justify-center px-3 py-1.5 gap-2 font-semibold text-sm text-green-500 border border-green-500 rounded-full bg-green-50" title="Edit post">
                            <x-icons.pencil class="w-5 h-5"/>
                            Edit this post
                        </button>
                    </form>
                @endif

                <a class="category-chip" title="{{ $post->category_name }}"
                    href="{{ route('post_by_category', ['categorySlug' => $post->category_slug]) }}">{{ $post->category_name }}</a>
                <h1 class="text-4xl font-bold md:text-5xl font-barlow">{{ $post->post_title }}</h1>
                <div class="flex items-center gap-2">
                    @if (!is_null($post->author_pp))
                    <img class="w-10 h-10 rounded-full" src="{{ asset('/storage/' . $post->author_pp) }}"
                        alt="{{ $post->author_name . '\'s profile picture' }}">
                    @else
                        <div class="flex items-center justify-center flex-shrink-0 w-10 h-10 rounded-full cursor-pointer bg-zinc-200">
                            <x-icons.user-outline class="w-4 h-4 text-zinc-400" />
                        </div>
                    @endif
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
                        <img src="{{ asset('/storage/' . $post->post_thumbnail) }}"
                            alt="{{ $post->post_title . '\'s thumbnail' }}">
                    </div>
                @endif

                {{-- Body --}}
                <div class="w-full h-px bg-zinc-300"></div>
                <div class="w-full post-body-wrapper">
                    {!! $post->post_body !!}
                </div>

                <div class="w-full h-px bg-zinc-300"></div>

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
                            <x-icons.bookmark-fill class="w-8 h-8 text-green-400 transition hover:text-green-500" />
                        @else
                            <x-icons.bookmark-outline class="w-8 h-8 transition text-zinc-400 hover:text-green-500" />
                        @endif
                    </button>
                    <div class="text-sm text-zinc-400">{{ $favoriteCount }}</div>
                </form>

                <div class="flex flex-col items-center gap-2" title="Toggle open comments section">
                    <button @click="showComments = !showComments">
                        <x-icons.comment class="w-8 h-8 transition text-zinc-400 hover:text-cyan-500" />
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
        <script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/11.7.0/highlight.min.js"></script>
        <script>
            // const wrapAll = (target, wrapper = document.createElement('div')) => {
            //     [...target.childNodes].forEach(child => wrapper.appendChild(child))
            //     target.appendChild(wrapper)
            //     return wrapper
            // }
            // window.wrapAll = wrapAll;

            // Tweaking the rendered trix post body
            // Style tweaked at the css
            document.addEventListener("DOMContentLoaded", () => {
                document.querySelectorAll('.post-body-wrapper > pre').forEach((code) => {
                    hljs.highlightElement(code);
                });

                document.querySelectorAll('.post-body-wrapper a').forEach((anchor) => {
                    anchor.setAttribute("target", "_blank");
                });
            })
        </script>
    </x-slot>
</x-root-layout>

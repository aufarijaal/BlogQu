@props(['post'])

<div class="post-card w-[300px] h-max rounded-xl shadow-[rgba(13,_38,_76,_0.19)_0px_9px_20px] shadow-zinc-100 dark:shadow-zinc-900 border p-4 flex flex-col overflow-hidden gap-6 bg-white dark:bg-zinc-800 dark:border-zinc-700"
    x-data="{ showAltDate: false }" @mouseover="showAltDate = true" @mouseleave="showAltDate = false">

    {{-- Post card header --}}
    <div class="relative post-card-header">
        <div class="flex items-center gap-2 mb-6">
            @if (!is_null($post->author_pp))
                <img class="flex-shrink-0 w-10 h-10 rounded-full"
                    src="{{ asset(str_contains($post->author_pp, 'http') ? $post->author_pp : '/storage/' . $post->author_pp) }}"
                    alt="Profile picture">
            @else
                <div
                    class="flex items-center justify-center flex-shrink-0 w-10 h-10 rounded-full cursor-pointer bg-zinc-200">
                    <x-icons.user-outline class="w-4 h-4 text-zinc-400" />
                </div>
            @endif
            <div class="flex flex-col justify-between w-full">
                <a href="{{ route('authors.visit', [$post->author_username, 'page' => 1]) }}"
                    class="overflow-hidden text-sm font-semibold w-52 whitespace-nowrap overflow-ellipsis dark:text-white"
                    title="{{ $post->author_name }}">
                    {{ $post->author_name }}</a>
                <div class="h-4 overflow-hidden text-xs text-gray-400 select-none">
                    <div :class="['transition', showAltDate ? '-translate-y-4' : '']">
                        {{ \Illuminate\Support\Carbon::createFromFormat('Y-m-d H:i:s', $post->updated_at)->diffForHumans() }}
                    </div>
                    <div :class="['transition', showAltDate ? '-translate-y-4' : '']">
                        {{ \Illuminate\Support\Carbon::createFromFormat('Y-m-d H:i:s', $post->updated_at)->toFormattedDateString() }}
                    </div>
                </div>
            </div>
        </div>

        <a
            href="{{ $post->post_slug != null ? route('posts.read', ['authorUsername' => $post->author_username, 'postSlug' => $post->post_slug]) : '#' }}">
            @if ($post->post_thumbnail)
                <img class="object-cover w-full post-card-thumbnail rounded-xl h-44"
                    src="{{ asset(str_contains($post->post_thumbnail, 'http') ? $post->post_thumbnail : '/storage/' . $post->post_thumbnail) }}"
                    alt="{{ $post->title ?? 'Post' . '\'s Thumbnail' }}">
            @else
                <div
                    class="flex items-center justify-center w-full post-card-no-thumbnail h-44 rounded-xl bg-teal-50 dark:bg-teal-800">
                    <x-application-logo class="opacity-50 text-teal-500 dark:text-teal-300" />
                </div>
            @endif
        </a>
    </div>

    {{-- Post card content --}}
    <div class="flex flex-col gap-1 post-card-content">
        @if (!request()->routeIs('post_by_category'))
            <a class="px-2 py-1 overflow-hidden rounded-full text-teal-600 max-w-[200px] w-max block whitespace-nowrap overflow-ellipsis text-xs bg-teal-50 border border-teal-600 font-medium hover:bg-teal-100 dark:bg-teal-800 dark:text-teal-50 hover:dark:bg-teal-900"
                href="{{ $post->category_id != null ? route('post_by_category', ['categorySlug' => $post->category_slug]) : '#' }}">{{ $post->category_name ?? 'Uncategorized' }}</a>
        @endif
        <a href="{{ $post->post_slug != null ? route('posts.read', ['authorUsername' => $post->author_username, 'postSlug' => $post->post_slug]) : '#' }}"
            class="min-h-[4.5rem] font-semibold post-card-title line-clamp-2 dark:text-white"
            title="{{ $post->post_title ?? 'Untitled' }}">{{ $post->post_title ?? 'Untitled' }}</a>
    </div>

    {{-- Post card footer --}}
    <div class="flex items-center gap-4 post-card-footer">
        <div class="flex items-center gap-1 text-sm">
            <x-icons.heart-outline class="w-5 h-5 text-zinc-400" />
            <div class="dark:text-zinc-400">{{ $post->likes_count }}</div>
        </div>
        <div class="flex items-center gap-1 text-sm">
            <x-icons.comment class="w-5 h-5 text-zinc-400" />
            <div class="dark:text-zinc-400">{{ $post->comments_count }}</div>
        </div>
    </div>
</div>

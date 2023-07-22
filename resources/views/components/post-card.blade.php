@props(['post'])

<div class="post-card w-[300px] h-max rounded-xl shadow-[rgba(13,_38,_76,_0.19)_0px_9px_20px] shadow-zinc-100 border p-4 flex flex-col overflow-hidden gap-6 bg-white"
    x-data="{ showAltDate: false }" @mouseover="showAltDate = true" @mouseleave="showAltDate = false">
    <div class="relative post-card-header">
        @if (!request()->routeIs('post_by_category'))
            <a class="absolute px-2 py-1 overflow-hidden text-sm font-semibold bg-white rounded-md top-2 left-2 max-w-[13rem] whitespace-nowrap overflow-ellipsis"
                href="{{ $post->category_id != null ? route('post_by_category', ['categorySlug' => $post->category_slug]) : '#' }}">{{ $post->category_name ?? 'Uncategorized' }}</a>
        @endif
        <img class="object-cover w-full rounded-xl h-44"
            src="{{ $post->post_thumbnail ? $post->post_thumbnail : 'https://placehold.co/100x100?text=No+Thumbnail' }}"
            alt="{{ $post->title ?? 'Post' . '\'s Thumbnail' }}" class="post-card-thumbnail">
    </div>
    <div class="post-card-content">
        <a href="{{ $post->post_slug != null ? route('posts.read', ['authorUsername' => $post->author_username, 'postSlug' => $post->post_slug]) : '#' }}"
            class="min-h-[4.5rem] font-semibold post-card-title line-clamp-3"
            title="{{ $post->post_title ?? 'Untitled' }}">{{ $post->post_title ?? 'Untitled' }}</a>
    </div>
    <div class="flex items-center gap-4 post-card-footer">
        <img class="object-cover w-10 h-10 rounded-full"
            src="{{ $post->author_pp ?? 'https://placehold.co/100x100?text=No+Image' }}"
            alt="{{ $post->author_name . '\'s photo profile' }}">
        <div class="flex flex-col justify-between w-full">
            <a href="{{ route('authors.visit', [$post->author_username, 'page' => 1]) }}"
                class="overflow-hidden text-sm font-semibold w-52 whitespace-nowrap overflow-ellipsis"
                title="{{ $post->author_name }}">
                {{ $post->author_name }}</a>
            <div class="text-xs text-gray-400 h-4 overflow-hidden select-none">
                <div :class="['transition', showAltDate ? '-translate-y-4' : '']">
                    {{ \Illuminate\Support\Carbon::createFromFormat('Y-m-d H:i:s', $post->updated_at)->diffForHumans() }}
                </div>
                <div :class="['transition', showAltDate ? '-translate-y-4' : '']">
                    {{ \Illuminate\Support\Carbon::createFromFormat('Y-m-d H:i:s', $post->updated_at)->toFormattedDateString() }}
                </div>
            </div>
        </div>
    </div>
</div>

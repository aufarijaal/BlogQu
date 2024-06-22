@props(['post'])

<div
    class="post-bar h-28 border rounded-md p-4 bg-inherit flex dark:bg-zinc-800 dark:shadow-zinc-900 dark:border-zinc-600">
    <div class="flex flex-col justify-center gap-1 flex-grow">
        @if ($post->post_status === 'published')
            <div
                class="text-xs border rounded-full w-max h-max px-2 py-1 bg-teal-50 text-teal-500 border-teal-500 font-semibold">
                {{ \Illuminate\Support\Str::title($post->post_status) }}
            </div>
        @elseif ($post->post_status === 'draft')
            <div
                class="text-xs border rounded-full w-max h-max px-2 py-1 bg-blue-50 text-blue-500 border-blue-500 font-semibold">
                {{ \Illuminate\Support\Str::title($post->post_status) }}
            </div>
        @else
            <div
                class="text-xs border rounded-full w-max h-max px-2 py-1 bg-yellow-50 text-yellow-500 border-yellow-500 font-semibold">
                {{ \Illuminate\Support\Str::title($post->post_status) }}
            </div>
        @endif
        {{-- 'bg-teal-50 text-teal-500 border-teal-500' => $post->post_status == 'draft',
                'bg-yellow-50 text-yellow-600 border-yellow-500' => --}}
        <div class="font-bold line-clamp-1 dark:text-white">{{ $post->post_title }}</div>
        <div class="text-sm text-zinc-400 line-clamp-1">Last updated
            {{ \Illuminate\Support\Carbon::createFromFormat('Y-m-d H:i:s', $post->post_updated_at)->diffForHumans() }}
        </div>
    </div>
    <div class="flex-shrink-0 flex items-center gap-2">
        <form action="{{ route('posts.edit', ['postId' => $post->post_id]) }}" method="get">
            <button type="submit"
                class="bg-teal-50 w-10 h-10 rounded-full flex justify-center items-center border border-teal-500"
                title="Edit post">
                <x-icons.pencil class="text-teal-500" />
            </button>
        </form>

        <form action="{{ route('posts.destroy') }}" method="post" x-data
            @submit.prevent="() => {
            if(confirm('Are you sure?')) {
                $el.submit();
            } else {
                return;
            }
        }">
            @csrf
            @method('delete')
            <input type="hidden" name="post-id" value="{{ $post->post_id }}">
            <button class="bg-rose-50 w-10 h-10 rounded-full flex justify-center items-center border border-rose-500"
                title="Delete post">
                <x-icons.delete class="text-rose-500" />
            </button>
        </form>
    </div>
</div>

@props(['post'])

<div class="post-bar h-28 border rounded-md p-4 bg-inherit flex">
    <div class="flex flex-col justify-center gap-1 flex-grow">
        <div @class([
            'text-xs border rounded-full w-max h-max px-2 py-1',
            'bg-green-50 text-green-500 border-green-500' => $post->post_status == 'published',
            'bg-cyan-50 text-cyan-500 border-cyan-500' => $post->post_status == 'draft',
            'bg-yellow-50 text-yellow-600 border-yellow-500' => $post->post_status == 'archived'
        ])>{{ \Illuminate\Support\Str::title($post->post_status) }}</div>
        <div class="font-bold line-clamp-1">{{ $post->post_title }}</div>
        <div class="text-sm text-zinc-400 line-clamp-1">Last updated
            {{ \Illuminate\Support\Carbon::createFromFormat('Y-m-d H:i:s', $post->post_updated_at)->diffForHumans() }}</div>
    </div>
    <div class="flex-shrink-0 flex items-center gap-2">
        <form action="{{ route('posts.edit', ['postId' => $post->post_id]) }}" method="get">
            <button type="submit" class="bg-green-50 w-10 h-10 rounded-full flex justify-center items-center border border-green-500" title="Edit post">
                <x-icons.pencil class="text-green-500"/>
            </button>
        </form>

        <form action="{{ route('posts.destroy', ['postId', $post->post_id]) }}" method="post" x-data @submit.prevent="() => {
            if(confirm('Are you sure?')) {
                $el.submit();
            } else {
                return;
            }
        }">
            @csrf
            @method('delete')

            <button class="bg-rose-50 w-10 h-10 rounded-full flex justify-center items-center border border-rose-500" title="Delete post">
                <x-icons.delete class="text-rose-500"/>
            </button>
        </form>
    </div>
</div>

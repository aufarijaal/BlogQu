<div class="bg-white shadow-sm sm:rounded-md flex flex-col gap-4 items-start p-6" x-show=!showComments>
    <div class="text-zinc-400 self-center sm:self-start">MORE BY <span
            class="text-cyan-500 font-semibold">{{ $post->author_name }}</span></div>
    <div class="flex flex-wrap gap-6">
        @foreach ($posts as $post)
            <x-post-card :post="$post" />
        @endforeach
    </div>
</div>
<div class="flex flex-col gap-6" x-data="{ replyTo: { name: '', content: '' }, showUpdateCommentForm: false, inputCharCount: 0 }">
    <div id="comments-section"
        class="bg-white dark:bg-zinc-800 shadow-sm sm:rounded-md flex flex-col gap-4 items-start p-6 max-h-[600px] overflow-y-auto scrollbar-thin scrollbar-track-cyan-50 scrollbar-thumb-cyan-500 {{ count($comments) ? 'pb-20' : '' }}"
        x-show="showComments">
        @if (count($comments))
            <div class="self-center text-zinc-400 sm:self-start">COMMENTS</div>
        @else
            <div class="self-center text-zinc-400">No Comments yet.</div>
        @endif
        @foreach ($comments as $comment)
            <x-comment-card :comment="$comment" />
        @endforeach
    </div>

    @if (Auth::user())
        @include('components.comment-form')
    @else
        <div class="dark:bg-zinc-800 p-6 rounded-md flex flex-col items-center gap-4" x-show="showComments">
            <div class="dark:text-zinc-400 font-semibold">Log in to comment</div>
            <a class="block bg-cyan-500 text-white rounded-md p-6 py-1 font-semibold" href="{{ route('login') }}">Login</a>
        </div>
    @endif
</div>

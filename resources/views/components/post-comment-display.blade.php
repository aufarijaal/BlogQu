<div class="flex flex-col gap-6" x-data="{ replyTo: { name: '', content: '' }, showUpdateCommentForm: false, inputCharCount: 0 }">
    <div id="comments-section"
        class="bg-white shadow-sm sm:rounded-md flex flex-col gap-4 items-start p-6 max-h-[600px] overflow-y-auto scrollbar-thin scrollbar-track-cyan-50 scrollbar-thumb-cyan-500 {{ count($comments) ? 'pb-20' : '' }}"
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

    @include('components.comment-form')
</div>

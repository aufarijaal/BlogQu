<div class="bg-white p-3 sm:rounded-md shadow-sm" x-show="showComments">

    <div class="comment-reply-to border border-cyan-500 p-3 flex justify-between items-center rounded-md mb-2" x-show="replyTo.name && replyTo.content">
        <div class="flex flex-col gap-2">
            <div class="text-cyan-500 text-sm flex gap-2 items-center">
                <x-icons.reply class="w-5 h-5"/>
                <div>Reply to</div>
            </div>
            <div class="text-sm font-semibold" x-text="replyTo.name"></div>
            <div class="text-xs line-clamp-2" x-text="replyTo.content"></div>
        </div>
        <div>
            <button class="text-zinc-400 hover:bg-zinc-400 hover:text-white w-8 h-8 rounded-full transition-none flex items-center justify-center" @click="replyTo = { name: '', content: '' }">
                <x-icons.x class="w-6 h-6"/>
            </button>
        </div>
    </div>
    
    {{-- Form for update comment --}}
    <form id="form-update-comment" class="flex flex-col gap-2" action="{{ route('comments.update') }}" method="post" x-show="showUpdateCommentForm">
        @csrf
        @method('put')

        <div class="flex justify-between items-center">
            <div class="text-cyan-500 text-sm">Update comment</div>
            <button type="button" class="text-zinc-400 hover:bg-zinc-400 hover:text-white w-8 h-8 rounded-full transition-none flex items-center justify-center" @click="() => {
                showUpdateCommentForm = false;
                $refs.inputUpdateCommentId.value = '';
                $refs.inputUpdateCommentContent.value = '';
            }">
                <x-icons.x class="w-6 h-6"/>
            </button>
        </div>
        <input type="hidden" name="comment-id" x-ref="inputUpdateCommentId">
        <textarea class="bg-zinc-100 rounded-md border-none focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150 text-sm" name="content" cols="30" rows="3" placeholder="Write a comment..." required x-ref="inputUpdateCommentContent"></textarea>
        <button class="bg-cyan-500 text-white font-semibold w-[90px] h-[30px] self-end rounded-md" type="submit">Update</button>
    </form>

    {{-- Form for create comment --}}
    <form id="form-create-comment" class="flex flex-col gap-2" action="{{ route('comments.create') }}" method="post" x-show="!showUpdateCommentForm">
        @csrf
        <input type="hidden" name="parent-id" x-ref="inputCommentParentId">
        <input type="hidden" name="post-id" value={{ $post->post_id }}>
        <textarea class="bg-zinc-100 rounded-md border-none focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150 text-sm" name="content" cols="30" rows="3" placeholder="Write a comment..." required></textarea>
        <button class="bg-cyan-500 text-white font-semibold w-[90px] h-[30px] self-end rounded-md" type="submit">Send</button>
    </form>
</div>
<div class="p-3 bg-white dark:bg-zinc-800 shadow-sm sm:rounded-md" x-show="showComments">

    <div class="flex items-center justify-between p-3 mb-2 border rounded-md comment-reply-to border-cyan-500 dark:text-white"
        x-show="replyTo.name && replyTo.content">
        <div class="flex flex-col gap-2">
            <div class="flex items-center gap-2 text-sm text-cyan-500">
                <x-icons.reply class="w-5 h-5" />
                <div>Reply to</div>
            </div>
            <div class="text-sm font-semibold" x-text="replyTo.name"></div>
            <div class="text-xs line-clamp-2" x-text="replyTo.content"></div>
        </div>
        <div>
            <button
                class="flex items-center justify-center w-8 h-8 transition-none rounded-full text-zinc-400 hover:bg-zinc-400 hover:text-white"
                @click="replyTo = { name: '', content: '' }">
                <x-icons.x class="w-6 h-6" />
            </button>
        </div>
    </div>

    {{-- Form for update comment --}}
    <form id="form-update-comment" class="flex flex-col gap-2" action="{{ route('comments.update') }}" method="post"
        x-show="showUpdateCommentForm" x-ref="formUpdateComment" onsubmit="return checkForm()">
        @csrf
        @method('put')

        <div class="flex items-center justify-between">
            <div class="text-sm text-cyan-500">Update comment</div>
            <button type="button"
                class="flex items-center justify-center w-8 h-8 transition-none rounded-full text-zinc-400 hover:bg-zinc-400 hover:text-white"
                @click="() => {
                showUpdateCommentForm = false;
                $refs.inputUpdateCommentId.value = '';
                $refs.inputUpdateCommentContent.value = '';
            }">
                <x-icons.x class="w-6 h-6" />
            </button>
        </div>
        <input type="hidden" name="comment-id" x-ref="inputUpdateCommentId">
        <div class="flex flex-col gap-1">
            <textarea
                class="text-sm transition duration-150 ease-in-out border rounded-md bg-zinc-100 dark:bg-zinc-800 dark:border-zinc-600 dark:text-white focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:ring-offset-2 dark:focus:ring-offset-zinc-800"
                name="content" cols="30" rows="3" maxlength="200" placeholder="Write a comment..." required
                x-ref="inputUpdateCommentContent" @input="inputCharCount = $el.value.length"
                @keyup.ctrl.enter="() => {
                    if(!$refs.formUpdateComment.checkValidity()) return $refs.formUpdateComment.reportValidity();

                    $refs.formUpdateComment.submit();
                }"></textarea>
            <div class="flex justify-end sm:justify-between">
                <div class="hidden text-xs sm:block text-zinc-400">Cmd / Ctrl+Enter to submit</div>
                <div class="text-xs text-zinc-400"><span x-text="inputCharCount"></span>/200</div>
            </div>
        </div>
        <button class="bg-cyan-500 text-white font-semibold w-[90px] h-[30px] self-end rounded-md"
            type="submit">Update</button>
    </form>

    {{-- Form for create comment --}}
    <form id="form-create-comment" class="flex flex-col gap-2" action="{{ route('comments.create') }}" method="post"
        x-show="!showUpdateCommentForm" x-ref="formCreateComment">
        @csrf
        <input type="hidden" name="parent-id" x-ref="inputCommentParentId">
        <input type="hidden" name="post-id" value={{ $post->post_id }}>
        <div class="flex flex-col gap-1">
            <textarea
                class="text-sm transition duration-150 ease-in-out border rounded-md dark:bg-zinc-800 dark:text-white dark:border-zinc-600 bg-zinc-100 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:ring-offset-2 dark:focus:ring-offset-zinc-800"
                name="content" cols="30" rows="3" maxlength="200" placeholder="Write a comment..." required
                @input="inputCharCount = $el.value.length" @keyup.ctrl.enter="() => {
                    if(!$refs.formCreateComment.checkValidity()) return $refs.formCreateComment.reportValidity();
                    $refs.formCreateComment.submit();
                }"></textarea>
            <div class="flex justify-end sm:justify-between">
                <div class="hidden text-xs sm:block text-zinc-400">Cmd / Ctrl+Enter to submit</div>
                <div class="text-xs text-zinc-400"><span x-text="inputCharCount"></span>/200</div>
            </div>
        </div>
        <button class="bg-cyan-500 text-white font-semibold w-[90px] h-[30px] self-end rounded-md"
            type="submit">Send</button>
    </form>
</div>

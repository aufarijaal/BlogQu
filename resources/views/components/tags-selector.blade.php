@props(['tags', 'existing', 'id', 'name'])

{{-- Tags Selector --}}
<div class="relative" id="tags-selector" x-data="{ open: false, final: { 'new': [], 'tags': Object.values({{ $existing }}) }, tagSearchInput: '', newUserTags: [], selectedTags: Object.values({{ $existing }}), allTags: {{ $tags->toJson() }}, searchResultTags: [] }" x-init="() => {
    $watch('selectedTags', () => {
        final = { 'new': newUserTags, 'tags': selectedTags };
    });

    $watch('newUserTags', () => {
        final = { 'new': newUserTags, 'tags': selectedTags };
    });
}">
    {{-- Input for storing the selected tags --}}
    <input class="w-full h-8 font-mono text-xs text-green-400 bg-black" readonly type="hidden" name="{{ $name }}"
        x-model="JSON.stringify(final)">

    <div class="border min-h-[44px] rounded-md flex flex-wrap items-center p-2 gap-2" id="tags-selector-input-wrapper">
        {{-- Input tag finder --}}
        <input
            class="text-sm h-6 w-[120px] border-zinc-300 border rounded-md pl-2 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:ring-offset-2 dark:focus:ring-offset-zinc-800 transition ease-in-out duration-150 focus:border-zinc-300"
            type="text" id="{{ $id }}" x-model="tagSearchInput"
            x-show="(selectedTags.length + newUserTags.length) < 5" x-ref="tagSearchInputEl"
            maxlength="255"
            @input="() => {
                open = true;
                searchResultTags = allTags.filter(each => each.name.toLowerCase().includes(tagSearchInput));
            }"
            @keyup.esc="open = false" placeholder="Find a tag...">

        {{-- Selected tags from user newly typed --}}
        <template x-for="(tag, index) in newUserTags">
            <div class="text-sm h-6 max-w-[200px] bg-cyan-100 flex items-center rounded-full gap-1 pr-2">
                <button
                    class="flex items-center justify-center flex-shrink-0 w-6 h-6 text-white rounded-full bg-cyan-500"
                    @click="newUserTags.splice(index, 1)" type="button">
                    <x-icons.x class="w-5 h-5" />
                </button>
                <div class="w-full font-semibold text-cyan-500 line-clamp-1" x-text="tag"></div>
            </div>
        </template>

        {{-- Selected tags from data --}}
        <template x-for="(tag, index) in selectedTags">
            <div class="text-sm h-6 max-w-[200px] bg-cyan-100 dark:bg-cyan-800 flex items-center rounded-full gap-1 pr-2">
                <button
                    class="flex items-center justify-center flex-shrink-0 w-6 h-6 text-white rounded-full bg-cyan-500"
                    @click="selectedTags.splice(index, 1)" type="button">
                    <x-icons.x class="w-5 h-5" />
                </button>
                <div class="w-full font-semibold text-cyan-500 dark:text-cyan-200 line-clamp-1" x-text="tag.name"></div>
            </div>
        </template>
    </div>

    {{-- Tag list popup --}}
    <ul class="absolute bg-white w-full top-22 rounded-md z-10 border border-zinc-300 shadow-xl p-4 flex flex-col gap-1 max-h-[200px] overflow-y-auto scrollbar-thin scrollbar-track-cyan-50 scrollbar-thumb-cyan-500"
        id="tag-list-popup" x-show="open"
        @click.outside="() => {
            searchResultTags = [];
            tagSearchInput = '';
            open = false;
        }">

        {{-- The default list item for typed tag --}}
        <li class="tag-selector-list-item" x-data="sanitizer" x-text="sanitizeTag(tagSearchInput)"
            x-show="tagSearchInput.length"
            @click="() => {
            if(!newUserTags.includes(sanitizeTag(tagSearchInput))) {
                newUserTags.push(sanitizeTag(tagSearchInput));
                open = false;
                tagSearchInput = '';
                searchResultTags = [];
            }
        }">
        </li>

        {{-- The list items for search result --}}
        <template x-for="tag in searchResultTags">
            <li class="tag-selector-list-item" x-text="tag.name"
                @click="() => {
                if(!selectedTags.some(each => each.name.includes(tag.name))) {
                    selectedTags.push(tag);
                    open = false;
                    tagSearchInput = '';
                    searchResultTags = [];
                }
            }">
            </li>
        </template>
    </ul>
</div>

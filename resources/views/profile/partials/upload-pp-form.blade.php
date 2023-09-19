@php
    $profilePicture = auth()->user()->profile->pp;
@endphp

<section class="space-y-6" x-data>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Profile Picture') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('You can choose image with extension of PNG or JPG or JPEG thats not larger than 3 Megabytes.') }}
        </p>
    </header>

    <form action="{{ route('additional_profile.pp.destroy') }}" method="post">
        @csrf
        @method('delete')
        <input type="hidden" name="user-id" value="{{ $profile->user_id }}">
        <x-danger-button>{{ __('Remove Picture') }}</x-danger-button>
    </form>

    <form id="form-change-pp" action="{{ route('additional_profile.pp.store') }}" method="post"
        enctype="multipart/form-data">
        @csrf
        @method('patch')
        <input type="hidden" name="user-id" value="{{ $profile->user_id }}">
        <input class="hidden" type="file" name="pp" id="pp"
            @change="() => {
            document.getElementById('form-change-pp').submit();
        }">
        <div class="mb-4 text-sm font-medium text-gray-700 dark:text-gray-300">Click below to upload</div>
        <label for="pp">
            @if (!is_null($profilePicture))
                <img class="w-32 h-32 rounded-full cursor-pointer" src="{{ asset(str_contains($profilePicture, 'http') ? $profilePicture : '/storage/' . $profilePicture) }}"
                    alt="Profile picture">
            @else
                <div class="flex items-center justify-center w-32 h-32 rounded-full cursor-pointer bg-zinc-200">
                    <x-icons.user-outline class="w-9 h-9 text-zinc-400" />
                </div>
            @endif
        </label>
    </form>
</section>

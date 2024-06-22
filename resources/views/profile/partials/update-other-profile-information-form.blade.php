<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Other Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Update your account's bio, about, username, and more.") }}
        </p>
    </header>

    <form method="post" action="{{ route('additional_profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <input type="hidden" name="user-id" value="{{ old('user-id', $profile->user_id) }}">
        <div>
            <x-input-label for="username" :value="__('Username')" />
            <x-text-input id="username" name="username" type="text" class="block w-full mt-1" :value="old('username', $profile->username)"
                required autofocus autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('username')" />
        </div>

        <div>
            <x-input-label for="bio" :value="__('Bio')" />
            <textarea
                class="w-full border-zinc-300 rounded-md shadow-sm dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-300 focus:border-teal-500 dark:focus:border-teal-600 focus:ring-teal-500 dark:focus:ring-teal-600"
                name="bio" id="bio" cols="30" rows="3">{{ old('bio', $profile->bio) }}</textarea>
            <x-input-error class="mt-2" :messages="$errors->get('bio')" />
        </div>

        <div>
            <x-input-label for="about" :value="__('About')" />
            <textarea
                class="w-full border-zinc-300 rounded-md shadow-sm dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-300 focus:border-teal-500 dark:focus:border-teal-600 focus:ring-teal-500 dark:focus:ring-teal-600"
                name="about" id="about" cols="30" rows="3">{{ old('about', $profile->about) }}</textarea>
            <x-input-error class="mt-2" :messages="$errors->get('about')" />
        </div>

        <div>
            <x-input-label for="gender" :value="__('Gender')" />
            <div class="flex gap-4">
                <label class="flex items-center gap-2 text-sm font-medium text-gray-700 dark:text-gray-300"
                    for="gender-male">
                    <input class="accent-teal-500" type="radio" name="gender" id="gender-male" value="M"
                        {{ $profile->gender == 'M' ? 'checked' : '' }}>
                    Male
                </label>
                <label class="flex items-center gap-2 text-sm font-medium text-gray-700 dark:text-gray-300"
                    for="gender-female">
                    <input class="accent-teal-500" type="radio" name="gender" id="gender-female" value="F"
                        {{ $profile->gender == 'F' ? 'checked' : '' }}>
                    Female
                </label>
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('about')" />
        </div>

        <div>
            <x-input-label for="dob" :value="__('Date of Birth')" />
            <input
                class="border-zinc-300 rounded-md shadow-sm dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-300 focus:border-teal-500 dark:focus:border-teal-600 focus:ring-teal-500 dark:focus:ring-teal-600"
                type="date" name="dob" id="dob" value="{{ $profile->dob }}">
            <x-input-error class="mt-2" :messages="$errors->get('dob')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>

<x-root-layout>
    <x-slot name="head">
        <title>Profile</title>
    </x-slot>

    <x-slot name="body">
        <div class="py-20">
            <div class="mx-auto space-y-6 max-w-7xl sm:px-6 lg:px-8">
                <div class="p-4 bg-white shadow sm:p-8 dark:bg-zinc-800 sm:rounded-lg">
                    <div class="max-w-xl">
                        @include('profile.partials.upload-pp-form')
                    </div>
                </div>

                <div class="p-4 bg-white shadow sm:p-8 dark:bg-zinc-800 sm:rounded-lg">
                    <div class="max-w-xl">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                <div class="p-4 bg-white shadow sm:p-8 dark:bg-zinc-800 sm:rounded-lg">
                    <div class="max-w-xl">
                        @include('profile.partials.update-other-profile-information-form')
                    </div>
                </div>

                <div class="p-4 bg-white shadow sm:p-8 dark:bg-zinc-800 sm:rounded-lg">
                    <div class="max-w-xl">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>

                <div class="p-4 bg-white shadow sm:p-8 dark:bg-zinc-800 sm:rounded-lg">
                    <div class="max-w-xl">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    <x-slot name="script">

    </x-slot>
</x-root-layout>

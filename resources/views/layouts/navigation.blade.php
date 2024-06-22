@php
    $profilePicture = is_null(auth()->user()) ? null : auth()->user()->profile->pp;
@endphp

<nav x-data="{ open: false }"
    class="fixed top-0 left-0 z-10 w-full bg-white border-b border-gray-100 dark:bg-zinc-800 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center gap-4">
                <!-- Logo -->
                <div class="flex items-center shrink-0">
                    <a class="flex items-center gap-2 text-xl font-bold text-teal-600 font-barlow"
                        href="{{ route('home') }}">
                        <x-application-logo class="block w-auto fill-current h-9" />
                        <span class="hidden sm:inline">BlogQu</span>
                    </a>
                </div>
                <div>
                    @if (Route::current()->uri != 'posts/{postId}/edit' && Route::current()->uri != 'profile')
                        <form action="{{ route('search.posts') }}" method="get">
                            <div class="flex items-center h-8 pl-2 overflow-hidden rounded-md bg-zinc-100 dark:bg-zinc-600 text-white"
                                tabindex="0">
                                <x-icons.search class="w-5 h-5 text-zinc-400" />
                                <input
                                    class="sm:w-[200px] w-full border-none bg-transparent outline-none focus:ring-0 text-sm text-black dark:text-white placeholder:text-gray-400 dark:placeholder:text-white"
                                    type="text" name="q" placeholder="Search... (Press /)" tabindex="-1"
                                    id="search-bar" required>
                            </div>
                        </form>
                    @endif
                </div>
            </div>

            @if (Auth::user())
                <!-- Settings Dropdown -->
                <div class="hidden gap-4 sm:flex sm:items-center sm:ml-6">
                    @if (!request()->routeIs('posts.edit'))
                        <form action="{{ route('posts.create') }}" method="post">
                            @csrf
                            <button
                                class="flex items-center gap-2 px-4 text-sm font-bold text-white rounded-md bg-teal-500 dark:bg-teal-800 h-9"
                                type="submit">
                                <x-icons.magic class="w-5 h-5" />
                                Write
                            </button>
                        </form>
                    @endif

                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                class="inline-flex items-center px-3 py-2 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out bg-white border border-transparent rounded-md dark:text-gray-400 dark:bg-zinc-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none">
                                @if (!is_null($profilePicture))
                                    <img class="mr-2 rounded-full w-9 h-9"
                                        src="{{ asset(str_contains($profilePicture, 'http') ? $profilePicture : '/storage/' . $profilePicture) }}"
                                        alt="Profile picture">
                                @else
                                    <div
                                        class="flex items-center justify-center mr-2 rounded-full cursor-pointer w-9 h-9 bg-zinc-200">
                                        <x-icons.user-outline class="w-4 h-4 text-zinc-400" />
                                    </div>
                                @endif
                                <div>{{ Auth::user()->name }}</div>

                                <div class="ml-1">
                                    <svg class="w-4 h-4 fill-current" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('posts.my')">
                                {{ __('My Posts') }}
                            </x-dropdown-link>

                            <x-dropdown-link :href="route('favorites.current_user')">
                                {{ __('Saved posts') }}
                            </x-dropdown-link>

                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            <x-dropdown-item>
                                <div class="flex items-center justify-between" x-data="{
                                    theme: localStorage.getItem('theme') ||
                                        localStorage.setItem('theme', 'system')
                                }">
                                    <div>Theme</div>
                                    <select
                                        class="h-6 text-xs p-1 pr-4 w-[80px] border-none bg-teal-50 text-teal-500 font-semibold rounded-md"
                                        @change="(e) => {
                                        localStorage.setItem('theme', e.target.value);
                                        location.reload();
                                    }"
                                        :value="theme">
                                        <option value="system">System</option>
                                        <option value="light">Light</option>
                                        <option value="dark">Dark</option>
                                    </select>
                                </div>
                            </x-dropdown-item>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            @else
                <div class="items-center hidden gap-2 sm:flex">
                    <a class="flex items-center justify-center w-24 h-8 text-sm font-bold text-white rounded-md bg-teal-500 sm:text-base sm:w-28"
                        href="{{ route('login') }}">LOGIN</a>
                    <a class="flex items-center justify-center w-24 h-8 text-sm font-bold bg-white dark:bg-zinc-800 border rounded-md border-teal-500 text-teal-500 sm:text-base sm:w-28"
                        href="{{ route('register') }}">REGISTER</a>
                </div>
            @endif

            <!-- Hamburger -->
            <div class="flex items-center -mr-2 sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 text-gray-400 transition duration-150 ease-in-out rounded-md dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400">
                    <svg class="w-6 h-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            @if (Auth::user())
                <div class="px-4">
                    <div class="text-base font-medium text-zinc-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                    <div class="text-sm font-medium text-gray-500">{{ Auth::user()->email }}</div>
                </div>
                <div class="mt-3 space-y-1">
                    @if (!request()->routeIs('posts.edit'))
                        <div>
                            <form action="{{ route('posts.create') }}" method="post">
                                @csrf
                                <button
                                    class="flex items-center w-full h-10 gap-2 pl-4 font-semibold text-white bg-teal-500"
                                    type="submit">
                                    <x-icons.magic class="w-5 h-5" />
                                    Write
                                </button>
                            </form>
                        </div>
                    @endif
                    <x-responsive-nav-link :href="route('profile.edit')">
                        {{ __('Profile') }}
                    </x-responsive-nav-link>

                    <x-responsive-nav-link :href="route('posts.my')">
                        {{ __('My Posts') }}
                    </x-responsive-nav-link>

                    <x-responsive-nav-link :href="route('favorites.current_user')">
                        {{ __('Saved posts') }}
                    </x-responsive-nav-link>

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                            this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            @else
                <div class="space-y-1">
                    <x-responsive-nav-link :href="route('login')">
                        {{ __('Login') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('register')">
                        {{ __('Register') }}
                    </x-responsive-nav-link>
                </div>
            @endif

        </div>
    </div>
</nav>

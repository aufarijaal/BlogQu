<nav x-data="{ open: false }"
    class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700 fixed top-0 left-0 w-full z-10">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center gap-4">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a class="flex items-center gap-2 text-cyan-600 font-bold text-xl font-barlow"
                        href="{{ route('home') }}">
                        <x-application-logo class="block h-9 w-auto fill-current" />
                        <span class="hidden sm:inline">BlogQu</span>
                    </a>
                </div>
                <div>
                    <form action="{{ route('search.posts') }}" method="get">
                        <div class="h-8 flex bg-zinc-100 pl-2 rounded-md overflow-hidden items-center pseudo-input"
                            tabindex="0">
                            <x-icons.search class="w-5 h-5 text-zinc-400" />
                            <input
                                class="sm:w-[200px] w-full border-none bg-transparent outline-none focus:ring-0 text-sm"
                                type="text" name="q" placeholder="Search... (Press /)" tabindex="-1" required>
                        </div>
                    </form>
                </div>
            </div>

            @if (Auth::user())
                <!-- Settings Dropdown -->
                <div class="hidden sm:flex sm:items-center sm:ml-6 gap-4">
                    <form action="{{ route('posts.create') }}" method="post">
                        @csrf
                        <button class="bg-cyan-500 text-white font-bold rounded-md h-9 px-4 flex items-center gap-2 text-sm" type="submit">
                            <x-icons.magic class="w-5 h-5"/>
                            Write
                        </button>
                    </form>

                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                                <div>{{ Auth::user()->name }}</div>

                                <div class="ml-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
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
                <div class="sm:flex gap-2 items-center hidden">
                    <a class="bg-cyan-500 text-white font-bold w-24 h-8 rounded-md flex items-center justify-center text-sm sm:text-base sm:w-28"
                        href="{{ route('login') }}">LOGIN</a>
                    <a class="bg-white border border-cyan-500 text-cyan-500 font-bold w-24 h-8 rounded-md flex items-center justify-center text-sm sm:text-base sm:w-28"
                        href="{{ route('register') }}">REGISTER</a>
                </div>
            @endif

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
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
                    <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>
                <div class="mt-3 space-y-1">
                    <div>
                        <form action="{{ route('posts.create') }}" method="post">
                            @csrf
                            <button class="bg-cyan-500 text-white font-semibold h-10 pl-4 w-full flex items-center gap-2" type="submit">
                                <x-icons.magic class="w-5 h-5"/>
                                Write
                            </button>
                        </form>
                    </div>
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

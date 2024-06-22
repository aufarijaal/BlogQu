<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{
    theme: localStorage.getItem('theme') ||
        localStorage.setItem('theme', 'system')
}" x-init="$watch('theme', val => localStorage.setItem('theme', val))"
    x-bind:class="{
        'dark': theme === 'dark' || (theme === 'system' && window.matchMedia('(prefers-color-scheme: dark)')
            .matches)
    }">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="{{ asset('favicon.svg') }}" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Barlow:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400;1,500;1,600;1,700;1,800&family=Inter:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    {{ $head }}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <x-rich-text-trix-styles />
</head>

<body class="font-sans antialiased scrollbar-thin scrollbar-track-teal-50 scrollbar-thumb-teal-500">
    <div class="flex flex-col min-h-screen bg-zinc-100 dark:bg-zinc-900">
        @include('layouts.navigation')

        <!-- Page Content -->
        <main class="bg-inherit">
            {{ $body }}
        </main>

        <!-- Page Footer -->
        <footer class="w-full bg-teal-500 dark:bg-teal-700">
            <div class="max-w-4xl p-10 mx-auto">
                <div class="flex flex-col items-center gap-6">
                    <div class="flex items-center gap-2 text-2xl font-bold text-white/90 font-barlow">
                        <x-application-logo class="w-12 h-12" />
                        <div>BlogQu</div>
                    </div>
                    <p class="text-sm leading-[1.7] text-white text-justify">Lorem ipsum dolor sit amet consectetur
                        adipisicing elit.
                        Corporis fugiat itaque at modi non qui quod quae vero cupiditate dolor enim sequi ratione
                        voluptas asperiores est magnam, quaerat laboriosam accusantium?</p>
                </div>
            </div>
        </footer>

        <button
            class="fixed flex items-center justify-center w-12 h-12 rounded-md bottom-6 right-6 bg-zinc-900 dark:bg-white hover:bg-zinc-700"
            id="btn-back-to-top">
            <svg class="w-5 h-5 text-white dark:text-zinc-900" xmlns="http://www.w3.org/2000/svg" width="24"
                height="24" viewBox="0 0 24 24">
                <path fill="currentColor" d="M13 20h-2V8l-5.5 5.5l-1.42-1.42L12 4.16l7.92 7.92l-1.42 1.42L13 8v12Z" />
            </svg>
        </button>
    </div>
    {{ $script }}
    <script>
        // Back to top button script
        window.addEventListener('scroll', function() {
            let button = document.getElementById('btn-back-to-top');

            if ((window.innerHeight + window.pageYOffset) >= document.body.offsetHeight) {
                button.style.transform = 'translateY(-12rem)';
            } else {
                button.style.transform = 'translateY(0)';
            }

            if (window.scrollY > 200) {
                button.style.display = 'flex';
            } else {
                button.style.display = 'none';
            }
        });

        document.getElementById('btn-back-to-top').addEventListener('click', function(e) {
            e.preventDefault();
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

        @if (Route::current()->uri != 'posts/{postId}/edit' && Route::current()->uri != 'profile')
            document.addEventListener("keyup", (e) => {
                if (e.code === "Slash") {
                    document.getElementById("search-bar").focus();
                }
            });
        @endif
    </script>
</body>

</html>

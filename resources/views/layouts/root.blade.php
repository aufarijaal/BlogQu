<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="favicon.svg" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Barlow:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400;1,500;1,600;1,700;1,800&family=Inter:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    {{ $head }}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased scrollbar-thin scrollbar-track-cyan-50 scrollbar-thumb-cyan-500">
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900 flex flex-col">
        @include('layouts.navigation')

        <!-- Page Content -->
        <main class="bg-inherit">
            {{ $body }}
        </main>

        <!-- Page Footer -->
        <footer class="w-full bg-cyan-500 h-48">
            djaiods
        </footer>

        <button
            class="fixed bottom-6 right-6 bg-zinc-900 hover:bg-zinc-700 w-12 h-12 rounded-md flex justify-center items-center"
            id="btn-back-to-top">
            <svg class="text-white w-5 h-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                viewBox="0 0 24 24">
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
    </script>
</body>

</html>

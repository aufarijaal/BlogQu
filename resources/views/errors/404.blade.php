<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Page Not Found &middot; BlogQu</title>
    <link rel="shortcut icon" href="{{ asset('favicon.svg') }}" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css'])
</head>

<body class="flex flex-col items-center justify-center w-full min-h-screen dark:bg-zinc-900">
    <div class="font-bold text-[150px] sm:text-[200px] text-teal-600">404</div>
    <div class="text-4xl font-semibold">NOT FOUND</div>
    <div class="mt-6">Sorry, We could not find the page you are looking for</div>
    <button
        class="text-teal-500 border border-teal-500 hover:bg-teal-100 hover:border-teal-600 hover:text-teal-600 bg-teal-50 px-4 py-1.5 rounded-md mt-4"
        onclick="window.history.go(-1); return false;">Go Back</button>
</body>

</html>

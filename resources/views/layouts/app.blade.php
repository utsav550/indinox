<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Indinox</title>

    {{-- TEMP: remove vite --}}
    {{-- @vite('resources/css/app.css') --}}

    {{-- Add CDN Tailwind --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Alpine --}}
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-100">

    @yield('content')

</body>
</html>
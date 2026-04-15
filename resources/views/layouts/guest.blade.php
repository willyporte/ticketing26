<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="TicketFlow — La piattaforma di ticketing B2B per team di supporto moderni.">
    <title>@yield('title', 'TicketFlow')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Alpine.js Intersect plugin --}}
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/intersect@3.x.x/dist/cdn.min.js"></script>
    {{-- Alpine.js core --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-50 text-gray-900 antialiased dark:bg-gray-900 dark:text-white">

    @yield('content')

</body>
</html>

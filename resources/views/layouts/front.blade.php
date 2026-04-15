<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="@yield('description', 'TicketFlow — La piattaforma di ticketing B2B per team di supporto moderni.')">
    <title>@yield('title', 'TicketFlow')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Alpine.js Intersect plugin --}}
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/intersect@3.x.x/dist/cdn.min.js"></script>
    {{-- Alpine.js core --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-50 text-gray-900 antialiased dark:bg-gray-900 dark:text-white">

{{-- ═══════════════════════════════════════════════════════════════
     NAVBAR
═══════════════════════════════════════════════════════════════ --}}
<header
    x-data="{ open: false, scrolled: false }"
    x-init="window.addEventListener('scroll', () => { scrolled = window.scrollY > 20 })"
    :class="scrolled ? 'bg-white/80 dark:bg-gray-900/80 backdrop-blur shadow-sm' : 'bg-transparent'"
    class="fixed inset-x-0 top-0 z-50 transition-all duration-300"
    role="banner"
>
    <nav class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8" aria-label="Navigazione principale">
        <div class="flex h-16 items-center justify-between">

            {{-- Logo --}}
            <a href="{{ route('home') }}" class="flex items-center gap-2" aria-label="Vai alla homepage">
                <span class="inline-flex h-8 w-8 items-center justify-center rounded-lg bg-amber-500 text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                    </svg>
                </span>
                <span class="text-lg font-bold tracking-tight text-gray-900 dark:text-white">TicketFlow</span>
            </a>

            {{-- Desktop links --}}
            <div class="hidden items-center gap-8 md:flex">
                <a href="{{ route('home') }}" class="text-sm font-medium text-gray-700 transition hover:text-amber-500 dark:text-gray-300 dark:hover:text-amber-400 {{ request()->routeIs('home') ? 'text-amber-500 dark:text-amber-400' : '' }}">Home</a>
                <a href="{{ route('come-funziona') }}" class="text-sm font-medium text-gray-700 transition hover:text-amber-500 dark:text-gray-300 dark:hover:text-amber-400 {{ request()->routeIs('come-funziona') ? 'text-amber-500 dark:text-amber-400' : '' }}">Come Funziona</a>
                <a href="{{ route('contattaci') }}" class="rounded-lg bg-amber-500 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-amber-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-amber-500">Contattaci</a>
            </div>

            {{-- Mobile burger --}}
            <button
                @click="open = !open"
                class="inline-flex items-center justify-center rounded-md p-2 text-gray-700 transition hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800 md:hidden"
                :aria-expanded="open.toString()"
                aria-label="Apri menu di navigazione"
            >
                <svg x-show="!open" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                <svg x-show="open" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        {{-- Mobile menu --}}
        <div
            x-show="open"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 -translate-y-2"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-2"
            class="border-t border-gray-100 bg-white/95 pb-4 pt-2 dark:border-gray-800 dark:bg-gray-900/95 md:hidden"
        >
            <div class="flex flex-col gap-1 px-2">
                <a href="{{ route('home') }}" class="rounded-md px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800 {{ request()->routeIs('home') ? 'bg-gray-100 dark:bg-gray-800' : '' }}">Home</a>
                <a href="{{ route('come-funziona') }}" class="rounded-md px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800 {{ request()->routeIs('come-funziona') ? 'bg-gray-100 dark:bg-gray-800' : '' }}">Come Funziona</a>
                <a href="{{ route('contattaci') }}" class="mt-1 rounded-lg bg-amber-500 px-3 py-2 text-center text-sm font-semibold text-white hover:bg-amber-600">Contattaci</a>
            </div>
        </div>
    </nav>
</header>

{{-- Contenuto pagina --}}
<main>
    @yield('content')
</main>

{{-- ═══════════════════════════════════════════════════════════════
     FOOTER
═══════════════════════════════════════════════════════════════ --}}
<footer class="border-t border-gray-200 bg-white py-12 dark:border-gray-800 dark:bg-gray-900" role="contentinfo">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="grid gap-10 sm:grid-cols-2 lg:grid-cols-3">

            {{-- Colonna 1: brand --}}
            <div>
                <div class="mb-3 flex items-center gap-2">
                    <span class="inline-flex h-7 w-7 items-center justify-center rounded-lg bg-amber-500 text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                        </svg>
                    </span>
                    <span class="text-base font-bold text-gray-900 dark:text-white">TicketFlow</span>
                </div>
                <p class="text-sm leading-relaxed text-gray-500 dark:text-gray-400">
                    La piattaforma di ticketing B2B per team di supporto moderni. Semplice, veloce, affidabile.
                </p>
            </div>

            {{-- Colonna 2: link utili --}}
            <div>
                <h3 class="mb-4 text-xs font-semibold uppercase tracking-widest text-gray-400 dark:text-gray-500">Navigazione</h3>
                <ul class="space-y-2">
                    <li><a href="{{ route('come-funziona') }}" class="text-sm text-gray-600 transition hover:text-amber-500 dark:text-gray-400 dark:hover:text-amber-400">Come Funziona</a></li>
                    <li><a href="{{ route('contattaci') }}" class="text-sm text-gray-600 transition hover:text-amber-500 dark:text-gray-400 dark:hover:text-amber-400">Contattaci</a></li>
                </ul>
            </div>

            {{-- Colonna 3: legale --}}
            <div>
                <h3 class="mb-4 text-xs font-semibold uppercase tracking-widest text-gray-400 dark:text-gray-500">Legale</h3>
                <ul class="space-y-2">
                    <li><a href="{{ route('privacy-policy') }}" class="text-sm text-gray-600 transition hover:text-amber-500 dark:text-gray-400 dark:hover:text-amber-400">Privacy Policy</a></li>
                    <li><a href="{{ route('termini') }}" class="text-sm text-gray-600 transition hover:text-amber-500 dark:text-gray-400 dark:hover:text-amber-400">Termini e Condizioni</a></li>
                </ul>
            </div>

        </div>

        <div class="mt-10 border-t border-gray-100 pt-6 text-center dark:border-gray-800">
            <p class="text-xs text-gray-400 dark:text-gray-600">&copy; {{ date('Y') }} TicketFlow. Tutti i diritti riservati.</p>
            <p class="mt-1 text-xs text-gray-400 dark:text-gray-600">Titolare: Guillermo Portesi &mdash; <span class="font-medium text-amber-500">Versione Demo &mdash; Non inserire dati reali</span></p>
        </div>
    </div>
</footer>

</body>
</html>

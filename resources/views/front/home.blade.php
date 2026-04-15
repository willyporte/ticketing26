@extends('layouts.guest')

@section('content')

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
                <a href="{{ route('home') }}" class="text-sm font-medium text-gray-700 transition hover:text-amber-500 dark:text-gray-300 dark:hover:text-amber-400">Home</a>
                <a href="{{ route('come-funziona') }}" class="text-sm font-medium text-gray-700 transition hover:text-amber-500 dark:text-gray-300 dark:hover:text-amber-400">Come Funziona</a>
                <a href="{{ route('contattaci') }}" class="rounded-lg bg-amber-500 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-amber-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-amber-500">Contattaci</a>
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
                <a href="{{ route('home') }}" class="rounded-md px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800">Home</a>
                <a href="{{ route('come-funziona') }}" class="rounded-md px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800">Come Funziona</a>
                <a href="{{ route('contattaci') }}" class="mt-1 rounded-lg bg-amber-500 px-3 py-2 text-center text-sm font-semibold text-white hover:bg-amber-600">Contattaci</a>
            </div>
        </div>
    </nav>
</header>

<main>

{{-- ═══════════════════════════════════════════════════════════════
     HERO
═══════════════════════════════════════════════════════════════ --}}
<section class="relative overflow-hidden bg-gray-50 pt-28 pb-20 dark:bg-gray-900 lg:pt-36 lg:pb-28" aria-label="Hero">
    {{-- Gradient blob --}}
    <div class="pointer-events-none absolute -top-40 -right-40 h-[600px] w-[600px] rounded-full bg-amber-400/20 blur-3xl dark:bg-amber-500/10" aria-hidden="true"></div>
    <div class="pointer-events-none absolute -bottom-40 -left-40 h-[500px] w-[500px] rounded-full bg-amber-300/20 blur-3xl dark:bg-amber-600/10" aria-hidden="true"></div>

    <div class="relative mx-auto max-w-4xl px-4 text-center sm:px-6 lg:px-8">
        <span class="mb-4 inline-block rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold uppercase tracking-widest text-amber-700 dark:bg-amber-900/40 dark:text-amber-400">Supporto B2B</span>
        <h1 class="mb-6 text-4xl font-extrabold tracking-tight text-gray-900 dark:text-white sm:text-5xl lg:text-6xl">
            Gestisci il supporto<br class="hidden sm:block">
            <span class="text-amber-500">senza sprecare tempo</span>
        </h1>
        <p class="mx-auto mb-10 max-w-2xl text-lg leading-relaxed text-gray-600 dark:text-gray-400">
            TicketFlow è la piattaforma di ticketing pensata per team di supporto B2B. Tieni traccia di ogni richiesta, assegna i ticket agli operatori e mantieni i clienti aggiornati in tempo reale.
        </p>
        <div class="flex flex-col items-center justify-center gap-4 sm:flex-row">
            <a
                href="{{ route('come-funziona') }}"
                class="w-full rounded-xl border-2 border-amber-500 px-8 py-3.5 text-base font-semibold text-amber-600 transition hover:bg-amber-50 dark:text-amber-400 dark:hover:bg-amber-900/20 sm:w-auto"
                aria-label="Scopri come funziona TicketFlow"
            >
                Come Funziona
            </a>
            <a
                href="{{ route('contattaci') }}"
                class="w-full rounded-xl bg-amber-500 px-8 py-3.5 text-base font-semibold text-white shadow-lg shadow-amber-500/30 transition hover:bg-amber-600 sm:w-auto"
                aria-label="Contattaci per una demo"
            >
                Richiedi una demo →
            </a>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════
     PERCHÉ SCEGLIERCI
═══════════════════════════════════════════════════════════════ --}}
<section
    x-data="{ visible: false }"
    x-intersect.once="visible = true"
    class="bg-white py-20 dark:bg-gray-800 lg:py-28"
    aria-label="Perché sceglierci"
>
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div
            x-show="visible"
            x-transition:enter="transition ease-out duration-500"
            x-transition:enter-start="opacity-0 translate-y-6"
            x-transition:enter-end="opacity-100 translate-y-0"
            class="mb-14 text-center"
        >
            <h2 class="text-3xl font-extrabold tracking-tight text-gray-900 dark:text-white sm:text-4xl">Perché sceglierci</h2>
            <p class="mt-4 text-base leading-relaxed text-gray-600 dark:text-gray-400">Tutto ciò che serve per un supporto clienti efficiente, niente di superfluo.</p>
        </div>

        <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">

            {{-- Card 1 --}}
            <div
                x-show="visible"
                x-transition:enter="transition ease-out duration-500 delay-100"
                x-transition:enter-start="opacity-0 translate-y-8"
                x-transition:enter-end="opacity-100 translate-y-0"
                class="group rounded-2xl border border-gray-100 bg-gray-50 p-8 transition-transform duration-200 hover:scale-105 dark:border-gray-700 dark:bg-gray-900"
            >
                <div class="mb-5 inline-flex h-12 w-12 items-center justify-center rounded-xl bg-amber-100 text-amber-600 dark:bg-amber-900/40 dark:text-amber-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                <h3 class="mb-2 text-lg font-bold text-gray-900 dark:text-white">Risposta rapida</h3>
                <p class="text-sm leading-relaxed text-gray-600 dark:text-gray-400">Assegna i ticket automaticamente agli operatori disponibili e riduci i tempi di risposta al minimo.</p>
            </div>

            {{-- Card 2 --}}
            <div
                x-show="visible"
                x-transition:enter="transition ease-out duration-500 delay-200"
                x-transition:enter-start="opacity-0 translate-y-8"
                x-transition:enter-end="opacity-100 translate-y-0"
                class="group rounded-2xl border border-gray-100 bg-gray-50 p-8 transition-transform duration-200 hover:scale-105 dark:border-gray-700 dark:bg-gray-900"
            >
                <div class="mb-5 inline-flex h-12 w-12 items-center justify-center rounded-xl bg-amber-100 text-amber-600 dark:bg-amber-900/40 dark:text-amber-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
                <h3 class="mb-2 text-lg font-bold text-gray-900 dark:text-white">Report e statistiche</h3>
                <p class="text-sm leading-relaxed text-gray-600 dark:text-gray-400">Monitora le prestazioni del team, tieni traccia dei minuti lavorati e genera report in un click.</p>
            </div>

            {{-- Card 3 --}}
            <div
                x-show="visible"
                x-transition:enter="transition ease-out duration-500 delay-300"
                x-transition:enter-start="opacity-0 translate-y-8"
                x-transition:enter-end="opacity-100 translate-y-0"
                class="group rounded-2xl border border-gray-100 bg-gray-50 p-8 transition-transform duration-200 hover:scale-105 dark:border-gray-700 dark:bg-gray-900 sm:col-span-2 lg:col-span-1"
            >
                <div class="mb-5 inline-flex h-12 w-12 items-center justify-center rounded-xl bg-amber-100 text-amber-600 dark:bg-amber-900/40 dark:text-amber-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </div>
                <h3 class="mb-2 text-lg font-bold text-gray-900 dark:text-white">Multi-azienda sicuro</h3>
                <p class="text-sm leading-relaxed text-gray-600 dark:text-gray-400">Ogni cliente vede solo i propri ticket. Permessi granulari per ruolo, isolamento totale dei dati.</p>
            </div>

        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════
     COME FUNZIONA (preview)
═══════════════════════════════════════════════════════════════ --}}
<section
    x-data="{ visible: false }"
    x-intersect.once="visible = true"
    class="bg-gray-50 py-20 dark:bg-gray-900 lg:py-28"
    aria-label="Come funziona"
>
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div
            x-show="visible"
            x-transition:enter="transition ease-out duration-500"
            x-transition:enter-start="opacity-0 translate-y-6"
            x-transition:enter-end="opacity-100 translate-y-0"
            class="mb-14 text-center"
        >
            <h2 class="text-3xl font-extrabold tracking-tight text-gray-900 dark:text-white sm:text-4xl">Come funziona</h2>
            <p class="mt-4 text-base leading-relaxed text-gray-600 dark:text-gray-400">Tre passi per trasformare il supporto della tua azienda.</p>
        </div>

        <div class="relative grid gap-8 md:grid-cols-3">
            {{-- Linea connettore desktop --}}
            <div class="pointer-events-none absolute top-8 left-1/2 hidden h-0.5 w-2/3 -translate-x-1/2 bg-amber-200 dark:bg-amber-900 md:block" aria-hidden="true"></div>

            @foreach ([
                ['num' => '01', 'title' => 'Apri un ticket', 'desc' => 'Il cliente invia una richiesta in pochi secondi: titolo, descrizione e priorità. Nessun form infinito.', 'delay' => '100'],
                ['num' => '02', 'title' => 'L\'operatore interviene', 'desc' => 'Il team riceve la notifica, prende in carico il ticket e aggiorna lo stato in tempo reale.', 'delay' => '200'],
                ['num' => '03', 'title' => 'Problema risolto', 'desc' => 'Il cliente riceve conferma della risoluzione e può riaprire il ticket se necessario.', 'delay' => '300'],
            ] as $step)
            <div
                x-show="visible"
                x-transition:enter="transition ease-out duration-500"
                x-transition:enter-start="opacity-0 translate-y-8"
                x-transition:enter-end="opacity-100 translate-y-0"
                style="transition-delay: {{ $step['delay'] }}ms"
                class="relative flex flex-col items-center text-center"
            >
                <div class="relative z-10 mb-5 flex h-16 w-16 items-center justify-center rounded-full bg-amber-500 text-xl font-extrabold text-white shadow-lg shadow-amber-500/30">
                    {{ $step['num'] }}
                </div>
                <h3 class="mb-2 text-lg font-bold text-gray-900 dark:text-white">{{ $step['title'] }}</h3>
                <p class="text-sm leading-relaxed text-gray-600 dark:text-gray-400">{{ $step['desc'] }}</p>
            </div>
            @endforeach
        </div>

        <div
            x-show="visible"
            x-transition:enter="transition ease-out duration-500 delay-500"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            class="mt-12 text-center"
        >
            <a href="{{ route('come-funziona') }}" class="text-sm font-semibold text-amber-600 underline underline-offset-4 transition hover:text-amber-700 dark:text-amber-400 dark:hover:text-amber-300">
                Scopri tutti i dettagli →
            </a>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════
     STATISTICHE
═══════════════════════════════════════════════════════════════ --}}
<section
    x-data="{
        visible: false,
        counters: [
            { label: 'Ticket risolti', target: 12400, suffix: '+', current: 0 },
            { label: 'Aziende attive', target: 340,   suffix: '+', current: 0 },
            { label: 'Soddisfazione clienti', target: 98, suffix: '%', current: 0 },
        ],
        run() {
            this.counters.forEach((counter, i) => {
                const duration = 1800
                const step = 16
                const increment = counter.target / (duration / step)
                const timer = setInterval(() => {
                    counter.current = Math.min(Math.round(counter.current + increment), counter.target)
                    if (counter.current >= counter.target) clearInterval(timer)
                }, step)
            })
        }
    }"
    x-intersect.once="visible = true; run()"
    class="bg-amber-500 py-20 dark:bg-amber-600"
    aria-label="Statistiche"
>
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="grid gap-10 text-center sm:grid-cols-3">
            <template x-for="(stat, index) in counters" :key="index">
                <div
                    x-show="visible"
                    x-transition:enter="transition ease-out duration-500"
                    x-transition:enter-start="opacity-0 scale-90"
                    x-transition:enter-end="opacity-100 scale-100"
                >
                    <div class="text-5xl font-extrabold tracking-tight text-white">
                        <span x-text="stat.current.toLocaleString('it-IT')"></span><span x-text="stat.suffix"></span>
                    </div>
                    <div class="mt-2 text-sm font-medium text-amber-100" x-text="stat.label"></div>
                </div>
            </template>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════
     TESTIMONIAL
═══════════════════════════════════════════════════════════════ --}}
<section
    x-data="{ visible: false }"
    x-intersect.once="visible = true"
    class="bg-white py-20 dark:bg-gray-800 lg:py-28"
    aria-label="Testimonianze clienti"
>
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div
            x-show="visible"
            x-transition:enter="transition ease-out duration-500"
            x-transition:enter-start="opacity-0 translate-y-6"
            x-transition:enter-end="opacity-100 translate-y-0"
            class="mb-14 text-center"
        >
            <h2 class="text-3xl font-extrabold tracking-tight text-gray-900 dark:text-white sm:text-4xl">Cosa dicono di noi</h2>
        </div>

        <div class="grid gap-8 md:grid-cols-2">

            <div
                x-show="visible"
                x-transition:enter="transition ease-out duration-500 delay-100"
                x-transition:enter-start="opacity-0 translate-y-6"
                x-transition:enter-end="opacity-100 translate-y-0"
                class="rounded-2xl border border-gray-100 bg-gray-50 p-8 dark:border-gray-700 dark:bg-gray-900"
            >
                <div class="mb-4 flex text-amber-400" aria-label="5 stelle su 5">
                    @for ($i = 0; $i < 5; $i++)
                    <svg class="h-5 w-5 fill-current" viewBox="0 0 20 20" aria-hidden="true"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    @endfor
                </div>
                <blockquote class="mb-6 text-base leading-relaxed text-gray-700 dark:text-gray-300">
                    "Da quando usiamo TicketFlow i tempi di risposta si sono dimezzati. I nostri clienti ricevono aggiornamenti in tempo reale e non dobbiamo più inseguire le email."
                </blockquote>
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-amber-100 text-sm font-bold text-amber-700 dark:bg-amber-900/40 dark:text-amber-400">LB</div>
                    <div>
                        <div class="text-sm font-semibold text-gray-900 dark:text-white">Laura Bianchi</div>
                        <div class="text-xs text-gray-500 dark:text-gray-400">Responsabile Supporto, Tecnocraft Srl</div>
                    </div>
                </div>
            </div>

            <div
                x-show="visible"
                x-transition:enter="transition ease-out duration-500 delay-200"
                x-transition:enter-start="opacity-0 translate-y-6"
                x-transition:enter-end="opacity-100 translate-y-0"
                class="rounded-2xl border border-gray-100 bg-gray-50 p-8 dark:border-gray-700 dark:bg-gray-900"
            >
                <div class="mb-4 flex text-amber-400" aria-label="5 stelle su 5">
                    @for ($i = 0; $i < 5; $i++)
                    <svg class="h-5 w-5 fill-current" viewBox="0 0 20 20" aria-hidden="true"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    @endfor
                </div>
                <blockquote class="mb-6 text-base leading-relaxed text-gray-700 dark:text-gray-300">
                    "Finalmente uno strumento che parla la stessa lingua del nostro team. Semplice per i clienti, potente per gli operatori. Il controllo sulle ore lavorate vale da solo il prezzo."
                </blockquote>
                <div class="flex items-center gap-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-amber-100 text-sm font-bold text-amber-700 dark:bg-amber-900/40 dark:text-amber-400">MR</div>
                    <div>
                        <div class="text-sm font-semibold text-gray-900 dark:text-white">Marco Russo</div>
                        <div class="text-xs text-gray-500 dark:text-gray-400">CTO, Digitale Futuro SpA</div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════
     CTA FINALE
═══════════════════════════════════════════════════════════════ --}}
<section
    x-data="{ visible: false }"
    x-intersect.once="visible = true"
    class="bg-gray-50 py-20 dark:bg-gray-900 lg:py-28"
    aria-label="Chiamata all'azione"
>
    <div class="mx-auto max-w-3xl px-4 text-center sm:px-6 lg:px-8">
        <div
            x-show="visible"
            x-transition:enter="transition ease-out duration-600"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
        >
            <h2 class="mb-4 text-3xl font-extrabold tracking-tight text-gray-900 dark:text-white sm:text-4xl">
                Pronto a semplificare il tuo supporto?
            </h2>
            <p class="mb-8 text-base leading-relaxed text-gray-600 dark:text-gray-400">
                Parla con noi. Ti mostriamo come TicketFlow si adatta alla tua azienda in meno di 30 minuti.
            </p>
            <a
                href="{{ route('contattaci') }}"
                class="inline-block rounded-xl bg-amber-500 px-10 py-4 text-base font-bold text-white shadow-xl shadow-amber-500/30 transition hover:bg-amber-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-amber-500"
                aria-label="Contattaci per una demo gratuita"
            >
                Contattaci ora →
            </a>
        </div>
    </div>
</section>

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
        </div>
    </div>
</footer>

@endsection

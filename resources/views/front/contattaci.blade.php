@extends('layouts.front')

@section('title', 'Contattaci — TicketFlow')
@section('description', 'Hai domande su TicketFlow? Scrivici e ti risponderemo entro 24 ore.')

@section('content')

{{-- ═══════════════════════════════════════════════════════════════
     PAGE HERO
═══════════════════════════════════════════════════════════════ --}}
<section class="relative overflow-hidden bg-gray-50 pt-28 pb-16 dark:bg-gray-900 lg:pt-36 lg:pb-20" aria-label="Intestazione pagina">
    <div class="pointer-events-none absolute -top-40 -right-40 h-150 w-150 rounded-full bg-amber-400/20 blur-3xl dark:bg-amber-500/10" aria-hidden="true"></div>
    <div class="relative mx-auto max-w-3xl px-4 text-center sm:px-6 lg:px-8">
        <span class="mb-4 inline-block rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold uppercase tracking-widest text-amber-700 dark:bg-amber-900/40 dark:text-amber-400">Contatti</span>
        <h1 class="mb-4 text-4xl font-extrabold tracking-tight text-gray-900 dark:text-white sm:text-5xl">
            Parliamo
        </h1>
        <p class="text-lg leading-relaxed text-gray-600 dark:text-gray-400">
            Hai domande o vuoi una demo? Scrivici e ti risponderemo entro 24 ore.
        </p>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════
     FORM CONTATTO
═══════════════════════════════════════════════════════════════ --}}
<section class="bg-white py-20 dark:bg-gray-800 lg:py-28" aria-label="Modulo di contatto">
    <div class="mx-auto max-w-2xl px-4 sm:px-6 lg:px-8">


        <form
            x-data="{
                sent: false,
                submit() {
                    // Demo: simula invio senza chiamata reale
                    this.sent = true
                }
            }"
            @submit.prevent="submit"
            class="space-y-6"
            novalidate
        >
            <div x-show="!sent">

                <div class="grid gap-6 sm:grid-cols-2">
                    <div>
                        <label for="nome" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-300">Nome</label>
                        <input
                            id="nome" type="text" name="nome" autocomplete="given-name"
                            placeholder="Mario"
                            class="w-full rounded-xl border border-gray-200 bg-white px-4 py-3 text-sm text-gray-900 placeholder-gray-400 transition focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-500/20 dark:border-gray-700 dark:bg-gray-900 dark:text-white dark:placeholder-gray-600"
                        >
                    </div>
                    <div>
                        <label for="cognome" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-300">Cognome</label>
                        <input
                            id="cognome" type="text" name="cognome" autocomplete="family-name"
                            placeholder="Rossi"
                            class="w-full rounded-xl border border-gray-200 bg-white px-4 py-3 text-sm text-gray-900 placeholder-gray-400 transition focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-500/20 dark:border-gray-700 dark:bg-gray-900 dark:text-white dark:placeholder-gray-600"
                        >
                    </div>
                </div>

                <div>
                    <label for="email" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-300">Email aziendale</label>
                    <input
                        id="email" type="email" name="email" autocomplete="email"
                        placeholder="mario.rossi@azienda.it"
                        class="w-full rounded-xl border border-gray-200 bg-white px-4 py-3 text-sm text-gray-900 placeholder-gray-400 transition focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-500/20 dark:border-gray-700 dark:bg-gray-900 dark:text-white dark:placeholder-gray-600"
                    >
                </div>

                <div>
                    <label for="azienda" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-300">Azienda</label>
                    <input
                        id="azienda" type="text" name="azienda" autocomplete="organization"
                        placeholder="Acme Srl"
                        class="w-full rounded-xl border border-gray-200 bg-white px-4 py-3 text-sm text-gray-900 placeholder-gray-400 transition focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-500/20 dark:border-gray-700 dark:bg-gray-900 dark:text-white dark:placeholder-gray-600"
                    >
                </div>

                <div>
                    <label for="messaggio" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-300">Messaggio</label>
                    <textarea
                        id="messaggio" name="messaggio" rows="5"
                        placeholder="Descrivici le tue esigenze..."
                        class="w-full resize-none rounded-xl border border-gray-200 bg-white px-4 py-3 text-sm text-gray-900 placeholder-gray-400 transition focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-500/20 dark:border-gray-700 dark:bg-gray-900 dark:text-white dark:placeholder-gray-600"
                    ></textarea>
                </div>

                <button
                    type="submit"
                    class="w-full rounded-xl bg-amber-500 px-8 py-3.5 text-base font-semibold text-white shadow-lg shadow-amber-500/30 transition hover:bg-amber-600 sm:w-auto"
                >
                    Invia messaggio →
                </button>

            </div>

            {{-- Feedback invio (demo) --}}
            <div
                x-show="sent"
                x-transition:enter="transition ease-out duration-400"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                class="rounded-2xl border border-green-200 bg-green-50 p-8 text-center dark:border-green-800/40 dark:bg-green-900/20"
                role="alert"
            >
                <div class="mx-auto mb-4 flex h-12 w-12 items-center justify-center rounded-full bg-green-100 text-green-600 dark:bg-green-900/40 dark:text-green-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <h3 class="mb-2 text-lg font-bold text-gray-900 dark:text-white">Messaggio inviato!</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400">Ti risponderemo entro 24 ore all'indirizzo indicato.</p>
            </div>

        </form>

    </div>
</section>

@endsection

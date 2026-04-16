@extends('layouts.front')

@section('title', 'Contattaci — TicketFlow')
@section('description', 'Richiedi una demo gratuita di TicketFlow. Compila il form e ti ricontatteremo entro 24 ore.')

@section('content')

{{-- ═══════════════════════════════════════════════════════════════
     PAGE HERO
═══════════════════════════════════════════════════════════════ --}}
<section class="relative overflow-hidden bg-gray-50 pt-28 pb-16 dark:bg-gray-900 lg:pt-36 lg:pb-20" aria-label="Intestazione pagina">
    <div class="pointer-events-none absolute -top-40 -right-40 h-150 w-150 rounded-full bg-amber-400/20 blur-3xl dark:bg-amber-500/10" aria-hidden="true"></div>
    <div class="pointer-events-none absolute -bottom-20 -left-20 h-80 w-80 rounded-full bg-amber-300/10 blur-3xl dark:bg-amber-600/10" aria-hidden="true"></div>
    <div class="relative mx-auto max-w-3xl px-4 text-center sm:px-6 lg:px-8">
        <span class="mb-4 inline-block rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold uppercase tracking-widest text-amber-700 dark:bg-amber-900/40 dark:text-amber-400">Richiedi una demo</span>
        <h1 class="mb-4 text-4xl font-extrabold tracking-tight text-gray-900 dark:text-white sm:text-5xl">
            Parliamo del tuo<br class="hidden sm:block"> <span class="text-amber-500">progetto</span>
        </h1>
        <p class="text-lg leading-relaxed text-gray-600 dark:text-gray-400">
            Vuoi portare TicketFlow nella tua azienda? Compila il form e ti contatteremo entro <strong>24 ore</strong> per una demo gratuita e senza impegno.
        </p>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════
     FORM + SIDEBAR
═══════════════════════════════════════════════════════════════ --}}
<section class="bg-white py-20 dark:bg-gray-800 lg:py-28" aria-label="Modulo di contatto">
    <div class="mx-auto max-w-2xl px-4 sm:px-6 lg:px-8">

        {{-- ── Titolo form ──────────────────────────────────────────────────── --}}
        <div class="mb-8 text-center">
            <h2 class="text-3xl font-extrabold tracking-tight text-gray-900 dark:text-white sm:text-4xl">
                Compila il form e ti richiamiamo noi
            </h2>
            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Nessun impegno. Ti risponderemo entro 24 ore.</p>
        </div>

        {{-- ── Form ────────────────────────────────────────────────────────── --}}
        <div class="rounded-2xl border border-gray-100 bg-white p-8 shadow-xl shadow-gray-200/60 dark:border-gray-700 dark:bg-gray-900 dark:shadow-none sm:p-10">

                @if(session('success'))
                {{-- Feedback successo --}}
                <div
                    x-data x-init="$el.scrollIntoView({ behavior: 'smooth', block: 'center' })"
                    class="rounded-2xl border border-green-200 bg-green-50 p-10 text-center dark:border-green-800/40 dark:bg-green-900/20"
                    role="alert"
                >
                    <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-full bg-green-100 text-green-600 dark:bg-green-900/40 dark:text-green-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <h3 class="mb-2 text-xl font-bold text-gray-900 dark:text-white">Richiesta inviata!</h3>
                    <p class="text-gray-600 dark:text-gray-400">Grazie per averci contattato. Ti risponderemo entro 24 ore all'indirizzo indicato.</p>
                </div>

                @else
                {{-- Form --}}
                <form method="POST" action="{{ route('contattaci.send') }}" class="space-y-6" novalidate>
                    @csrf

                    {{-- Errori globali --}}
                    @if($errors->any())
                    <div class="rounded-xl border border-red-200 bg-red-50 p-4 dark:border-red-800/40 dark:bg-red-900/20">
                        <ul class="space-y-1">
                            @foreach($errors->all() as $error)
                                <li class="text-sm text-red-700 dark:text-red-400">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    {{-- Nome + Cognome --}}
                    <div class="grid gap-6 sm:grid-cols-2">
                        <div>
                            <label for="nome" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Nome <span class="text-red-500">*</span>
                            </label>
                            <input
                                id="nome" type="text" name="nome" autocomplete="given-name"
                                value="{{ old('nome') }}" placeholder="Mario"
                                required
                                class="w-full rounded-xl border px-4 py-3 text-sm text-gray-900 placeholder-gray-400 transition focus:outline-none focus:ring-2 focus:ring-amber-500/20 dark:bg-gray-900 dark:text-white dark:placeholder-gray-600
                                       {{ $errors->has('nome') ? 'border-red-400 focus:border-red-400 bg-red-50 dark:bg-red-900/10' : 'border-gray-200 focus:border-amber-500 bg-white dark:border-gray-700' }}"
                            >
                        </div>
                        <div>
                            <label for="cognome" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Cognome <span class="text-red-500">*</span>
                            </label>
                            <input
                                id="cognome" type="text" name="cognome" autocomplete="family-name"
                                value="{{ old('cognome') }}" placeholder="Rossi"
                                required
                                class="w-full rounded-xl border px-4 py-3 text-sm text-gray-900 placeholder-gray-400 transition focus:outline-none focus:ring-2 focus:ring-amber-500/20 dark:bg-gray-900 dark:text-white dark:placeholder-gray-600
                                       {{ $errors->has('cognome') ? 'border-red-400 focus:border-red-400 bg-red-50 dark:bg-red-900/10' : 'border-gray-200 focus:border-amber-500 bg-white dark:border-gray-700' }}"
                            >
                        </div>
                    </div>

                    {{-- Email aziendale --}}
                    <div>
                        <label for="email" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Email aziendale <span class="text-red-500">*</span>
                        </label>
                        <input
                            id="email" type="email" name="email" autocomplete="email"
                            value="{{ old('email') }}" placeholder="mario.rossi@azienda.it"
                            required
                            class="w-full rounded-xl border px-4 py-3 text-sm text-gray-900 placeholder-gray-400 transition focus:outline-none focus:ring-2 focus:ring-amber-500/20 dark:bg-gray-900 dark:text-white dark:placeholder-gray-600
                                   {{ $errors->has('email') ? 'border-red-400 focus:border-red-400 bg-red-50 dark:bg-red-900/10' : 'border-gray-200 focus:border-amber-500 bg-white dark:border-gray-700' }}"
                        >
                        <p class="mt-1.5 text-xs text-gray-400">Utilizza l'email aziendale — evitiamo indirizzi Gmail o simili.</p>
                    </div>

                    {{-- Azienda + Telefono --}}
                    <div class="grid gap-6 sm:grid-cols-2">
                        <div>
                            <label for="azienda" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-300">Azienda</label>
                            <input
                                id="azienda" type="text" name="azienda" autocomplete="organization"
                                value="{{ old('azienda') }}" placeholder="Acme Srl"
                                class="w-full rounded-xl border border-gray-200 bg-white px-4 py-3 text-sm text-gray-900 placeholder-gray-400 transition focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-500/20 dark:border-gray-700 dark:bg-gray-900 dark:text-white dark:placeholder-gray-600"
                            >
                        </div>
                        <div>
                            <label for="telefono" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-300">Telefono</label>
                            <input
                                id="telefono" type="tel" name="telefono" autocomplete="tel"
                                value="{{ old('telefono') }}" placeholder="+39 02 1234567"
                                class="w-full rounded-xl border border-gray-200 bg-white px-4 py-3 text-sm text-gray-900 placeholder-gray-400 transition focus:border-amber-500 focus:outline-none focus:ring-2 focus:ring-amber-500/20 dark:border-gray-700 dark:bg-gray-900 dark:text-white dark:placeholder-gray-600"
                            >
                        </div>
                    </div>

                    {{-- Messaggio --}}
                    <div>
                        <label for="messaggio" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Messaggio <span class="text-red-500">*</span>
                        </label>
                        <textarea
                            id="messaggio" name="messaggio" rows="5"
                            placeholder="Raccontaci brevemente la tua azienda e cosa stai cercando..."
                            required
                            class="w-full resize-none rounded-xl border px-4 py-3 text-sm text-gray-900 placeholder-gray-400 transition focus:outline-none focus:ring-2 focus:ring-amber-500/20 dark:bg-gray-900 dark:text-white dark:placeholder-gray-600
                                   {{ $errors->has('messaggio') ? 'border-red-400 focus:border-red-400 bg-red-50 dark:bg-red-900/10' : 'border-gray-200 focus:border-amber-500 bg-white dark:border-gray-700' }}"
                        >{{ old('messaggio') }}</textarea>
                    </div>

                    {{-- Disclaimer privacy obbligatorio --}}
                    <div class="rounded-xl border p-4 {{ $errors->has('privacy') ? 'border-red-300 bg-red-50 dark:border-red-800/40 dark:bg-red-900/10' : 'border-gray-200 bg-gray-50 dark:border-gray-700 dark:bg-gray-900/40' }}">
                        <label class="flex cursor-pointer items-start gap-3">
                            <input
                                type="checkbox" name="privacy" value="1"
                                {{ old('privacy') ? 'checked' : '' }}
                                required
                                class="mt-0.5 h-4 w-4 shrink-0 rounded border-gray-300 text-amber-500 focus:ring-amber-500"
                            >
                            <span class="text-sm leading-relaxed text-gray-600 dark:text-gray-400">
                                Ho letto e accetto la
                                <a href="{{ route('privacy-policy') }}" target="_blank" class="font-semibold text-amber-600 hover:underline dark:text-amber-400">Privacy Policy</a>
                                e i
                                <a href="{{ route('termini') }}" target="_blank" class="font-semibold text-amber-600 hover:underline dark:text-amber-400">Termini e Condizioni</a>
                                di TicketFlow. Autorizzo il trattamento dei miei dati personali per ricevere informazioni commerciali e una demo del servizio.
                                <span class="text-red-500">*</span>
                            </span>
                        </label>
                        @error('privacy')
                            <p class="mt-2 text-xs font-medium text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-between">
                        <p class="text-xs text-gray-400"><span class="text-red-500">*</span> Campi obbligatori</p>
                        <button
                            type="submit"
                            class="rounded-xl bg-amber-500 px-10 py-3.5 text-base font-semibold text-white shadow-lg shadow-amber-500/30 transition hover:bg-amber-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-amber-500"
                        >
                            Invia richiesta →
                        </button>
                    </div>

                </form>
                @endif

        </div>{{-- /card --}}

    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════
     COSA SUCCEDE DOPO
═══════════════════════════════════════════════════════════════ --}}
<section class="bg-gray-50 py-16 dark:bg-gray-900 lg:py-20">
    <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
        <h2 class="mb-12 text-center text-3xl font-extrabold tracking-tight text-gray-900 dark:text-white sm:text-4xl">
            Cosa succede dopo?
        </h2>
        <ol class="grid gap-8 sm:grid-cols-3">
            <li class="flex flex-col items-center text-center">
                <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-full bg-amber-100 text-base font-bold text-amber-700 dark:bg-amber-900/40 dark:text-amber-400">1</div>
                <p class="font-semibold text-gray-900 dark:text-white">Ricevi conferma</p>
                <p class="mt-2 text-sm leading-relaxed text-gray-500 dark:text-gray-400">Ti risponderemo entro 24 ore all'email indicata.</p>
            </li>
            <li class="flex flex-col items-center text-center">
                <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-full bg-amber-100 text-base font-bold text-amber-700 dark:bg-amber-900/40 dark:text-amber-400">2</div>
                <p class="font-semibold text-gray-900 dark:text-white">Demo personalizzata</p>
                <p class="mt-2 text-sm leading-relaxed text-gray-500 dark:text-gray-400">Ti mostriamo TicketFlow configurato per il tuo settore, in meno di 30 minuti.</p>
            </li>
            <li class="flex flex-col items-center text-center">
                <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-full bg-amber-100 text-base font-bold text-amber-700 dark:bg-amber-900/40 dark:text-amber-400">3</div>
                <p class="font-semibold text-gray-900 dark:text-white">Attivazione rapida</p>
                <p class="mt-2 text-sm leading-relaxed text-gray-500 dark:text-gray-400">Il tuo team è operativo in pochi giorni, senza migrazioni complesse.</p>
            </li>
        </ol>
    </div>
</section>

@endsection

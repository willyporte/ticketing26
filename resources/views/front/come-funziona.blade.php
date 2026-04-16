@extends('layouts.front')

@section('title', 'Come Funziona — TicketFlow')
@section('description', 'Scopri come TicketFlow trasforma il supporto clienti B2B: un sistema di ticketing completo per clienti, operatori, supervisori e amministratori.')

@section('content')

{{-- ═══════════════════════════════════════════════════════════════
     HERO
═══════════════════════════════════════════════════════════════ --}}
<section class="relative overflow-hidden bg-gray-50 pt-28 pb-20 dark:bg-gray-900 lg:pt-36 lg:pb-28">
    <div class="pointer-events-none absolute -top-40 -right-40 h-150 w-150 rounded-full bg-amber-400/20 blur-3xl dark:bg-amber-500/10" aria-hidden="true"></div>
    <div class="pointer-events-none absolute -bottom-20 -left-40 h-125 w-125 rounded-full bg-amber-300/15 blur-3xl dark:bg-amber-600/10" aria-hidden="true"></div>

    <div class="relative mx-auto max-w-4xl px-4 text-center sm:px-6 lg:px-8">
        <span class="mb-4 inline-block rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold uppercase tracking-widest text-amber-700 dark:bg-amber-900/40 dark:text-amber-400">Come funziona</span>
        <h1 class="mb-6 text-4xl font-extrabold tracking-tight text-gray-900 dark:text-white sm:text-5xl lg:text-6xl">
            Un sistema che lavora<br class="hidden sm:block">
            <span class="text-amber-500">mentre tu ti concentri sul cliente</span>
        </h1>
        <p class="mx-auto mb-10 max-w-2xl text-lg leading-relaxed text-gray-600 dark:text-gray-400">
            TicketFlow è progettato per le aziende che vogliono offrire un supporto clienti professionale, misurabile e scalabile — senza complessità inutili e senza lasciare nessuna richiesta senza risposta.
        </p>
        <div class="flex flex-col items-center justify-center gap-4 sm:flex-row">
            <a href="{{ route('contattaci') }}" class="w-full rounded-xl bg-amber-500 px-8 py-3.5 text-base font-semibold text-white shadow-lg shadow-amber-500/30 transition hover:bg-amber-600 sm:w-auto">
                Richiedi una demo gratuita →
            </a>
            <a href="#flusso" class="w-full rounded-xl border-2 border-amber-500 px-8 py-3.5 text-base font-semibold text-amber-600 transition hover:bg-amber-50 dark:text-amber-400 dark:hover:bg-amber-900/20 sm:w-auto">
                Scopri il flusso ↓
            </a>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════
     IL PROBLEMA CHE RISOLVIAMO
═══════════════════════════════════════════════════════════════ --}}
<section class="bg-white py-20 dark:bg-gray-800 lg:py-28">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        <div class="mb-16 text-center">
            <h2 class="text-3xl font-extrabold tracking-tight text-gray-900 dark:text-white sm:text-4xl">
                Conosci questo scenario?
            </h2>
            <p class="mt-4 text-base leading-relaxed text-gray-600 dark:text-gray-400">
                Le aziende B2B perdono clienti non per i problemi, ma per come li gestiscono.
            </p>
        </div>

        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">

            <div class="rounded-2xl border border-red-100 bg-red-50 p-6 dark:border-red-900/30 dark:bg-red-900/10">
                <div class="mb-4 inline-flex h-10 w-10 items-center justify-center rounded-lg bg-red-100 text-red-500 dark:bg-red-900/30 dark:text-red-400">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                </div>
                <h3 class="mb-2 font-bold text-gray-900 dark:text-white">Le richieste arrivano via email</h3>
                <p class="text-sm leading-relaxed text-gray-600 dark:text-gray-400">Email sparse su più caselle, nessuno sa chi deve rispondere e le richieste si perdono. Il cliente aspetta. E aspetta ancora.</p>
            </div>

            <div class="rounded-2xl border border-red-100 bg-red-50 p-6 dark:border-red-900/30 dark:bg-red-900/10">
                <div class="mb-4 inline-flex h-10 w-10 items-center justify-center rounded-lg bg-red-100 text-red-500 dark:bg-red-900/30 dark:text-red-400">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                </div>
                <h3 class="mb-2 font-bold text-gray-900 dark:text-white">Nessuna tracciabilità del lavoro</h3>
                <p class="text-sm leading-relaxed text-gray-600 dark:text-gray-400">Quante ore ha impiegato il tuo team? Quale cliente consuma più risorse? Chi ha risolto cosa? Domande senza risposta.</p>
            </div>

            <div class="rounded-2xl border border-red-100 bg-red-50 p-6 dark:border-red-900/30 dark:bg-red-900/10 sm:col-span-2 lg:col-span-1">
                <div class="mb-4 inline-flex h-10 w-10 items-center justify-center rounded-lg bg-red-100 text-red-500 dark:bg-red-900/30 dark:text-red-400">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <h3 class="mb-2 font-bold text-gray-900 dark:text-white">Il cliente non sa cosa sta succedendo</h3>
                <p class="text-sm leading-relaxed text-gray-600 dark:text-gray-400">Nessun aggiornamento, nessuna conferma. Il cliente ri-scrive, ri-chiama, si spazientisce — e nel peggiore dei casi se ne va.</p>
            </div>

        </div>

        <div class="mt-12 text-center">
            <p class="text-xl font-bold text-gray-900 dark:text-white">TicketFlow risolve tutto questo — in un'unica piattaforma, per tutti.</p>
        </div>

    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════
     4 RUOLI, UNA PIATTAFORMA
═══════════════════════════════════════════════════════════════ --}}
<section class="bg-gray-50 py-20 dark:bg-gray-900 lg:py-28">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        <div class="mb-16 text-center">
            <h2 class="text-3xl font-extrabold tracking-tight text-gray-900 dark:text-white sm:text-4xl">
                Una piattaforma, quattro ruoli
            </h2>
            <p class="mx-auto mt-4 max-w-2xl text-base leading-relaxed text-gray-600 dark:text-gray-400">
                Ogni figura aziendale ha la propria visione, i propri strumenti e i propri permessi. Nessuno vede più di quello che deve vedere.
            </p>
        </div>

        <div class="grid gap-8 lg:grid-cols-2">

            {{-- Administrator --}}
            <div class="rounded-2xl border border-gray-100 bg-white p-8 dark:border-gray-700 dark:bg-gray-800">
                <div class="mb-5 flex items-center gap-4">
                    <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-xl bg-amber-100 text-amber-600 dark:bg-amber-900/40 dark:text-amber-400">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-widest text-amber-600 dark:text-amber-400">Ruolo</p>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">Amministratore</h3>
                    </div>
                </div>
                <p class="mb-5 text-sm leading-relaxed text-gray-600 dark:text-gray-400">
                    Ha il controllo totale del sistema. Gestisce le aziende clienti, crea gli utenti, configura i piani di abbonamento e monitora lo stato di salute di tutta la piattaforma da un'unica dashboard.
                </p>
                <ul class="space-y-2">
                    @foreach ([
                        'Dashboard con panoramica completa di tutti i ticket e abbonamenti',
                        'Creazione e gestione di utenti, aziende e reparti',
                        'Configurazione piani (minuti inclusi, validità, prezzi)',
                        'Alert automatici quando i minuti di un cliente scendono sotto il 20%',
                        'Export CSV per reportistica e fatturazione',
                        'Visibilità su tutto — nessun dato nascosto',
                    ] as $feat)
                    <li class="flex items-start gap-2 text-sm text-gray-600 dark:text-gray-400">
                        <svg class="mt-0.5 h-4 w-4 flex-shrink-0 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        {{ $feat }}
                    </li>
                    @endforeach
                </ul>
            </div>

            {{-- Supervisor --}}
            <div class="rounded-2xl border border-gray-100 bg-white p-8 dark:border-gray-700 dark:bg-gray-800">
                <div class="mb-5 flex items-center gap-4">
                    <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-xl bg-amber-100 text-amber-600 dark:bg-amber-900/40 dark:text-amber-400">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-widest text-amber-600 dark:text-amber-400">Ruolo</p>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">Supervisore</h3>
                    </div>
                </div>
                <p class="mb-5 text-sm leading-relaxed text-gray-600 dark:text-gray-400">
                    Coordina il team di supporto. Monitora i ticket aperti, assegna le priorità, interviene quando necessario e garantisce che nessuna richiesta rimanga senza risposta troppo a lungo.
                </p>
                <ul class="space-y-2">
                    @foreach ([
                        'Dashboard dedicata con ticket aperti, in lavorazione e in attesa',
                        'Visibilità su tutti i ticket di tutte le aziende clienti',
                        'Assegnazione ticket agli operatori disponibili',
                        'Smistamento per reparto e priorità',
                        'Inserimento e supervisione delle ore lavorate',
                        'Export parziale per rendicontazione interna',
                    ] as $feat)
                    <li class="flex items-start gap-2 text-sm text-gray-600 dark:text-gray-400">
                        <svg class="mt-0.5 h-4 w-4 flex-shrink-0 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        {{ $feat }}
                    </li>
                    @endforeach
                </ul>
            </div>

            {{-- Operator --}}
            <div class="rounded-2xl border border-gray-100 bg-white p-8 dark:border-gray-700 dark:bg-gray-800">
                <div class="mb-5 flex items-center gap-4">
                    <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-xl bg-amber-100 text-amber-600 dark:bg-amber-900/40 dark:text-amber-400">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-widest text-amber-600 dark:text-amber-400">Ruolo</p>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">Operatore</h3>
                    </div>
                </div>
                <p class="mb-5 text-sm leading-relaxed text-gray-600 dark:text-gray-400">
                    Risolve i problemi. Ha una postazione chiara con i propri ticket assegnati, la cronologia completa di ogni conversazione e gli strumenti per rispondere, allegare file e tracciare il tempo impiegato.
                </p>
                <ul class="space-y-2">
                    @foreach ([
                        'Dashboard personale con i propri ticket assegnati per stato',
                        'Presa in carico autonoma dai ticket non assegnati',
                        'Conversazione interna al ticket con allegati fino a 10 MB',
                        'Tracciamento del tempo lavorato per ogni intervento',
                        'Cambio stato ticket (aperto → in lavorazione → risolto)',
                        'Notifiche immediate su nuove risposte e assegnazioni',
                    ] as $feat)
                    <li class="flex items-start gap-2 text-sm text-gray-600 dark:text-gray-400">
                        <svg class="mt-0.5 h-4 w-4 flex-shrink-0 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        {{ $feat }}
                    </li>
                    @endforeach
                </ul>
            </div>

            {{-- Client --}}
            <div class="rounded-2xl border border-gray-100 bg-white p-8 dark:border-gray-700 dark:bg-gray-800">
                <div class="mb-5 flex items-center gap-4">
                    <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-xl bg-amber-100 text-amber-600 dark:bg-amber-900/40 dark:text-amber-400">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    </div>
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-widest text-amber-600 dark:text-amber-400">Ruolo</p>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">Cliente</h3>
                    </div>
                </div>
                <p class="mb-5 text-sm leading-relaxed text-gray-600 dark:text-gray-400">
                    La tua azienda cliente ha un portale dedicato. Apre richieste, segue lo stato in tempo reale, risponde agli operatori e ha sempre sotto controllo quanto supporto ha ancora a disposizione.
                </p>
                <ul class="space-y-2">
                    @foreach ([
                        'Apertura ticket in 30 secondi: titolo, descrizione, priorità',
                        'Visibilità sul proprio storico ticket e sullo stato aggiornato',
                        'Conversazione diretta con gli operatori, con allegati',
                        'Notifica immediata quando il ticket viene risolto',
                        'Riapertura con un click se il problema persiste',
                        'Dashboard con minuti residui e scadenza abbonamento',
                    ] as $feat)
                    <li class="flex items-start gap-2 text-sm text-gray-600 dark:text-gray-400">
                        <svg class="mt-0.5 h-4 w-4 flex-shrink-0 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        {{ $feat }}
                    </li>
                    @endforeach
                </ul>
            </div>

        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════
     IL FLUSSO COMPLETO
═══════════════════════════════════════════════════════════════ --}}
<section id="flusso" class="bg-white py-20 dark:bg-gray-800 lg:py-28">
    <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">

        <div class="mb-16 text-center">
            <h2 class="text-3xl font-extrabold tracking-tight text-gray-900 dark:text-white sm:text-4xl">
                Il ciclo completo di un ticket
            </h2>
            <p class="mt-4 text-base leading-relaxed text-gray-600 dark:text-gray-400">
                Dalla prima richiesta alla risoluzione: ogni passo è tracciato, notificato e misurabile.
            </p>
        </div>

        <div class="relative">
            <div class="absolute left-6 top-0 hidden h-full w-0.5 bg-amber-200 dark:bg-amber-900/50 sm:block" aria-hidden="true"></div>

            <div class="space-y-10">
                @foreach ([
                    ['num' => '01', 'who' => 'Cliente',               'badge' => 'text-blue-700 bg-blue-100 dark:text-blue-300 dark:bg-blue-900/30',    'title' => 'Apre il ticket',                     'desc' => 'Il cliente accede al portale e descrive il problema in pochi campi: titolo, descrizione e priorità (bassa, media, alta, urgente). Può allegare screenshot, documenti o file zip fino a 10 MB. Il ticket è istantaneamente nel sistema.'],
                    ['num' => '02', 'who' => 'Sistema',               'badge' => 'text-amber-700 bg-amber-100 dark:text-amber-300 dark:bg-amber-900/30', 'title' => 'Notifica automatica al team',          'desc' => 'Non appena il ticket viene creato, il sistema invia una notifica a supervisori e operatori. Nessuna email da monitorare, nessun rischio che la richiesta passi inosservata. Il ticket appare nella dashboard di chi deve agire.'],
                    ['num' => '03', 'who' => 'Operatore',             'badge' => 'text-green-700 bg-green-100 dark:text-green-300 dark:bg-green-900/30', 'title' => 'Prende in carico e risponde',          'desc' => "L'operatore assegna il ticket a sé stesso, aggiorna lo stato in \"In lavorazione\" e inizia la conversazione con il cliente. Il supervisore può anche assegnare manualmente in base ai carichi di lavoro."],
                    ['num' => '04', 'who' => 'Operatore',             'badge' => 'text-green-700 bg-green-100 dark:text-green-300 dark:bg-green-900/30', 'title' => 'Registra il tempo lavorato',           'desc' => "Ad ogni intervento l'operatore registra i minuti impiegati. Il sistema li scala automaticamente dal monte-ore dell'abbonamento del cliente. Tutto tracciato, tutto misurabile. Nessun calcolo manuale."],
                    ['num' => '05', 'who' => 'Sistema',               'badge' => 'text-amber-700 bg-amber-100 dark:text-amber-300 dark:bg-amber-900/30', 'title' => 'Aggiornamenti in tempo reale',          'desc' => 'Ad ogni risposta o cambio di stato, tutte le parti coinvolte ricevono una notifica. Il cliente sa sempre cosa sta succedendo. Nessun silenzio, nessuna incertezza. La trasparenza diventa un vantaggio competitivo.'],
                    ['num' => '06', 'who' => 'Operatore / Supervisor', 'badge' => 'text-green-700 bg-green-100 dark:text-green-300 dark:bg-green-900/30', 'title' => 'Marca come risolto',                   'desc' => 'Quando il problema è risolto, il ticket viene chiuso. Il cliente riceve una notifica e può riaprire il ticket con un click se necessario — mantenendo tutta la cronologia, senza ricominciare da capo.'],
                    ['num' => '07', 'who' => 'Amministratore',        'badge' => 'text-purple-700 bg-purple-100 dark:text-purple-300 dark:bg-purple-900/30','title' => 'Analizza, fattura, pianifica',       'desc' => "A fine mese l'admin esporta i dati di supporto per cliente: ore erogate, ticket gestiti, tempi medi. Dati pronti per la fatturazione. Se un cliente sta per esaurire i minuti, il sistema lo segnala in anticipo."],
                ] as $step)
                <div class="flex gap-6">
                    <div class="relative z-10 flex-shrink-0">
                        <div class="flex h-12 w-12 items-center justify-center rounded-full bg-amber-500 text-sm font-extrabold text-white shadow-md shadow-amber-500/30">
                            {{ $step['num'] }}
                        </div>
                    </div>
                    <div class="flex-1 pb-2">
                        <div class="mb-1 flex flex-wrap items-center gap-2">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white">{{ $step['title'] }}</h3>
                            <span class="rounded-full px-2.5 py-0.5 text-xs font-semibold {{ $step['badge'] }}">{{ $step['who'] }}</span>
                        </div>
                        <p class="text-sm leading-relaxed text-gray-600 dark:text-gray-400">{{ $step['desc'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════
     MODELLO A MINUTI
═══════════════════════════════════════════════════════════════ --}}
<section class="bg-gray-50 py-20 dark:bg-gray-900 lg:py-28">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        <div class="mb-16 text-center">
            <h2 class="text-3xl font-extrabold tracking-tight text-gray-900 dark:text-white sm:text-4xl">
                Il modello a minuti:<br class="hidden sm:block"> trasparente per te, chiaro per il cliente
            </h2>
            <p class="mx-auto mt-4 max-w-2xl text-base leading-relaxed text-gray-600 dark:text-gray-400">
                Ogni cliente ha un piano con un monte-ore incluso. Il supporto è misurabile, fatturabile e controllato.
            </p>
        </div>

        <div class="grid gap-8 lg:grid-cols-3">

            <div class="rounded-2xl border border-gray-100 bg-white p-8 dark:border-gray-700 dark:bg-gray-800">
                <div class="mb-4 inline-flex h-12 w-12 items-center justify-center rounded-xl bg-amber-100 text-amber-600 dark:bg-amber-900/40 dark:text-amber-400">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <h3 class="mb-3 text-lg font-bold text-gray-900 dark:text-white">Minuti scalano automaticamente</h3>
                <p class="text-sm leading-relaxed text-gray-600 dark:text-gray-400">
                    Ogni time entry registrata dall'operatore scala i minuti dall'abbonamento attivo del cliente. Zero calcoli manuali, zero errori di fatturazione. Il sistema fa tutto da solo.
                </p>
            </div>

            <div class="rounded-2xl border border-gray-100 bg-white p-8 dark:border-gray-700 dark:bg-gray-800">
                <div class="mb-4 inline-flex h-12 w-12 items-center justify-center rounded-xl bg-amber-100 text-amber-600 dark:bg-amber-900/40 dark:text-amber-400">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                </div>
                <h3 class="mb-3 text-lg font-bold text-gray-900 dark:text-white">Alert prima che sia troppo tardi</h3>
                <p class="text-sm leading-relaxed text-gray-600 dark:text-gray-400">
                    Quando i minuti residui scendono sotto il 20% del totale, l'amministratore riceve una notifica automatica. Tempo sufficiente per proporre un rinnovo prima ancora che il cliente se ne accorga.
                </p>
            </div>

            <div class="rounded-2xl border border-gray-100 bg-white p-8 dark:border-gray-700 dark:bg-gray-800">
                <div class="mb-4 inline-flex h-12 w-12 items-center justify-center rounded-xl bg-amber-100 text-amber-600 dark:bg-amber-900/40 dark:text-amber-400">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <h3 class="mb-3 text-lg font-bold text-gray-900 dark:text-white">Minuti esauriti? Il lavoro non si ferma</h3>
                <p class="text-sm leading-relaxed text-gray-600 dark:text-gray-400">
                    I ticket già aperti continuano normalmente — il tuo team non abbandona mai il cliente a metà. I nuovi ticket vengono bloccati finché il cliente non rinnova, con un messaggio chiaro su come procedere.
                </p>
            </div>

        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════
     PERCHÉ È DIVERSO
═══════════════════════════════════════════════════════════════ --}}
<section class="bg-white py-20 dark:bg-gray-800 lg:py-28">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        <div class="mb-16 text-center">
            <h2 class="text-3xl font-extrabold tracking-tight text-gray-900 dark:text-white sm:text-4xl">
                Perché TicketFlow è diverso
            </h2>
            <p class="mt-4 text-base leading-relaxed text-gray-600 dark:text-gray-400">
                Non è un tool generico. È costruito per chi eroga supporto B2B a pagamento.
            </p>
        </div>

        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ([
                ['icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',                                                                                                                                                                                       'title' => 'Permessi granulari per ruolo',    'desc' => 'Ogni utente vede solo quello che gli serve. Il cliente non vede i dati di altri clienti. L\'operatore non modifica i contratti. Tutto è isolato e sicuro.'],
                ['icon' => 'M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 0l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3',                                                                                  'title' => 'Multi-azienda nativo',            'desc' => 'Gestisci decine di aziende clienti in un\'unica piattaforma. Ogni azienda ha i propri utenti, ticket e abbonamento — completamente separati tra loro.'],
                ['icon' => 'M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z',                                                                                                                                                     'title' => 'Reportistica pronta all\'uso',    'desc' => 'Export CSV con un click. Ticket, ore lavorate, utenti, abbonamenti. Dati già filtrati per ruolo: nessun cliente riceve informazioni di un altro.'],
                ['icon' => 'M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12',                                                                                                                                                                      'title' => 'Allegati sicuri e strutturati',   'desc' => 'I file sono organizzati per azienda e ticket. Il download è protetto da policy: un cliente non può mai accedere agli allegati di un altro.'],
                ['icon' => 'M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9',                                     'title' => 'Notifiche per ogni evento',       'desc' => 'Ogni azione genera la notifica giusta alla persona giusta. Nessuno deve controllare manualmente: il sistema avvisa chi deve sapere, quando deve sapere.'],
                ['icon' => 'M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z',                                                                                                                               'title' => 'Sicurezza integrata',             'desc' => 'Autenticazione a due fattori per tutti gli utenti (app TOTP o email OTP). Accesso protetto, sessioni gestite, nessun dato cancellato definitivamente.'],
            ] as $item)
            <div class="rounded-2xl border border-gray-100 bg-gray-50 p-6 dark:border-gray-700 dark:bg-gray-900">
                <div class="mb-4 inline-flex h-10 w-10 items-center justify-center rounded-lg bg-amber-100 text-amber-600 dark:bg-amber-900/40 dark:text-amber-400">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $item['icon'] }}"/></svg>
                </div>
                <h3 class="mb-2 font-bold text-gray-900 dark:text-white">{{ $item['title'] }}</h3>
                <p class="text-sm leading-relaxed text-gray-600 dark:text-gray-400">{{ $item['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════
     CTA FINALE
═══════════════════════════════════════════════════════════════ --}}
<section class="relative overflow-hidden bg-gray-50 py-20 dark:bg-gray-900 lg:py-28">

    {{-- Stessi blob della hero home --}}
    <div class="pointer-events-none absolute -top-40 -right-40 h-150 w-150 rounded-full bg-amber-400/20 blur-3xl dark:bg-amber-500/10" aria-hidden="true"></div>
    <div class="pointer-events-none absolute -bottom-40 -left-40 h-125 w-125 rounded-full bg-amber-300/20 blur-3xl dark:bg-amber-600/10" aria-hidden="true"></div>

    <div class="relative mx-auto max-w-3xl px-4 text-center sm:px-6 lg:px-8">
        <h2 class="mb-4 text-3xl font-extrabold tracking-tight text-gray-900 dark:text-white sm:text-4xl">
            Pronti a trasformare il vostro supporto?
        </h2>
        <p class="mb-8 text-base leading-relaxed text-gray-600 dark:text-gray-400">
            Mostriamo a te e al tuo team come TicketFlow si integra nel vostro flusso di lavoro in meno di 30 minuti. Demo gratuita, nessun impegno.
        </p>
        <div class="flex flex-col items-center justify-center gap-4 sm:flex-row">
            <a href="{{ route('contattaci') }}" class="rounded-xl bg-amber-500 px-10 py-4 text-base font-bold text-white shadow-lg shadow-amber-500/30 transition hover:bg-amber-600">
                Richiedi la demo gratuita →
            </a>
            <a href="{{ route('home') }}" class="rounded-xl border-2 border-amber-500 px-10 py-4 text-base font-semibold text-amber-600 transition hover:bg-amber-50 dark:text-amber-400 dark:hover:bg-amber-900/20">
                Torna alla home
            </a>
        </div>
    </div>
</section>

@endsection

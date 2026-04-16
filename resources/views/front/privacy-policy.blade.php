@extends('layouts.front')

@section('title', 'Privacy Policy — TicketFlow')
@section('description', 'Informativa sul trattamento dei dati personali di TicketFlow ai sensi del GDPR.')

@section('content')

<section class="bg-linear-to-br from-amber-50 via-white to-gray-50 py-12 border-t border-gray-100 pt-28 lg:pt-32">
    <div class="max-w-5xl mx-auto px-6">

        {{-- Header --}}
        <div class="mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-3">Privacy Policy</h1>
            <p class="text-gray-500">Ultimo aggiornamento: {{ date('d/m/Y') }}</p>
        </div>

        {{-- Card --}}
        <div class="bg-white rounded-2xl shadow-2xl border border-gray-100 p-10 md:p-14">

            <div class="space-y-10 text-gray-700 leading-relaxed">

                <div>
                    <h2 class="text-xl font-semibold text-gray-900 mb-2">1. Titolare del trattamento</h2>
                    <p>
                        Il titolare del trattamento è <strong>Guillermo Portesi</strong>, contattabile all'indirizzo email:
                        <a href="mailto:gportesi@gmail.com" class="text-amber-600 hover:underline">gportesi@gmail.com</a>.
                    </p>
                </div>

                <div>
                    <h2 class="text-xl font-semibold text-gray-900 mb-2">2. Natura del sito</h2>
                    <p>
                        TicketFlow è una <strong>piattaforma di gestione ticket B2B</strong> in fase di presentazione commerciale. Il sito pubblico consente ai potenziali clienti di richiedere informazioni e una demo tramite il modulo di contatto.
                    </p>
                    <p class="mt-3 text-sm text-gray-500">
                        Nota: i dati presenti nell'area riservata (utenti, aziende, ticket) sono generati a scopo dimostrativo e non appartengono a persone fisiche reali.
                    </p>
                </div>

                <div>
                    <h2 class="text-xl font-semibold text-gray-900 mb-2">3. Accesso alla piattaforma</h2>
                    <p>
                        La piattaforma <strong>non prevede registrazione pubblica</strong>. L'accesso all'area riservata è riservato agli utenti creati dall'amministratore del sistema.
                    </p>
                    <p class="mt-3">
                        I visitatori del sito pubblico possono navigare liberamente senza fornire alcun dato personale. Il modulo di contatto è <strong>facoltativo</strong>: i dati vengono forniti solo su iniziativa volontaria dell'utente che desidera ricevere informazioni o richiedere una demo.
                    </p>
                </div>

                <div>
                    <h2 class="text-xl font-semibold text-gray-900 mb-2">4. Tipologia di dati trattati</h2>
                    <p>Il sito tratta le seguenti categorie di dati:</p>
                    <ul class="list-disc pl-6 mt-2 space-y-2">
                        <li>
                            <strong>Dati tecnici di navigazione</strong> – indirizzo IP, tipo di browser, pagine visitate, timestamp delle richieste HTTP (log del server web).
                        </li>
                        <li>
                            <strong>Dati forniti volontariamente tramite il modulo di contatto</strong>:
                            <ul class="list-disc pl-6 mt-1 space-y-1 text-sm">
                                <li>Nome e cognome</li>
                                <li>Indirizzo email aziendale</li>
                                <li>Nome dell'azienda (facoltativo)</li>
                                <li>Numero di telefono (facoltativo)</li>
                                <li>Testo libero del messaggio</li>
                            </ul>
                        </li>
                    </ul>
                    <p class="mt-3 text-sm text-gray-500">
                        Il sito non raccoglie dati particolari (ex art. 9 GDPR) né dati giudiziari (ex art. 10 GDPR).
                    </p>
                </div>

                <div>
                    <h2 class="text-xl font-semibold text-gray-900 mb-2">5. Finalità del trattamento</h2>
                    <p><strong>Dati tecnici di navigazione</strong> — trattati per:</p>
                    <ul class="list-disc pl-6 mt-2 space-y-1">
                        <li>garantire la sicurezza e il corretto funzionamento del server;</li>
                        <li>rilevare e prevenire eventuali abusi o accessi non autorizzati;</li>
                        <li>diagnosticare errori tecnici.</li>
                    </ul>
                    <p class="mt-4"><strong>Dati del modulo di contatto</strong> — trattati per:</p>
                    <ul class="list-disc pl-6 mt-2 space-y-1">
                        <li>rispondere alla richiesta di informazioni inviata dall'utente;</li>
                        <li>organizzare e condurre una demo personalizzata del servizio;</li>
                        <li>fornire informazioni commerciali su TicketFlow su esplicita richiesta.</li>
                    </ul>
                    <p class="mt-3 text-sm text-gray-500">
                        I dati del modulo di contatto non vengono utilizzati per attività di marketing non richiesto, profilazione o cessione a terzi a fini commerciali.
                    </p>
                </div>

                <div>
                    <h2 class="text-xl font-semibold text-gray-900 mb-2">6. Base giuridica</h2>
                    <ul class="list-disc pl-6 mt-2 space-y-2">
                        <li>
                            <strong>Dati tecnici di navigazione</strong> — <em>interesse legittimo</em> del titolare (art. 6.1.f GDPR) per garantire la sicurezza del servizio e risolvere problemi tecnici.
                        </li>
                        <li>
                            <strong>Dati del modulo di contatto</strong> — <em>consenso esplicito</em> dell'interessato (art. 6.1.a GDPR), prestato tramite la spunta obbligatoria al momento dell'invio del modulo. Il consenso può essere revocato in qualsiasi momento scrivendo a <a href="mailto:gportesi@gmail.com" class="text-amber-600 hover:underline">gportesi@gmail.com</a>.
                        </li>
                    </ul>
                </div>

                <div>
                    <h2 class="text-xl font-semibold text-gray-900 mb-2">7. Conservazione dei dati</h2>
                    <ul class="list-disc pl-6 mt-2 space-y-2">
                        <li>
                            <strong>Log tecnici</strong> — conservati per un massimo di <strong>7 giorni</strong>, poi eliminati definitivamente. In caso di indagini su violazioni di sicurezza, non oltre 30 giorni.
                        </li>
                        <li>
                            <strong>Dati del modulo di contatto</strong> — conservati per il tempo necessario a gestire la richiesta e, in caso di avvio di una trattativa commerciale, per tutta la durata della stessa e fino a <strong>12 mesi</strong> dall'ultimo contatto. Trascorso tale termine, i dati vengono eliminati salvo obbligo di legge.
                        </li>
                    </ul>
                </div>

                <div>
                    <h2 class="text-xl font-semibold text-gray-900 mb-2">8. Destinatari dei dati e trasferimenti extra-UE</h2>
                    <p>I dati non vengono comunicati a terzi, salvo:</p>
                    <ul class="list-disc pl-6 mt-2 space-y-1">
                        <li><strong>Fornitori di servizi tecnici (hosting)</strong> – che agiscono come responsabili del trattamento ai sensi dell'art. 28 GDPR.</li>
                        <li><strong>Autorità giudiziarie o di pubblica sicurezza</strong> – solo in caso di obbligo di legge o richiesta ufficiale.</li>
                    </ul>
                    <p class="mt-3">
                        Il sito è ospitato su <strong>DominiOK</strong>, che può trasferire dati tecnici (log) verso paesi extra-UE esclusivamente sulla base di <strong>clausole contrattuali standard</strong> approvate dalla Commissione Europea o di <strong>decisioni di adeguatezza</strong>.
                    </p>
                </div>

                <div>
                    <h2 class="text-xl font-semibold text-gray-900 mb-2">9. Modalità di trattamento</h2>
                    <p>
                        I dati sono trattati con strumenti informatici, nel rispetto dei principi di liceità, correttezza e trasparenza. Sono adottate misure di sicurezza adeguate (crittografia delle connessioni TLS, accesso limitato ai soli amministratori).
                    </p>
                    <p class="mt-3 text-sm text-gray-500">
                        Nonostante le misure adottate, nessun sistema informatico può considerarsi completamente sicuro. L'uso del servizio è a rischio dell'utente.
                    </p>
                </div>

                <div>
                    <h2 class="text-xl font-semibold text-gray-900 mb-2">10. Diritti dell'interessato</h2>
                    <p>In qualità di interessato, l'utente può esercitare i seguenti diritti previsti dal GDPR (artt. 15-22):</p>
                    <ul class="list-disc pl-6 mt-2 space-y-1">
                        <li><strong>Accesso</strong> – ottenere conferma dell'esistenza dei propri dati e copia degli stessi.</li>
                        <li><strong>Rettifica</strong> – correggere dati inesatti.</li>
                        <li><strong>Cancellazione (diritto all'oblio)</strong> – ottenere la cancellazione dei propri dati.</li>
                        <li><strong>Limitazione</strong> – ottenere la limitazione del trattamento in determinati casi.</li>
                        <li><strong>Opposizione</strong> – opporsi al trattamento basato su interesse legittimo.</li>
                        <li><strong>Portabilità</strong> – ricevere i dati in formato strutturato (dove tecnicamente possibile).</li>
                    </ul>
                    <p class="mt-3">
                        Per esercitare i tuoi diritti, scrivi a <a href="mailto:gportesi@gmail.com" class="text-amber-600 hover:underline">gportesi@gmail.com</a>. Risponderemo entro 30 giorni.
                    </p>
                    <p class="mt-3">
                        Se ritieni che il trattamento dei tuoi dati violi il GDPR, hai il diritto di proporre reclamo all'<strong>Autorità Garante per la protezione dei dati personali</strong>
                        (<a href="https://www.garanteprivacy.it" target="_blank" rel="noopener noreferrer" class="text-amber-600 hover:underline">www.garanteprivacy.it</a>).
                    </p>
                </div>

                <div>
                    <h2 class="text-xl font-semibold text-gray-900 mb-2">11. Cookie e tecnologie simili</h2>
                    <p>
                        Il sito utilizza esclusivamente <strong>cookie tecnici</strong> necessari al funzionamento della piattaforma (es. gestione della sessione autenticata). Questi cookie non richiedono il consenso dell'utente ai sensi del provvedimento del Garante italiano dell'8 maggio 2014.
                    </p>
                    <p class="mt-3">
                        <strong>Non vengono utilizzati cookie di profilazione, tracciamento o marketing di alcun tipo.</strong>
                    </p>
                    <p class="mt-3 text-sm text-gray-500">
                        Puoi disabilitare i cookie tecnici dalle impostazioni del tuo browser, ma ciò potrebbe compromettere il funzionamento del sito.
                    </p>
                </div>

                <div>
                    <h2 class="text-xl font-semibold text-gray-900 mb-2">12. Modifiche alla presente informativa</h2>
                    <p>
                        La presente informativa può essere aggiornata per riflettere modifiche normative o organizzative. La versione aggiornata sarà pubblicata su questa pagina con la data di "Ultimo aggiornamento".
                    </p>
                </div>

                <div class="pt-4 border-t border-gray-200 text-sm text-gray-500">
                    <p>
                        Documento redatto in conformità al Regolamento (UE) 2016/679 (GDPR) e al D.Lgs. 30 giugno 2003, n. 196 come modificato dal D.Lgs. 10 agosto 2018, n. 101.
                    </p>
                </div>

            </div>
        </div>

        <div class="mt-10 text-center">
            <a href="{{ route('home') }}" class="text-sm font-semibold text-amber-600 underline underline-offset-4 transition hover:text-amber-700 dark:text-amber-400 dark:hover:text-amber-300">
                ← Torna alla homepage
            </a>
        </div>

    </div>
</section>

@endsection

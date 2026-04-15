@extends('layouts.front')

@section('title', 'Termini e Condizioni — TicketFlow')
@section('description', 'Termini e condizioni di utilizzo della piattaforma dimostrativa TicketFlow.')

@section('content')

<section class="bg-linear-to-br from-amber-50 via-white to-gray-50 py-12 border-t border-gray-100 pt-28 lg:pt-32">
    <div class="max-w-5xl mx-auto px-6">

        {{-- Header --}}
        <div class="mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-3">Termini e Condizioni</h1>
            <p class="text-gray-500">Ultimo aggiornamento: {{ date('d/m/Y') }}</p>
        </div>

        {{-- Card --}}
        <div class="bg-white rounded-2xl shadow-2xl border border-gray-100 p-10 md:p-14">

            <div class="space-y-10 text-gray-700 leading-relaxed">

                <div>
                    <h2 class="text-xl font-semibold text-gray-900 mb-2">1. Accettazione dei termini</h2>
                    <p>
                        L'accesso e l'utilizzo di questa piattaforma dimostrativa implicano l'accettazione integrale dei presenti Termini e Condizioni. Se non accetti questi termini, ti invitiamo a non utilizzare il servizio.
                    </p>
                    <p class="mt-3 text-sm text-gray-500">
                        L'uso continuativo del servizio costituisce accettazione tacita e rinnovata di questi termini.
                    </p>
                </div>

                <div>
                    <h2 class="text-xl font-semibold text-gray-900 mb-2">2. Oggetto</h2>
                    <p>
                        Il presente sito costituisce un ambiente dimostrativo ("demo") di una piattaforma di ticketing B2B per team di supporto, accessibile esclusivamente per finalità di test e valutazione delle funzionalità.
                    </p>
                </div>

                <div>
                    <h2 class="text-xl font-semibold text-gray-900 mb-2">3. Natura del servizio</h2>
                    <p class="font-medium text-amber-700">
                        ⚠️ Il servizio NON rappresenta una piattaforma operativa reale e non deve essere utilizzato per la gestione di ticket, richieste di assistenza o dati aziendali reali.
                    </p>
                    <p class="mt-2">
                        Non costituisce uno strumento di lavoro affidabile né sostituisce in alcun modo software professionali certificati per la gestione del supporto clienti.
                    </p>
                </div>

                <div>
                    <h2 class="text-xl font-semibold text-gray-900 mb-2">4. Obblighi dell'utente</h2>
                    <ul class="list-disc pl-6 mt-2 space-y-1">
                        <li>non inserire dati personali reali, sensibili, giudiziari o dati di terzi</li>
                        <li>utilizzare il servizio esclusivamente per scopi dimostrativi e di test</li>
                        <li>non utilizzare il sistema per finalità illecite, fraudolente o commerciali</li>
                        <li>non tentare di compromettere la sicurezza o il funzionamento della piattaforma</li>
                        <li>non eseguire test di carico, penetration test o scansioni automatiche senza autorizzazione scritta</li>
                        <li>non condividere le proprie credenziali di accesso con terzi</li>
                    </ul>
                </div>

                {{-- Divieto dati reali --}}
                <div class="bg-red-50 rounded-lg p-5 border-l-4 border-red-500">
                    <h2 class="text-lg font-semibold text-red-800 mb-2">🚫 5. Divieto assoluto di dati reali</h2>
                    <p class="text-red-700">È espressamente vietato inserire nella piattaforma:</p>
                    <ul class="list-disc pl-6 mt-2 space-y-1 text-red-700">
                        <li>nomi, cognomi o soprannomi reali</li>
                        <li>indirizzi email realmente utilizzati altrove</li>
                        <li>numeri di telefono, documenti d'identità, codici fiscali</li>
                        <li>password personali (riutilizzate da altri servizi)</li>
                        <li>dati bancari, carte di credito o informazioni finanziarie</li>
                        <li>dati di clienti, fornitori, aziende reali o terze parti</li>
                        <li>contenuti di ticket, conversazioni o allegati provenienti da ambienti di produzione reali</li>
                    </ul>
                    <p class="mt-3 font-bold text-red-800">
                        La violazione di questo divieto costituisce inadempimento grave e comporta la responsabilità esclusiva dell'utente per qualsiasi conseguenza, ivi inclusi danni a terzi o violazioni del GDPR.
                    </p>
                </div>

                <div>
                    <h2 class="text-xl font-semibold text-gray-900 mb-2">6. Limitazione di responsabilità</h2>
                    <p>
                        Il servizio è fornito <strong>"così com'è" (AS-IS)</strong> e <strong>"come disponibile" (AS-AVAILABLE)</strong>, senza garanzie di alcun tipo, esplicite o implicite, incluse ma non limitate a garanzie di commerciabilità, idoneità per uno scopo specifico o assenza di errori.
                    </p>
                    <p class="mt-3">Il titolare <strong>non è responsabile</strong> per:</p>
                    <ul class="list-disc pl-6 mt-2 space-y-1">
                        <li>danni diretti, indiretti, incidentali, consequenziali o punitivi</li>
                        <li>perdita di dati, mancati guadagni, interruzione di attività</li>
                        <li>accessi non autorizzati o violazioni della sicurezza</li>
                        <li>errori, omissioni o interruzioni del servizio</li>
                        <li>contenuti inseriti dagli utenti in violazione dei presenti termini</li>
                    </ul>
                    <p class="mt-3 text-sm text-gray-500">
                        In nessun caso la responsabilità del titolare potrà superare l'importo di € 100,00 (cento euro).
                    </p>
                </div>

                <div>
                    <h2 class="text-xl font-semibold text-gray-900 mb-2">7. Dati inseriti</h2>
                    <p>
                        Tutti i dati presenti nella piattaforma sono fittizi e generati automaticamente a scopo dimostrativo. Eventuali dati inseriti dagli utenti autorizzati vengono <strong>automaticamente cancellati entro 24 ore</strong> senza preavviso e senza possibilità di recupero.
                    </p>
                    <p class="mt-3">
                        Il titolare non ha alcun obbligo di conservazione, backup o ripristino dei dati inseriti.
                    </p>
                </div>

                <div>
                    <h2 class="text-xl font-semibold text-gray-900 mb-2">8. Accesso e sospensione</h2>
                    <p>Il titolare si riserva il diritto di:</p>
                    <ul class="list-disc pl-6 mt-2 space-y-1">
                        <li>limitare, sospendere o interrompere l'accesso al servizio in qualsiasi momento, senza preavviso</li>
                        <li>revocare le credenziali di accesso in caso di violazione dei presenti termini</li>
                        <li>bloccare indirizzi IP o reti abusive</li>
                    </ul>
                    <p class="mt-3">
                        Le sospensioni possono essere temporanee o definitive a insindacabile giudizio del titolare.
                    </p>
                </div>

                <div>
                    <h2 class="text-xl font-semibold text-gray-900 mb-2">9. Proprietà intellettuale</h2>
                    <p>
                        Il software, il codice sorgente, l'interfaccia, la struttura, i contenuti grafici, i marchi e tutti gli elementi presenti nel sito sono di proprietà esclusiva del titolare o dei suoi licenziatari e sono protetti dalle leggi italiane ed europee sul diritto d'autore e proprietà intellettuale.
                    </p>
                    <p class="mt-3">È vietato:</p>
                    <ul class="list-disc pl-6 mt-2 space-y-1">
                        <li>copiare, modificare, decompilare, decodificare o ingegnerizzare inversamente il software</li>
                        <li>estrarre, riutilizzare o rivendere qualsiasi parte del sito</li>
                        <li>creare opere derivate basate sulla piattaforma</li>
                    </ul>
                </div>

                <div>
                    <h2 class="text-xl font-semibold text-gray-900 mb-2">10. Modifiche del servizio e dei termini</h2>
                    <p>
                        Il servizio può essere modificato, aggiornato, limitato o interrotto in qualsiasi momento senza preavviso.
                    </p>
                    <p class="mt-3">
                        I presenti termini possono essere aggiornati periodicamente. La versione aggiornata sarà pubblicata su questa pagina con la data di "Ultimo aggiornamento". L'uso continuativo del servizio dopo le modifiche costituisce accettazione dei nuovi termini.
                    </p>
                </div>

                <div>
                    <h2 class="text-xl font-semibold text-gray-900 mb-2">11. Indennizzo</h2>
                    <p>
                        L'utente si impegna a manlevare, difendere e tenere indenne il titolare da qualsiasi richiesta, danno, perdita, costo o spesa (incluse le spese legali) derivanti da:
                    </p>
                    <ul class="list-disc pl-6 mt-2 space-y-1">
                        <li>violazione dei presenti termini da parte dell'utente</li>
                        <li>inserimento di dati personali reali in violazione del divieto espresso</li>
                        <li>utilizzo illecito o non autorizzato del servizio</li>
                        <li>violazione di diritti di terzi</li>
                    </ul>
                </div>

                <div>
                    <h2 class="text-xl font-semibold text-gray-900 mb-2">12. Legge applicabile e foro competente</h2>
                    <p>
                        I presenti termini sono regolati dalla <strong>legge italiana</strong> e dal <strong>Regolamento (UE) 2016/679 (GDPR)</strong> ove applicabile.
                    </p>
                    <p class="mt-3">
                        Per qualsiasi controversia relativa ai presenti termini o all'utilizzo del servizio, il <strong>foro esclusivo competente è quello di Ancona</strong> (Italia), fatte salve le disposizioni imperative del Codice del Consumo per gli utenti che agiscono in qualità di consumatori.
                    </p>
                </div>

                <div>
                    <h2 class="text-xl font-semibold text-gray-900 mb-2">13. Contatti</h2>
                    <p>
                        Per qualsiasi domanda relativa ai presenti Termini e Condizioni, puoi contattare il titolare all'indirizzo email:
                        <a href="mailto:gportesi@gmail.com" class="text-amber-600 hover:underline">gportesi@gmail.com</a>
                    </p>
                </div>

                <div class="pt-4 border-t border-gray-200 text-sm text-gray-500">
                    <p>
                        <strong>Riassunto per l'utente:</strong> Questo è un ambiente di test per una piattaforma di ticketing B2B. Non inserire dati reali. I dati vengono cancellati in 24 ore. Nessuna garanzia. Uso a proprio rischio.
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

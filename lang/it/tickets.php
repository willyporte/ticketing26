<?php

return [
    'label'        => 'Ticket',
    'plural_label' => 'Ticket',

    'fields' => [
        'title'         => 'Titolo',
        'description'   => 'Descrizione',
        'status'        => 'Stato',
        'priority'      => 'Priorità',
        'company'       => 'Azienda',
        'department'    => 'Reparto',
        'created_by'    => 'Creato da',
        'assigned_to'   => 'Assegnato a',
        'created_at'    => 'Creato il',
        'updated_at'    => 'Aggiornato il',
    ],

    'status' => [
        'open'           => 'Aperto',
        'in_progress'    => 'In lavorazione',
        'waiting_client' => 'In attesa del cliente',
        'resolved'       => 'Risolto',
        'closed'         => 'Chiuso',
    ],

    'priority' => [
        'low'    => 'Bassa',
        'medium' => 'Media',
        'high'   => 'Alta',
        'urgent' => 'Urgente',
    ],

    'actions' => [
        'create'         => 'Nuovo ticket',
        'edit'           => 'Modifica ticket',
        'delete'         => 'Elimina ticket',
        'close'          => 'Chiudi ticket',
        'reopen'         => 'Riapri ticket',
        'assign'         => 'Assegna',
        'take'           => 'Prendi in carico',
        'resolve'        => 'Segna come risolto',
        'waiting_client' => 'In attesa cliente',
        'resume'         => 'Riprendi lavorazione',
    ],

    'attachments' => [
        'label'        => 'Allegato',
        'plural_label' => 'Allegati',
        'filename'     => 'Nome file',
        'size'         => 'Dimensione',
        'uploaded_by'  => 'Caricato da',
        'uploaded_at'  => 'Caricato il',
        'download'     => 'Scarica',
        'delete'       => 'Elimina allegato',
        'add'          => 'Aggiungi allegato',
        'limit_reached'    => 'Limite raggiunto: massimo 10 allegati per ticket.',
        'size_exceeded'    => 'Il file supera il limite di 10 MB.',
        'invalid_type'     => 'Tipo di file non consentito.',
        'deleted'          => 'Allegato eliminato.',
    ],

    'replies' => [
        'label'        => 'Risposta',
        'plural_label' => 'Risposte',
        'body'         => 'Messaggio',
        'add'          => 'Aggiungi risposta',
        'created'      => 'Risposta inviata con successo.',
        'deleted'      => 'Risposta eliminata.',
    ],

    'navigation' => [
        'group'  => 'Supporto',
        'sort'   => 1,
    ],

    'sections' => [
        'details'     => 'Dettagli',
        'assignment'  => 'Assegnazione',
        'replies'     => 'Conversazione',
        'attachments' => 'Allegati',
        'time'        => 'Tempo lavorato',
    ],

    'filters' => [
        'status'      => 'Filtra per stato',
        'priority'    => 'Filtra per priorità',
        'assigned_to' => 'Filtra per operatore',
        'company'     => 'Filtra per azienda',
        'department'  => 'Filtra per reparto',
    ],

    'dashboard' => [
        'open'           => 'Ticket aperti',
        'in_progress'    => 'In lavorazione',
        'waiting_client' => 'In attesa cliente',
        'resolved'       => 'Risolti',
        'closed'         => 'Chiusi',
        'unassigned'     => 'Senza operatore',
        'recent'         => 'Ultimi ticket',
        'my_tickets'     => 'I miei ticket',
        'my_assigned'    => 'Assegnati a me',
    ],

    'messages' => [
        'created'        => 'Ticket creato con successo.',
        'updated'        => 'Ticket aggiornato con successo.',
        'deleted'        => 'Ticket eliminato con successo.',
        'closed'         => 'Ticket chiuso con successo.',
        'reopened'       => 'Ticket riaperto con successo.',
        'resolved'       => 'Ticket segnato come risolto.',
        'assigned'       => 'Ticket assegnato con successo.',
        'taken'          => 'Ticket preso in carico.',
        'waiting_client' => 'Ticket in attesa di risposta dal cliente.',
        'resumed'        => 'Lavorazione ripresa.',

        'subscription_exhausted' => 'Il tuo abbonamento è esaurito o non attivo. Contatta il supporto per rinnovare o acquistare minuti extra.',
        'minutes_warning'        => 'Attenzione: i minuti residui di questa azienda sono quasi esauriti.',
        'minutes_negative'       => 'Attenzione: i minuti residui di questa azienda sono negativi (lavoro extra non coperto dal contratto).',
    ],
];

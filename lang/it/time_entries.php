<?php

return [
    'label'        => 'Registrazione tempo',
    'plural_label' => 'Registrazioni tempo',

    'fields' => [
        'ticket'        => 'Ticket',
        'user'          => 'Operatore',
        'minutes_spent' => 'Minuti lavorati',
        'notes'         => 'Note',
        'created_at'    => 'Registrato il',
        'updated_at'    => 'Aggiornato il',
    ],

    'hints' => [
        'available'       => 'Minuti disponibili: :minutes',
        'no_subscription' => 'Nessun abbonamento attivo',
    ],

    'navigation' => [
        'group' => 'Supporto',
        'sort'  => 2,
    ],

    'filters' => [
        'ticket' => 'Filtra per ticket',
        'user'   => 'Filtra per operatore',
    ],

    'dashboard' => [
        'total_minutes' => 'Minuti totali registrati',
        'my_minutes'    => 'Miei minuti registrati',
    ],

    'export' => [
        'ticket_title'  => 'Titolo ticket',
        'operator'      => 'Operatore',
        'minutes_spent' => 'Minuti lavorati',
        'notes'         => 'Note',
        'date'          => 'Data',
    ],

    'actions' => [
        'create' => 'Nuova registrazione',
        'edit'   => 'Modifica registrazione',
        'delete' => 'Elimina registrazione',
        'export' => 'Esporta CSV',
    ],

    'export' => [
        'completed' => 'Export registrazioni completato: :count righe esportate.',
    ],

    'messages' => [
        'created' => 'Tempo registrato con successo.',
        'updated' => 'Registrazione aggiornata con successo.',
        'deleted' => 'Registrazione eliminata con successo.',
    ],
];

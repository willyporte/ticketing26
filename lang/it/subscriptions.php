<?php

return [
    // ── Plan ──────────────────────────────────────────────────────────────────
    'plan' => [
        'label'        => 'Piano',
        'plural_label' => 'Piani',

        'fields' => [
            'name'          => 'Nome piano',
            'total_minutes' => 'Minuti totali',
            'validity_days' => 'Validità (giorni)',
            'price'         => 'Prezzo (€)',
        ],

        'actions' => [
            'create' => 'Nuovo piano',
            'edit'   => 'Modifica piano',
            'delete' => 'Elimina piano',
        ],

        'messages' => [
            'created' => 'Piano creato con successo.',
            'updated' => 'Piano aggiornato con successo.',
            'deleted' => 'Piano eliminato con successo.',
        ],
    ],

    // ── Subscription ──────────────────────────────────────────────────────────
    'navigation' => [
        'group' => 'Amministrazione',
        'sort'  => 5,
    ],

    'label'        => 'Abbonamento',
    'plural_label' => 'Abbonamenti',

    'fields' => [
        'company'           => 'Azienda',
        'plan'              => 'Piano',
        'minutes_remaining' => 'Minuti residui',
        'starts_at'         => 'Data inizio',
        'expires_at'        => 'Data scadenza',
    ],

    'status' => [
        'active'  => 'Attivo',
        'expired' => 'Scaduto',
    ],

    'actions' => [
        'create' => 'Nuovo abbonamento',
        'edit'   => 'Modifica abbonamento',
        'delete' => 'Elimina abbonamento',
    ],

    'messages' => [
        'created' => 'Abbonamento creato con successo.',
        'updated' => 'Abbonamento aggiornato con successo.',
        'deleted' => 'Abbonamento eliminato con successo.',

        'warning_low_minutes'    => 'Attenzione: i minuti residui sono sotto il 20% del piano.',
        'minutes_exhausted'      => 'Attenzione: i minuti di questa azienda sono esauriti. Il lavoro prosegue ma i minuti sono negativi.',
        'no_active_subscription' => 'Nessun abbonamento attivo.',
        'client_blocked'         => 'Il tuo abbonamento è esaurito o non attivo. Contatta il supporto per rinnovare o acquistare minuti extra.',
    ],
];

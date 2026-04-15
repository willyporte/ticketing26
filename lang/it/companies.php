<?php

return [
    'label'        => 'Azienda',
    'plural_label' => 'Aziende',

    'fields' => [
        'name'        => 'Ragione sociale',
        'vat_number'  => 'Partita IVA',
        'email'       => 'Email',
        'phone'       => 'Telefono',
        'logo'        => 'Logo',
        'users_count' => 'Utenti',
        'created_at'  => 'Creata il',
        'updated_at'  => 'Aggiornata il',
    ],

    'navigation' => [
        'group' => 'Amministrazione',
        'sort'  => 1,
    ],

    'sections' => [
        'info'  => 'Dati aziendali',
        'logo'  => 'Logo',
        'users' => 'Utenti',
    ],

    'dashboard' => [
        'minutes_remaining' => 'Minuti residui',
        'expires_at'        => 'Scade il',
        'no_subscription'   => 'Nessun abbonamento attivo',
        'warning_threshold' => '⚠ Minuti in esaurimento',
    ],

    'actions' => [
        'create' => 'Nuova azienda',
        'edit'   => 'Modifica azienda',
        'delete' => 'Elimina azienda',
        'export' => 'Esporta CSV',
    ],

    'export' => [
        'completed' => 'Export aziende completato: :count righe esportate.',
    ],

    'messages' => [
        'created' => 'Azienda creata con successo.',
        'updated' => 'Azienda aggiornata con successo.',
        'deleted' => 'Azienda eliminata con successo.',
    ],
];

<?php

return [
    'label'        => 'Piano',
    'plural_label' => 'Piani',

    'fields' => [
        'name'           => 'Nome',
        'total_minutes'  => 'Minuti totali',
        'validity_days'  => 'Validità (giorni)',
        'price'          => 'Prezzo (€)',
        'subscriptions_count' => 'Abbonamenti attivi',
        'created_at'     => 'Creato il',
        'updated_at'     => 'Aggiornato il',
    ],

    'navigation' => [
        'group' => 'Amministrazione',
        'sort'  => 2,
    ],

    'sections' => [
        'details' => 'Dettagli piano',
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
];

<?php

return [
    'label'        => 'Reparto',
    'plural_label' => 'Reparti',

    'fields' => [
        'name'       => 'Nome',
        'created_at' => 'Creato il',
        'updated_at' => 'Aggiornato il',
    ],

    'navigation' => [
        'group' => 'Amministrazione',
        'sort'  => 5,
    ],

    'actions' => [
        'create' => 'Nuovo reparto',
        'edit'   => 'Modifica reparto',
        'delete' => 'Elimina reparto',
    ],

    'messages' => [
        'created' => 'Reparto creato con successo.',
        'updated' => 'Reparto aggiornato con successo.',
        'deleted' => 'Reparto eliminato con successo.',
    ],
];

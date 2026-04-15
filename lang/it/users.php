<?php

return [
    'label'        => 'Utente',
    'plural_label' => 'Utenti',

    'fields' => [
        'name'                      => 'Nome',
        'email'                     => 'Email',
        'password'                  => 'Password',
        'password_confirmation'     => 'Conferma password',
        'role'                      => 'Ruolo',
        'company'                   => 'Azienda',
        'can_view_company_tickets'  => 'Vede tutti i ticket aziendali',
        'created_at'                => 'Creato il',
        'updated_at'                => 'Aggiornato il',
        'password_hint_edit'        => 'Lascia vuoto per non modificare',
        'avatar'                    => 'Foto profilo',
    ],

    'roles' => [
        'administrator' => 'Amministratore',
        'supervisor'    => 'Supervisore',
        'operator'      => 'Operatore',
        'client'        => 'Cliente',
    ],

    'navigation' => [
        'group' => 'Amministrazione',
        'sort'  => 2,
    ],

    'sections' => [
        'personal'    => 'Dati personali',
        'access'      => 'Accesso e ruolo',
        'permissions' => 'Permessi',
    ],

    'filters' => [
        'role'    => 'Filtra per ruolo',
        'company' => 'Filtra per azienda',
    ],

    'actions' => [
        'create' => 'Nuovo utente',
        'edit'   => 'Modifica utente',
        'delete' => 'Elimina utente',
        'export' => 'Esporta CSV',
    ],

    'export' => [
        'completed' => 'Export utenti completato: :count righe esportate.',
    ],

    'messages' => [
        'created' => 'Utente creato con successo.',
        'updated' => 'Utente aggiornato con successo.',
        'deleted' => 'Utente eliminato con successo.',
    ],
];

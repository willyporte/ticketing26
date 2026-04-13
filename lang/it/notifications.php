<?php

return [
    'label'        => 'Notifica',
    'plural_label' => 'Notifiche',

    // ── Ticket creato ─────────────────────────────────────────────────────────
    'ticket_created' => [
        'subject' => 'Nuovo ticket: :title',
        'title'   => 'Nuovo ticket aperto',
        'body'    => 'È stato aperto un nuovo ticket: ":title" da :creator (Azienda: :company).',
    ],

    // ── Ticket assegnato ──────────────────────────────────────────────────────
    'ticket_assigned' => [
        'subject' => 'Ticket assegnato a te: :title',
        'title'   => 'Ticket assegnato',
        'body'    => 'Il ticket ":title" ti è stato assegnato.',
    ],

    // ── Nuova reply ───────────────────────────────────────────────────────────
    'ticket_reply_added' => [
        'subject' => 'Nuova risposta su: :title',
        'title'   => 'Nuova risposta',
        'body'    => ':author ha aggiunto una risposta al ticket ":title".',
    ],

    // ── Nuovo allegato ────────────────────────────────────────────────────────
    'ticket_attachment_added' => [
        'subject' => 'Nuovo allegato su: :title',
        'title'   => 'Nuovo allegato',
        'body'    => ':author ha allegato un file al ticket ":title".',
    ],

    // ── Ticket risolto ────────────────────────────────────────────────────────
    'ticket_resolved' => [
        'subject' => 'Ticket risolto: :title',
        'title'   => 'Il tuo ticket è stato risolto',
        'body'    => 'Il ticket ":title" è stato segnato come risolto. Puoi riaprirlo se il problema persiste.',
    ],

    // ── Ticket riaperto ───────────────────────────────────────────────────────
    'ticket_reopened' => [
        'subject' => 'Ticket riaperto: :title',
        'title'   => 'Ticket riaperto',
        'body'    => 'Il ticket ":title" è stato riaperto da :author.',
    ],

    // ── Minuti subscription sotto soglia 20% ─────────────────────────────────
    'subscription_low_minutes' => [
        'subject' => 'Attenzione: minuti in esaurimento per :company',
        'title'   => 'Minuti residui in esaurimento',
        'body'    => 'L\'azienda ":company" ha raggiunto meno del 20% dei minuti residui (:remaining minuti rimasti su :total totali).',
    ],

    // ── Azioni comuni ─────────────────────────────────────────────────────────
    'actions' => [
        'view_ticket'    => 'Visualizza ticket',
        'mark_all_read'  => 'Segna tutte come lette',
    ],
];

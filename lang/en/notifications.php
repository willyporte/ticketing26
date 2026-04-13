<?php

// TODO: traduzioni inglesi — post-MVP
return [
    'label'        => 'Notification',
    'plural_label' => 'Notifications',

    'ticket_created' => [
        'subject' => 'New ticket: :title',
        'title'   => 'New ticket opened',
        'body'    => 'A new ticket has been opened: ":title" by :creator (Company: :company).',
    ],

    'ticket_assigned' => [
        'subject' => 'Ticket assigned to you: :title',
        'title'   => 'Ticket assigned',
        'body'    => 'The ticket ":title" has been assigned to you.',
    ],

    'ticket_reply_added' => [
        'subject' => 'New reply on: :title',
        'title'   => 'New reply',
        'body'    => ':author added a reply to ticket ":title".',
    ],

    'ticket_attachment_added' => [
        'subject' => 'New attachment on: :title',
        'title'   => 'New attachment',
        'body'    => ':author attached a file to ticket ":title".',
    ],

    'ticket_resolved' => [
        'subject' => 'Ticket resolved: :title',
        'title'   => 'Your ticket has been resolved',
        'body'    => 'The ticket ":title" has been marked as resolved. You can reopen it if the issue persists.',
    ],

    'ticket_reopened' => [
        'subject' => 'Ticket reopened: :title',
        'title'   => 'Ticket reopened',
        'body'    => 'The ticket ":title" has been reopened by :author.',
    ],

    'subscription_low_minutes' => [
        'subject' => 'Warning: minutes running low for :company',
        'title'   => 'Remaining minutes running low',
        'body'    => 'Company ":company" has less than 20% of minutes remaining (:remaining minutes left out of :total total).',
    ],

    'actions' => [
        'view_ticket'    => 'View ticket',
        'mark_all_read'  => 'Mark all as read',
    ],
];

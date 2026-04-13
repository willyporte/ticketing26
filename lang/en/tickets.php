<?php

// TODO: traduzioni inglesi — post-MVP
return [
    'label'        => 'Ticket',
    'plural_label' => 'Tickets',

    'fields' => [
        'title'         => 'Title',
        'description'   => 'Description',
        'status'        => 'Status',
        'priority'      => 'Priority',
        'company'       => 'Company',
        'department'    => 'Department',
        'created_by'    => 'Created by',
        'assigned_to'   => 'Assigned to',
        'created_at'    => 'Created at',
        'updated_at'    => 'Updated at',
    ],

    'status' => [
        'open'           => 'Open',
        'in_progress'    => 'In progress',
        'waiting_client' => 'Waiting for client',
        'resolved'       => 'Resolved',
        'closed'         => 'Closed',
    ],

    'priority' => [
        'low'    => 'Low',
        'medium' => 'Medium',
        'high'   => 'High',
        'urgent' => 'Urgent',
    ],

    'actions' => [
        'create'   => 'New ticket',
        'edit'     => 'Edit ticket',
        'delete'   => 'Delete ticket',
        'close'    => 'Close ticket',
        'reopen'   => 'Reopen ticket',
        'assign'   => 'Assign',
        'take'     => 'Take charge',
        'resolve'  => 'Mark as resolved',
    ],

    'attachments' => [
        'label'        => 'Attachment',
        'plural_label' => 'Attachments',
        'filename'     => 'Filename',
        'size'         => 'Size',
        'uploaded_by'  => 'Uploaded by',
        'uploaded_at'  => 'Uploaded at',
        'download'     => 'Download',
        'delete'       => 'Delete attachment',
        'add'          => 'Add attachment',
        'limit_reached'    => 'Limit reached: maximum 10 attachments per ticket.',
        'size_exceeded'    => 'File exceeds the 10 MB limit.',
        'invalid_type'     => 'File type not allowed.',
        'deleted'          => 'Attachment deleted.',
    ],

    'replies' => [
        'label'        => 'Reply',
        'plural_label' => 'Replies',
        'body'         => 'Message',
        'add'          => 'Add reply',
        'created'      => 'Reply sent successfully.',
        'deleted'      => 'Reply deleted.',
    ],

    'navigation' => [
        'group' => 'Support',
        'sort'  => 1,
    ],

    'sections' => [
        'details'     => 'Details',
        'assignment'  => 'Assignment',
        'replies'     => 'Conversation',
        'attachments' => 'Attachments',
        'time'        => 'Time logged',
    ],

    'filters' => [
        'status'      => 'Filter by status',
        'priority'    => 'Filter by priority',
        'assigned_to' => 'Filter by operator',
        'company'     => 'Filter by company',
        'department'  => 'Filter by department',
    ],

    'dashboard' => [
        'open'           => 'Open tickets',
        'in_progress'    => 'In progress',
        'waiting_client' => 'Waiting for client',
        'resolved'       => 'Resolved',
        'closed'         => 'Closed',
        'unassigned'     => 'No operator assigned',
        'recent'         => 'Recent tickets',
        'my_tickets'     => 'My tickets',
        'my_assigned'    => 'Assigned to me',
    ],

    'messages' => [
        'created'  => 'Ticket created successfully.',
        'updated'  => 'Ticket updated successfully.',
        'deleted'  => 'Ticket deleted successfully.',
        'closed'   => 'Ticket closed successfully.',
        'reopened' => 'Ticket reopened successfully.',
        'resolved' => 'Ticket marked as resolved.',
        'assigned' => 'Ticket assigned successfully.',

        'subscription_exhausted' => 'Your subscription is exhausted or inactive. Please contact support to renew or purchase extra minutes.',
        'minutes_warning'        => 'Warning: this company\'s remaining minutes are almost exhausted.',
        'minutes_negative'       => 'Warning: this company\'s remaining minutes are negative (extra work not covered by contract).',
    ],
];

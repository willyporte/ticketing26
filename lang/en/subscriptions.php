<?php

// TODO: traduzioni inglesi — post-MVP
return [
    'plan' => [
        'label'        => 'Plan',
        'plural_label' => 'Plans',

        'fields' => [
            'name'          => 'Plan name',
            'total_minutes' => 'Total minutes',
            'validity_days' => 'Validity (days)',
            'price'         => 'Price (€)',
        ],

        'actions' => [
            'create' => 'New plan',
            'edit'   => 'Edit plan',
            'delete' => 'Delete plan',
        ],

        'messages' => [
            'created' => 'Plan created successfully.',
            'updated' => 'Plan updated successfully.',
            'deleted' => 'Plan deleted successfully.',
        ],
    ],

    'label'        => 'Subscription',
    'plural_label' => 'Subscriptions',

    'fields' => [
        'company'           => 'Company',
        'plan'              => 'Plan',
        'minutes_remaining' => 'Remaining minutes',
        'starts_at'         => 'Start date',
        'expires_at'        => 'Expiry date',
    ],

    'status' => [
        'active'  => 'Active',
        'expired' => 'Expired',
    ],

    'actions' => [
        'create' => 'New subscription',
        'edit'   => 'Edit subscription',
        'delete' => 'Delete subscription',
    ],

    'messages' => [
        'created' => 'Subscription created successfully.',
        'updated' => 'Subscription updated successfully.',
        'deleted' => 'Subscription deleted successfully.',

        'warning_low_minutes'    => 'Warning: remaining minutes are below 20% of the plan.',
        'minutes_exhausted'      => 'Subscription minutes are exhausted.',
        'no_active_subscription' => 'No active subscription.',
    ],
];

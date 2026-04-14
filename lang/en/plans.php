<?php

// TODO: traduzioni inglesi — post-MVP
return [
    'label'        => 'Plan',
    'plural_label' => 'Plans',

    'fields' => [
        'name'                => 'Name',
        'total_minutes'       => 'Total minutes',
        'validity_days'       => 'Validity (days)',
        'price'               => 'Price (€)',
        'subscriptions_count' => 'Active subscriptions',
        'created_at'          => 'Created at',
        'updated_at'          => 'Updated at',
    ],

    'navigation' => [
        'group' => 'Administration',
        'sort'  => 2,
    ],

    'sections' => [
        'details' => 'Plan details',
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
];

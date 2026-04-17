<?php

use App\Models\TicketAttachment;

test('formattedSize mostra bytes se sotto 1 KB', function () {
    $att = new TicketAttachment(['size' => 512]);
    expect($att->formattedSize())->toBe('512 B');
});

test('formattedSize mostra KB se sotto 1 MB', function () {
    $att = new TicketAttachment(['size' => 2_048]);
    expect($att->formattedSize())->toBe('2 KB');
});

test('formattedSize mostra MB se 1 MB o superiore', function () {
    $att = new TicketAttachment(['size' => 2_097_152]);
    expect($att->formattedSize())->toBe('2 MB');
});

test('formattedSize arrotonda a 1 decimale', function () {
    $att = new TicketAttachment(['size' => 1_536]);
    expect($att->formattedSize())->toBe('1.5 KB');
});

test('formattedSize con esattamente 1 MB', function () {
    $att = new TicketAttachment(['size' => 1_048_576]);
    expect($att->formattedSize())->toBe('1 MB');
});

test('formattedSize con esattamente 1 KB', function () {
    $att = new TicketAttachment(['size' => 1_024]);
    expect($att->formattedSize())->toBe('1 KB');
});

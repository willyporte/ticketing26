<?php

use App\Enums\TicketStatus;

test('ogni stato ha un colore Filament corretto', function () {
    expect(TicketStatus::Open->color())->toBe('info');
    expect(TicketStatus::InProgress->color())->toBe('warning');
    expect(TicketStatus::WaitingClient->color())->toBe('gray');
    expect(TicketStatus::Resolved->color())->toBe('success');
    expect(TicketStatus::Closed->color())->toBe('danger');
});

test('ogni stato ha un valore stringa corretto', function () {
    expect(TicketStatus::Open->value)->toBe('open');
    expect(TicketStatus::InProgress->value)->toBe('in_progress');
    expect(TicketStatus::WaitingClient->value)->toBe('waiting_client');
    expect(TicketStatus::Resolved->value)->toBe('resolved');
    expect(TicketStatus::Closed->value)->toBe('closed');
});

test('from stringa restituisce il case corretto', function () {
    expect(TicketStatus::from('open'))->toBe(TicketStatus::Open);
    expect(TicketStatus::from('in_progress'))->toBe(TicketStatus::InProgress);
    expect(TicketStatus::from('closed'))->toBe(TicketStatus::Closed);
});

test('tutti i casi sono presenti', function () {
    expect(TicketStatus::cases())->toHaveCount(5);
});

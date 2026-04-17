<?php

use App\Enums\TicketPriority;

test('ogni priorità ha un colore Filament corretto', function () {
    expect(TicketPriority::Low->color())->toBe('gray');
    expect(TicketPriority::Medium->color())->toBe('info');
    expect(TicketPriority::High->color())->toBe('warning');
    expect(TicketPriority::Urgent->color())->toBe('danger');
});

test('ogni priorità ha un valore stringa corretto', function () {
    expect(TicketPriority::Low->value)->toBe('low');
    expect(TicketPriority::Medium->value)->toBe('medium');
    expect(TicketPriority::High->value)->toBe('high');
    expect(TicketPriority::Urgent->value)->toBe('urgent');
});

test('from stringa restituisce il case corretto', function () {
    expect(TicketPriority::from('low'))->toBe(TicketPriority::Low);
    expect(TicketPriority::from('urgent'))->toBe(TicketPriority::Urgent);
});

test('tutti i casi sono presenti', function () {
    expect(TicketPriority::cases())->toHaveCount(4);
});

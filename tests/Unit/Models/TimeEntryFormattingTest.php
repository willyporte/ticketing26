<?php

use App\Models\TimeEntry;

test('formattedDuration mostra solo minuti se sotto un\'ora', function () {
    $entry = new TimeEntry(['minutes_spent' => 45]);
    expect($entry->formattedDuration())->toBe('45m');
});

test('formattedDuration mostra solo ore se i minuti sono zero', function () {
    $entry = new TimeEntry(['minutes_spent' => 120]);
    expect($entry->formattedDuration())->toBe('2h');
});

test('formattedDuration mostra ore e minuti', function () {
    $entry = new TimeEntry(['minutes_spent' => 90]);
    expect($entry->formattedDuration())->toBe('1h 30m');
});

test('formattedDuration con 0 minuti mostra 0m', function () {
    $entry = new TimeEntry(['minutes_spent' => 0]);
    expect($entry->formattedDuration())->toBe('0m');
});

test('formattedDuration con esattamente 60 minuti mostra 1h', function () {
    $entry = new TimeEntry(['minutes_spent' => 60]);
    expect($entry->formattedDuration())->toBe('1h');
});

test('formattedDuration con 61 minuti mostra 1h 1m', function () {
    $entry = new TimeEntry(['minutes_spent' => 61]);
    expect($entry->formattedDuration())->toBe('1h 1m');
});

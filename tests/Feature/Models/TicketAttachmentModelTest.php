<?php

use App\Models\Ticket;
use App\Models\TicketAttachment;
use App\Models\TicketReply;
use App\Models\User;

test('countForTicket conta gli allegati diretti al ticket', function () {
    $ticket = Ticket::factory()->create();
    TicketAttachment::factory()->count(3)->create(['ticket_id' => $ticket->id, 'reply_id' => null]);

    expect(TicketAttachment::countForTicket($ticket->id))->toBe(3);
});

test('countForTicket include gli allegati delle reply del ticket', function () {
    $ticket = Ticket::factory()->create();
    $reply  = TicketReply::factory()->create(['ticket_id' => $ticket->id]);

    TicketAttachment::factory()->count(2)->create(['ticket_id' => $ticket->id, 'reply_id' => null]);
    TicketAttachment::factory()->count(2)->create(['ticket_id' => null, 'reply_id' => $reply->id]);

    expect(TicketAttachment::countForTicket($ticket->id))->toBe(4);
});

test('countForTicket non conta allegati di altri ticket', function () {
    $ticket1 = Ticket::factory()->create();
    $ticket2 = Ticket::factory()->create();

    TicketAttachment::factory()->count(3)->create(['ticket_id' => $ticket1->id, 'reply_id' => null]);
    TicketAttachment::factory()->count(5)->create(['ticket_id' => $ticket2->id, 'reply_id' => null]);

    expect(TicketAttachment::countForTicket($ticket1->id))->toBe(3);
});

test('countForTicket ignora gli allegati soft-deleted', function () {
    $ticket = Ticket::factory()->create();
    $att    = TicketAttachment::factory()->create(['ticket_id' => $ticket->id, 'reply_id' => null]);

    $att->delete();

    expect(TicketAttachment::countForTicket($ticket->id))->toBe(0);
});

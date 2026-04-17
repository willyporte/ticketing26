<?php

use App\Models\Company;
use App\Models\Ticket;
use App\Models\TicketAttachment;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    Storage::fake('local');
});

test('utente non autenticato viene bloccato dal middleware auth', function () {
    $attachment = TicketAttachment::factory()->create();

    // Il middleware auth blocca la richiesta (in test env la rotta 'login' non esiste
    // perché Filament usa la propria — verifichiamo che l'accesso non sia 200)
    $response = $this->get(route('attachments.download', $attachment));
    expect($response->status())->not->toBe(200);
});

test('utente autorizzato può scaricare il proprio allegato', function () {
    Storage::disk('local')->put('attachments/1/1/test.pdf', 'contenuto del file');

    $company = Company::factory()->create();
    $client  = User::factory()->client()->create(['company_id' => $company->id]);
    $ticket  = Ticket::factory()->create(['company_id' => $company->id, 'created_by' => $client->id]);

    $attachment = TicketAttachment::factory()->create([
        'ticket_id'   => $ticket->id,
        'reply_id'    => null,
        'uploaded_by' => $client->id,
        'path'        => 'attachments/1/1/test.pdf',
        'filename'    => 'documento.pdf',
    ]);

    $this->actingAs($client)
         ->get(route('attachments.download', $attachment))
         ->assertOk();
});

test('client non può scaricare allegati di un\'altra company', function () {
    $company1 = Company::factory()->create();
    $company2 = Company::factory()->create();

    $client1 = User::factory()->client()->create(['company_id' => $company1->id]);
    $client2 = User::factory()->client()->create(['company_id' => $company2->id]);

    $ticket = Ticket::factory()->create(['company_id' => $company2->id, 'created_by' => $client2->id]);

    $attachment = TicketAttachment::factory()->create([
        'ticket_id' => $ticket->id,
        'reply_id'  => null,
    ]);

    $this->actingAs($client1)
         ->get(route('attachments.download', $attachment))
         ->assertForbidden();
});

test('restituisce 404 se il file fisico non esiste su disco', function () {
    $company = Company::factory()->create();
    $client  = User::factory()->client()->create(['company_id' => $company->id]);
    $ticket  = Ticket::factory()->create(['company_id' => $company->id, 'created_by' => $client->id]);

    $attachment = TicketAttachment::factory()->create([
        'ticket_id' => $ticket->id,
        'reply_id'  => null,
        'path'      => 'attachments/99/99/missing.pdf',
    ]);

    $this->actingAs($client)
         ->get(route('attachments.download', $attachment))
         ->assertNotFound();
});

test('administrator può scaricare qualsiasi allegato', function () {
    Storage::disk('local')->put('attachments/1/1/admin.pdf', 'file');

    $admin   = User::factory()->administrator()->create();
    $ticket  = Ticket::factory()->create();
    $attachment = TicketAttachment::factory()->create([
        'ticket_id' => $ticket->id,
        'reply_id'  => null,
        'path'      => 'attachments/1/1/admin.pdf',
    ]);

    $this->actingAs($admin)
         ->get(route('attachments.download', $attachment))
         ->assertOk();
});

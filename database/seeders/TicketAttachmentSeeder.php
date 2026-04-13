<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Ticket;
use App\Models\TicketAttachment;
use App\Models\TicketReply;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TicketAttachmentSeeder extends Seeder
{
    /**
     * Seed allegati demo — solo record DB.
     * I file fisici non esistono su disco: sono dati dimostrativi.
     * In produzione i file vengono salvati in storage/app/attachments/{company_id}/{ticket_id}/{uuid}.ext
     */
    public function run(): void
    {
        $acme = Company::where('vat_number', 'IT01234567890')->first();
        $beta = Company::where('vat_number', 'IT09876543210')->first();

        $cliente1   = User::where('email', 'cliente1@demo.com')->first();
        $cliente2   = User::where('email', 'cliente2@demo.com')->first();
        $operatore1 = User::where('email', 'operatore1@demo.com')->first();

        // ── Ticket 1: allegato direttamente al ticket (screenshot errore) ─────
        $ticket1 = Ticket::where('title', 'Impossibile accedere al pannello di controllo')->first();
        if ($ticket1 && $ticket1->attachments()->count() === 0) {
            $uuid = Str::uuid();
            TicketAttachment::create([
                'ticket_id'   => $ticket1->id,
                'reply_id'    => null,
                'uploaded_by' => $cliente1->id,
                'filename'    => 'screenshot-errore-500.png',
                'path'        => "attachments/{$acme->id}/{$ticket1->id}/{$uuid}.png",
                'mime_type'   => 'image/png',
                'size'        => 245_760, // ~240 KB
            ]);
        }

        // ── Ticket 2: allegato a una reply (documento specifiche PDF) ─────────
        $ticket2 = Ticket::where('title', 'Richiesta nuova funzionalità: esportazione PDF')->first();
        if ($ticket2) {
            $reply = $ticket2->replies()->where('user_id', $cliente2->id)->first();
            if ($reply && $reply->attachments()->count() === 0) {
                $uuid = Str::uuid();
                TicketAttachment::create([
                    'ticket_id'   => null,
                    'reply_id'    => $reply->id,
                    'uploaded_by' => $cliente2->id,
                    'filename'    => 'specifiche-esportazione.docx',
                    'path'        => "attachments/{$acme->id}/{$ticket2->id}/{$uuid}.docx",
                    'mime_type'   => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                    'size'        => 87_040, // ~85 KB
                ]);
            }
        }

        // ── Ticket 3: allegato a una reply (file Excel voci fattura errate) ───
        $ticket3 = Ticket::where('title', 'Errore nel calcolo delle fatture di marzo')->first();
        if ($ticket3) {
            $reply = $ticket3->replies()->where('user_id', $cliente1->id)->first();
            if ($reply && $reply->attachments()->count() === 0) {
                $uuid = Str::uuid();
                TicketAttachment::create([
                    'ticket_id'   => null,
                    'reply_id'    => $reply->id,
                    'uploaded_by' => $cliente1->id,
                    'filename'    => 'fatture-marzo-voci-errate.xlsx',
                    'path'        => "attachments/{$acme->id}/{$ticket3->id}/{$uuid}.xlsx",
                    'mime_type'   => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                    'size'        => 512_000, // ~500 KB
                ]);
            }
        }
    }
}

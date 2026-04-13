<?php

namespace Database\Seeders;

use App\Models\Ticket;
use App\Models\TicketReply;
use App\Models\User;
use Illuminate\Database\Seeder;

class TicketReplySeeder extends Seeder
{
    /**
     * Seed conversazioni demo sui ticket esistenti.
     * Si usano i titoli per trovare i ticket in modo idempotente.
     */
    public function run(): void
    {
        $operatore1 = User::where('email', 'operatore1@demo.com')->first();
        $operatore2 = User::where('email', 'operatore2@demo.com')->first();
        $cliente1   = User::where('email', 'cliente1@demo.com')->first();
        $cliente2   = User::where('email', 'cliente2@demo.com')->first();
        $cliente3   = User::where('email', 'cliente3@demo.com')->first();

        // ── Ticket 1: "Impossibile accedere al pannello" (open, nessun assegnatario) ──
        $ticket1 = Ticket::where('title', 'Impossibile accedere al pannello di controllo')->first();
        if ($ticket1 && $ticket1->replies()->count() === 0) {
            TicketReply::create([
                'ticket_id' => $ticket1->id,
                'user_id'   => $cliente1->id,
                'body'      => 'Aggiungo un dettaglio: il problema si verifica solo su Chrome, su Firefox funziona regolarmente. Ho allegato uno screenshot dell\'errore.',
            ]);
        }

        // ── Ticket 2: "Richiesta nuova funzionalità: esportazione PDF" (in_progress) ──
        $ticket2 = Ticket::where('title', 'Richiesta nuova funzionalità: esportazione PDF')->first();
        if ($ticket2 && $ticket2->replies()->count() === 0) {
            TicketReply::create([
                'ticket_id' => $ticket2->id,
                'user_id'   => $operatore1->id,
                'body'      => 'Ho preso in carico la richiesta. Stiamo valutando l\'implementazione con una libreria PDF lato server. Vi aggiorno entro fine settimana.',
            ]);
            TicketReply::create([
                'ticket_id' => $ticket2->id,
                'user_id'   => $cliente2->id,
                'body'      => 'Perfetto, grazie! Se possibile sarebbe utile avere anche la possibilità di scegliere l\'intervallo di date nell\'esportazione.',
            ]);
        }

        // ── Ticket 3: "Errore nel calcolo delle fatture di marzo" (waiting_client) ──
        $ticket3 = Ticket::where('title', 'Errore nel calcolo delle fatture di marzo')->first();
        if ($ticket3 && $ticket3->replies()->count() === 0) {
            TicketReply::create([
                'ticket_id' => $ticket3->id,
                'user_id'   => $operatore1->id,
                'body'      => 'Ho riprodotto il problema. Sembra legato alla configurazione delle categorie IVA. Potete inviarci l\'elenco delle voci che risultano errate?',
            ]);
            TicketReply::create([
                'ticket_id' => $ticket3->id,
                'user_id'   => $cliente1->id,
                'body'      => 'Vi ho inviato il file Excel con tutte le righe errate via email. Sono circa 47 voci su 200 fatture.',
            ]);
            TicketReply::create([
                'ticket_id' => $ticket3->id,
                'user_id'   => $operatore1->id,
                'body'      => 'Ricevuto, grazie. Stiamo analizzando il file. In attesa di conferma dalla vostra parte sulla lista che vi abbiamo inviato ieri.',
            ]);
        }

        // ── Ticket 4: "Aggiornamento credenziali server di posta" (resolved) ──
        $ticket4 = Ticket::where('title', 'Aggiornamento credenziali server di posta')->first();
        if ($ticket4 && $ticket4->replies()->count() === 0) {
            TicketReply::create([
                'ticket_id' => $ticket4->id,
                'user_id'   => $operatore2->id,
                'body'      => 'Ho aggiornato le credenziali SMTP nel pannello di configurazione. Potete verificare inviando un\'email di test?',
            ]);
            TicketReply::create([
                'ticket_id' => $ticket4->id,
                'user_id'   => $cliente3->id,
                'body'      => 'Confermato, le email ora partono correttamente. Grazie per la rapida risoluzione!',
            ]);
        }
    }
}

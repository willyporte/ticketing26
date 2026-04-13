<?php

namespace Database\Seeders;

use App\Models\Ticket;
use App\Models\TimeEntry;
use App\Models\User;
use Illuminate\Database\Seeder;

class TimeEntrySeeder extends Seeder
{
    /**
     * Seed time entry demo su ticket esistenti.
     * I minuti vengono scalati dalla subscription nello STEP 8.
     */
    public function run(): void
    {
        $operatore1 = User::where('email', 'operatore1@demo.com')->first();
        $operatore2 = User::where('email', 'operatore2@demo.com')->first();
        $admin      = User::where('email', 'admin@demo.com')->first();

        $ticket2 = Ticket::where('title', 'Richiesta nuova funzionalità: esportazione PDF')->first();
        $ticket3 = Ticket::where('title', 'Errore nel calcolo delle fatture di marzo')->first();
        $ticket4 = Ticket::where('title', 'Aggiornamento credenziali server di posta')->first();
        $ticket5 = Ticket::where('title', 'Domanda su limiti piano abbonamento')->first();

        $entries = [
            // Ticket 2 — in_progress, due sessioni di lavoro
            [
                'ticket_id'     => $ticket2->id,
                'user_id'       => $operatore1->id,
                'minutes_spent' => 45,
                'notes'         => 'Analisi librerie PDF disponibili (DOMPDF, Browsershot). Scelta ricaduta su DOMPDF per semplicità di integrazione.',
            ],
            [
                'ticket_id'     => $ticket2->id,
                'user_id'       => $operatore1->id,
                'minutes_spent' => 90,
                'notes'         => 'Implementazione prima bozza esportazione PDF. Template base creato, mancano ancora filtri per intervallo date.',
            ],

            // Ticket 3 — waiting_client, analisi urgente
            [
                'ticket_id'     => $ticket3->id,
                'user_id'       => $operatore1->id,
                'minutes_spent' => 60,
                'notes'         => 'Analisi file Excel ricevuto dal cliente. Identificate 47 voci con aliquota IVA applicata erroneamente.',
            ],
            [
                'ticket_id'     => $ticket3->id,
                'user_id'       => $operatore1->id,
                'minutes_spent' => 30,
                'notes'         => 'Correzione configurazione categorie IVA in ambiente di staging. In attesa di conferma cliente per deploy in produzione.',
            ],

            // Ticket 4 — resolved, risolto rapidamente
            [
                'ticket_id'     => $ticket4->id,
                'user_id'       => $operatore2->id,
                'minutes_spent' => 20,
                'notes'         => 'Aggiornamento credenziali SMTP nel pannello di configurazione. Verifica invio email di test: OK.',
            ],

            // Ticket 5 — closed, consulenza breve
            [
                'ticket_id'     => $ticket5->id,
                'user_id'       => $admin->id,
                'minutes_spent' => 15,
                'notes'         => 'Chiarimento limiti piano attuale e illustrazione opzioni di upgrade. Cliente soddisfatto, ticket chiuso.',
            ],
        ];

        foreach ($entries as $data) {
            TimeEntry::create($data);
        }
    }
}

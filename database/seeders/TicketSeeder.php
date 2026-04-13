<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Department;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Seeder;

class TicketSeeder extends Seeder
{
    /**
     * Seed 5 ticket demo con stati e priorità variati.
     */
    public function run(): void
    {
        $acme = Company::where('vat_number', 'IT01234567890')->first();
        $beta = Company::where('vat_number', 'IT09876543210')->first();

        $supporto      = Department::where('name', 'Supporto')->first();
        $sviluppo      = Department::where('name', 'Sviluppo')->first();
        $amministrazione = Department::where('name', 'Amministrazione')->first();

        $admin      = User::where('email', 'admin@demo.com')->first();
        $operatore1 = User::where('email', 'operatore1@demo.com')->first();
        $operatore2 = User::where('email', 'operatore2@demo.com')->first();
        $cliente1   = User::where('email', 'cliente1@demo.com')->first();
        $cliente2   = User::where('email', 'cliente2@demo.com')->first();
        $cliente3   = User::where('email', 'cliente3@demo.com')->first();

        $tickets = [
            [
                'title'         => 'Impossibile accedere al pannello di controllo',
                'description'   => 'Dal mattino non riesco ad accedere al pannello. Il browser mostra un errore 500. Ho già provato a svuotare la cache ma il problema persiste.',
                'status'        => 'open',
                'priority'      => 'high',
                'company_id'    => $acme->id,
                'department_id' => $supporto->id,
                'created_by'    => $cliente1->id,
                'assigned_to'   => null,
            ],
            [
                'title'         => 'Richiesta nuova funzionalità: esportazione PDF',
                'description'   => 'Sarebbe molto utile poter esportare i report in formato PDF oltre che CSV. La utilizziamo per le riunioni con i clienti.',
                'status'        => 'in_progress',
                'priority'      => 'medium',
                'company_id'    => $acme->id,
                'department_id' => $sviluppo->id,
                'created_by'    => $cliente2->id,
                'assigned_to'   => $operatore1->id,
            ],
            [
                'title'         => 'Errore nel calcolo delle fatture di marzo',
                'description'   => 'Le fatture generate a marzo riportano un importo IVA errato. Il 22% viene applicato anche alle voci esenti. Serve correzione urgente.',
                'status'        => 'waiting_client',
                'priority'      => 'urgent',
                'company_id'    => $acme->id,
                'department_id' => $amministrazione->id,
                'created_by'    => $cliente1->id,
                'assigned_to'   => $operatore1->id,
            ],
            [
                'title'         => 'Aggiornamento credenziali server di posta',
                'description'   => 'Il server SMTP ha cambiato le credenziali di autenticazione. Le email transazionali non vengono più inviate correttamente.',
                'status'        => 'resolved',
                'priority'      => 'high',
                'company_id'    => $beta->id,
                'department_id' => $supporto->id,
                'created_by'    => $cliente3->id,
                'assigned_to'   => $operatore2->id,
            ],
            [
                'title'         => 'Domanda su limiti piano abbonamento',
                'description'   => 'Vorrei sapere quanti utenti possiamo aggiungere al piano attuale e quali sono i costi per un upgrade.',
                'status'        => 'closed',
                'priority'      => 'low',
                'company_id'    => $beta->id,
                'department_id' => $amministrazione->id,
                'created_by'    => $cliente3->id,
                'assigned_to'   => $admin->id,
            ],
        ];

        foreach ($tickets as $data) {
            Ticket::firstOrCreate(
                ['title' => $data['title'], 'company_id' => $data['company_id']],
                $data
            );
        }
    }
}

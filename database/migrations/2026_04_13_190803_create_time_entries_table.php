<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('time_entries', function (Blueprint $table) {
            $table->id();

            $table->foreignId('ticket_id')
                  ->constrained('tickets')
                  ->cascadeOnDelete();

            $table->foreignId('user_id')
                  ->constrained('users')
                  ->cascadeOnDelete();

            // Minuti lavorati — può portare il saldo subscription in negativo (lavoro extra non coperto)
            $table->unsignedInteger('minutes_spent');

            // Note opzionali — indispensabili per rendicontazione e fatturazione
            $table->text('notes')->nullable();

            // Soft delete — nessuna cancellazione fisica
            $table->softDeletes();
            $table->timestamps();

            // Indici per i filtri più comuni (per ticket, per operatore)
            $table->index('ticket_id');
            $table->index('user_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('time_entries');
    }
};

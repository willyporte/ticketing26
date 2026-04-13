<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            // Minuti totali inclusi nel piano
            $table->unsignedInteger('total_minutes');
            // Durata validità in giorni dalla data di attivazione
            $table->unsignedInteger('validity_days');
            // Prezzo opzionale nell'MVP — usato solo a scopo informativo
            $table->decimal('price', 10, 2)->nullable();
            // Soft delete — nessuna cancellazione fisica
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};

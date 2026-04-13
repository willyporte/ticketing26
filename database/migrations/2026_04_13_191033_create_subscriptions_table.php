<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('company_id')
                  ->constrained('companies')
                  ->cascadeOnDelete();

            $table->foreignId('plan_id')
                  ->constrained('plans')
                  ->restrictOnDelete(); // Non cancellare un piano se ha subscription attive

            // Minuti residui — può diventare negativo (lavoro extra non coperto dal contratto)
            $table->integer('minutes_remaining');

            $table->date('starts_at');
            $table->date('expires_at');

            // Soft delete — nessuna cancellazione fisica
            $table->softDeletes();
            $table->timestamps();

            // Indice per recuperare subscription attive di una company
            $table->index(['company_id', 'starts_at', 'expires_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};

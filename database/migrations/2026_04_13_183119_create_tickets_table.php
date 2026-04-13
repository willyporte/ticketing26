<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');

            // Enum gestiti come stringhe — i valori validi sono enforced a livello applicativo (Enum PHP)
            $table->enum('status', ['open', 'in_progress', 'waiting_client', 'resolved', 'closed'])
                  ->default('open')
                  ->index();
            $table->enum('priority', ['low', 'medium', 'high', 'urgent'])
                  ->default('medium')
                  ->index();

            $table->foreignId('company_id')
                  ->constrained('companies')
                  ->cascadeOnDelete();

            // department nullable — lo smistamento al reparto è opzionale
            $table->foreignId('department_id')
                  ->nullable()
                  ->constrained('departments')
                  ->nullOnDelete();

            $table->foreignId('created_by')
                  ->constrained('users')
                  ->cascadeOnDelete();

            // assigned_to nullable — il ticket può essere non ancora assegnato
            $table->foreignId('assigned_to')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();

            // Soft delete — nessuna cancellazione fisica
            $table->softDeletes();
            $table->timestamps();

            // Indici sulle colonne più usate nei filtri e nelle query
            $table->index('company_id');
            $table->index('assigned_to');
            $table->index('created_by');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};

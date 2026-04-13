<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ticket_attachments', function (Blueprint $table) {
            $table->id();

            // Un allegato appartiene a un ticket OPPURE a una reply (mai entrambi null)
            $table->foreignId('ticket_id')
                  ->nullable()
                  ->constrained('tickets')
                  ->cascadeOnDelete();

            $table->foreignId('reply_id')
                  ->nullable()
                  ->constrained('ticket_replies')
                  ->cascadeOnDelete();

            $table->foreignId('uploaded_by')
                  ->constrained('users')
                  ->cascadeOnDelete();

            // Nome file originale — mostrato all'utente nel download
            $table->string('filename');
            // Percorso su disco: storage/app/attachments/{company_id}/{ticket_id}/{uuid}.ext
            // MAI esposto direttamente — sempre tramite route protetta
            $table->string('path');
            $table->string('mime_type');
            // Dimensione in bytes (max 10MB = 10_485_760)
            $table->unsignedInteger('size');

            // Soft delete — il file fisico resta su disco, solo il record DB viene nascosto
            $table->softDeletes();
            $table->timestamps();

            $table->index('ticket_id');
            $table->index('reply_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ticket_attachments');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('vat_number')->nullable()->unique(); // Partita IVA
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            // Logo azienda — storage locale in storage/app/public/logos/ (accessibile via storage:link)
            $table->string('logo_path')->nullable();
            // Soft delete — nessuna cancellazione fisica
            $table->softDeletes();
            $table->timestamps();
        });

        // Aggiunge il constraint FK su users.company_id ora che la tabella companies esiste
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('company_id')
                  ->references('id')
                  ->on('companies')
                  ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['company_id']);
        });

        Schema::dropIfExists('companies');
    }
};

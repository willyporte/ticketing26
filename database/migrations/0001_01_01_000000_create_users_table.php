<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');

            // Ruolo utente — gestito con enum semplice invece di package complessi (KISS)
            $table->enum('role', ['administrator', 'supervisor', 'operator', 'client'])
                  ->default('client');

            // Azienda di appartenenza (nullable: l'admin di sistema non ha company)
            // FK verso companies aggiunta nello STEP 2 con migration separata
            $table->unsignedBigInteger('company_id')->nullable();

            // Visibilità ticket: true = vede tutti i ticket della sua company, false = solo i propri
            $table->boolean('can_view_company_tickets')->default(false);

            // Campi 2FA — predisposti per future implementazioni, non attivi nell'MVP
            $table->text('two_factor_secret')->nullable();
            $table->text('two_factor_recovery_codes')->nullable();

            $table->rememberToken();
            // Soft delete — nessuna cancellazione fisica degli utenti
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('users');
    }
};

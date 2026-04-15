<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Aggiunge le colonne richieste dal sistema MFA nativo di Filament v5.
     *
     * Filament v5 usa colonne proprie, diverse dai campi two_factor_* predisposti
     * nello STEP 1 (che restano in tabella ma non vengono più utilizzati).
     *
     * - app_authentication_secret      → secret TOTP, cifrato automaticamente dal trait
     * - app_authentication_recovery_codes → codici di recupero, cifrati come array
     * - has_email_authentication       → flag boolean per il 2FA via email
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // TOTP (Google Authenticator) — cifrato dal trait InteractsWithAppAuthentication
            $table->text('app_authentication_secret')->nullable()->after('two_factor_recovery_codes');

            // Recovery codes TOTP — cifrati come array dal trait InteractsWithAppAuthenticationRecovery
            $table->text('app_authentication_recovery_codes')->nullable()->after('app_authentication_secret');

            // Email MFA — semplice boolean, gestito dal trait InteractsWithEmailAuthentication
            $table->boolean('has_email_authentication')->default(false)->after('app_authentication_recovery_codes');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'app_authentication_secret',
                'app_authentication_recovery_codes',
                'has_email_authentication',
            ]);
        });
    }
};

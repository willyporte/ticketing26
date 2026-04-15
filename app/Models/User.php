<?php

namespace App\Models;

use Filament\Auth\MultiFactor\App\Concerns\InteractsWithAppAuthentication;
use Filament\Auth\MultiFactor\App\Concerns\InteractsWithAppAuthenticationRecovery;
use Filament\Auth\MultiFactor\App\Contracts\HasAppAuthentication;
use Filament\Auth\MultiFactor\App\Contracts\HasAppAuthenticationRecovery;
use Filament\Auth\MultiFactor\Email\Concerns\InteractsWithEmailAuthentication;
use Filament\Auth\MultiFactor\Email\Contracts\HasEmailAuthentication;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements
    FilamentUser,
    HasAppAuthentication,
    HasAppAuthenticationRecovery,
    HasEmailAuthentication
{
    use HasFactory,
        Notifiable,
        SoftDeletes,
        InteractsWithAppAuthentication,
        InteractsWithAppAuthenticationRecovery,
        InteractsWithEmailAuthentication;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'company_id',
        'can_view_company_tickets',
        'avatar_path',
        'two_factor_secret',
        'two_factor_recovery_codes',
        // Colonne MFA native Filament v5
        'app_authentication_secret',
        'app_authentication_recovery_codes',
        'has_email_authentication',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_secret',
        'two_factor_recovery_codes',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at'        => 'datetime',
            'password'                 => 'hashed',
            'can_view_company_tickets' => 'boolean',
            // Timezone: l'app usa Europe/Rome, il DB salva UTC — Laravel converte automaticamente
            'created_at'               => 'datetime',
            'updated_at'               => 'datetime',
            'deleted_at'               => 'datetime',
        ];
    }

    // ─── Filament ─────────────────────────────────────────────────────────────

    /**
     * Tutti i ruoli hanno accesso al panel Filament.
     * La visibilità delle singole Resource è gestita dalle Policy.
     */
    public function canAccessPanel(Panel $panel): bool
    {
        return ! $this->trashed();
    }

    /**
     * Nome mostrato nell'app Google Authenticator accanto al codice TOTP.
     * Sovrascrive il default del trait (che usa solo $this->email).
     */
    public function getAppAuthenticationHolderName(): string
    {
        return "{$this->name} ({$this->email})";
    }

    // ─── Helpers ruolo ────────────────────────────────────────────────────────

    public function isAdministrator(): bool
    {
        return $this->role === 'administrator';
    }

    public function isSupervisor(): bool
    {
        return $this->role === 'supervisor';
    }

    public function isOperator(): bool
    {
        return $this->role === 'operator';
    }

    public function isClient(): bool
    {
        return $this->role === 'client';
    }

    // ─── Relazioni ────────────────────────────────────────────────────────────

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function createdTickets(): HasMany
    {
        return $this->hasMany(Ticket::class, 'created_by');
    }

    public function assignedTickets(): HasMany
    {
        return $this->hasMany(Ticket::class, 'assigned_to');
    }

    public function timeEntries(): HasMany
    {
        return $this->hasMany(TimeEntry::class);
    }
}

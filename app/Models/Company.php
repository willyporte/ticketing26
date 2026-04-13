<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'vat_number',
        'email',
        'phone',
        'logo_path',
    ];

    protected function casts(): array
    {
        return [
            // Timezone: l'app usa Europe/Rome, il DB salva UTC — Laravel converte automaticamente
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }

    // ─── Relazioni ────────────────────────────────────────────────────────────

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    /**
     * Subscription attiva corrente (al massimo una per company).
     */
    public function activeSubscription(): ?Subscription
    {
        return $this->subscriptions()->active()->first();
    }
}

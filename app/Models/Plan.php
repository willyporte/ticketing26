<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Plan extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'total_minutes',
        'validity_days',
        'price',
    ];

    protected function casts(): array
    {
        return [
            'total_minutes' => 'integer',
            'validity_days' => 'integer',
            'price'         => 'decimal:2',
            // Timezone: l'app usa Europe/Rome, il DB salva UTC — Laravel converte automaticamente
            'created_at'    => 'datetime',
            'updated_at'    => 'datetime',
            'deleted_at'    => 'datetime',
        ];
    }

    // ─── Relazioni ────────────────────────────────────────────────────────────

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }
}

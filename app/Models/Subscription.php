<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

class Subscription extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_id',
        'plan_id',
        'minutes_remaining',
        'starts_at',
        'expires_at',
    ];

    protected function casts(): array
    {
        return [
            'minutes_remaining' => 'integer',
            // Timezone: l'app usa Europe/Rome, il DB salva UTC — Laravel converte automaticamente
            'starts_at'         => 'date',
            'expires_at'        => 'date',
            'created_at'        => 'datetime',
            'updated_at'        => 'datetime',
            'deleted_at'        => 'datetime',
        ];
    }

    // ─── Scope ────────────────────────────────────────────────────────────────

    /**
     * Subscription attiva: data odierna compresa tra starts_at ed expires_at.
     * Una company può avere una sola subscription attiva alla volta.
     */
    public function scopeActive(Builder $query): Builder
    {
        $today = Carbon::today();

        return $query
            ->where('starts_at', '<=', $today)
            ->where('expires_at', '>=', $today);
    }

    // ─── Helper ───────────────────────────────────────────────────────────────

    /**
     * Verifica se la subscription è attiva oggi.
     */
    public function isActive(): bool
    {
        $today = Carbon::today();

        return $this->starts_at->lte($today) && $this->expires_at->gte($today);
    }

    /**
     * Verifica se i minuti residui sono sotto la soglia del 20% (warning).
     */
    public function isBelowWarningThreshold(): bool
    {
        $totalMinutes = $this->plan->total_minutes;

        if ($totalMinutes <= 0) {
            return false;
        }

        return $this->minutes_remaining < ($totalMinutes * 0.20);
    }

    /**
     * Percentuale di minuti residui (0–100).
     */
    public function remainingPercentage(): int
    {
        $totalMinutes = $this->plan->total_minutes;

        if ($totalMinutes <= 0) {
            return 0;
        }

        return (int) max(0, min(100, round(($this->minutes_remaining / $totalMinutes) * 100)));
    }

    /**
     * Scala i minuti dalla subscription.
     * I minuti possono scendere sotto zero (lavoro extra non coperto dal contratto).
     */
    public function deductMinutes(int $minutes): void
    {
        $this->decrement('minutes_remaining', $minutes);
    }

    // ─── Relazioni ────────────────────────────────────────────────────────────

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class TimeEntry extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'ticket_id',
        'user_id',
        'minutes_spent',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'minutes_spent' => 'integer',
            // Timezone: l'app usa Europe/Rome, il DB salva UTC — Laravel converte automaticamente
            'created_at'    => 'datetime',
            'updated_at'    => 'datetime',
            'deleted_at'    => 'datetime',
        ];
    }

    // ─── Helper ───────────────────────────────────────────────────────────────

    /**
     * Minuti formattati in ore e minuti (es. "1h 30m", "45m").
     */
    public function formattedDuration(): string
    {
        $hours   = intdiv($this->minutes_spent, 60);
        $minutes = $this->minutes_spent % 60;

        if ($hours > 0 && $minutes > 0) {
            return "{$hours}h {$minutes}m";
        }

        if ($hours > 0) {
            return "{$hours}h";
        }

        return "{$minutes}m";
    }

    // ─── Relazioni ────────────────────────────────────────────────────────────

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

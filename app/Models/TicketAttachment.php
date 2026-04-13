<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class TicketAttachment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'ticket_id',
        'reply_id',
        'uploaded_by',
        'filename',
        'path',
        'mime_type',
        'size',
    ];

    protected function casts(): array
    {
        return [
            'size'       => 'integer',
            // Timezone: l'app usa Europe/Rome, il DB salva UTC — Laravel converte automaticamente
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }

    // ─── Helper ───────────────────────────────────────────────────────────────

    /**
     * Dimensione formattata leggibile (es. "2.4 MB", "345 KB").
     */
    public function formattedSize(): string
    {
        $bytes = $this->size;

        if ($bytes >= 1_048_576) {
            return round($bytes / 1_048_576, 1) . ' MB';
        }

        if ($bytes >= 1_024) {
            return round($bytes / 1_024, 1) . ' KB';
        }

        return $bytes . ' B';
    }

    /**
     * Conta gli allegati totali di un ticket (ticket + tutte le sue reply).
     * Usato per il controllo del limite massimo di 10 allegati per ticket.
     */
    public static function countForTicket(int $ticketId): int
    {
        $replyIds = TicketReply::where('ticket_id', $ticketId)->pluck('id');

        return self::where('ticket_id', $ticketId)
            ->orWhereIn('reply_id', $replyIds)
            ->count();
    }

    // ─── Relazioni ────────────────────────────────────────────────────────────

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }

    public function reply(): BelongsTo
    {
        return $this->belongsTo(TicketReply::class, 'reply_id');
    }

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}

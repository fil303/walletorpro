<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SupportTicketReply extends Model
{
    use HasFactory;
    protected $fillable = [
        "ticket",
        "sender",
        "receiver",
        "message",
        "attachment",
    ];

    public function sender_user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender');
    }

    public function scopeFindByTicket(Builder $query, string $ticket): Builder
    {
        return $query->where('ticket', $ticket);
    }
}

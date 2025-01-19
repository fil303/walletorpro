<?php

namespace App\Models;

use App\Enums\UserRole;
use App\Enums\SupportTicketStatus;
use App\Models\SupportTicketReply;
use App\Enums\SupportTicketPriority;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SupportTicket extends Model
{
    use HasFactory;
    protected $fillable = [
        "user_id",
        "ticket",
        "subject",
        "status",
        "priority",
    ];

    /**
     * Casts db value to original type
     * @var array<string, string>
     */
    protected $casts = [
        "priority" => SupportTicketPriority::class,
        "status"   => SupportTicketStatus::class
    ];

    /**
     * User Relation from support ticket model
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Replies Relation from support ticket model
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function replies(): HasMany
    {
        return $this->hasMany(SupportTicketReply::class, "ticket", "ticket");
    }

    /**
     * Scope for user
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeForUser(Builder $query,  int $id = null): Builder
    {
        if(Auth::user()->role->isSuperAdmin()) return $query;
        return $query->where('user_id', $id ?? Auth::id());
    }

    /**
     * Scope for open tickets
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOpen(Builder $query): Builder
    {
        return $query->where('status', enum(SupportTicketStatus::OPEN));
    }

    /**
     * Scope for closed tickets
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeClosed(Builder $query): Builder
    {
        return $query->where('status', enum(SupportTicketStatus::CLOSED));
    }

    /**
     * Scope for answered tickets
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAnswered(Builder $query): Builder
    {
        return $query->where('status', enum(SupportTicketStatus::ANSWERED));
    }

    /**
     * Scope for ticket
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $ticket
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeTicket(Builder $query, string $ticket): Builder
    {
        return $query->where('ticket', $ticket);
    }
}

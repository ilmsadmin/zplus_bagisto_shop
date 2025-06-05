<?php

namespace ZPlus\ViPOS\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Webkul\User\Models\Admin;

class ViPOSSession extends Model
{
    /**
     * The table associated with the model.
     */
    protected $table = 'vipos_sessions';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id',
        'opening_amount',
        'closing_amount',
        'expected_amount',
        'total_sales',
        'total_orders',
        'opening_notes',
        'closing_notes',
        'status',
        'opened_at',
        'closed_at',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'opening_amount' => 'decimal:4',
        'closing_amount' => 'decimal:4',
        'expected_amount' => 'decimal:4',
        'total_sales' => 'decimal:4',
        'opened_at' => 'datetime',
        'closed_at' => 'datetime',
    ];

    /**
     * Get the user that owns the session.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'user_id');
    }

    /**
     * Scope a query to only include open sessions.
     */
    public function scopeOpen($query)
    {
        return $query->where('status', 'open');
    }

    /**
     * Scope a query to only include closed sessions.
     */
    public function scopeClosed($query)
    {
        return $query->where('status', 'closed');
    }

    /**
     * Check if the session is open.
     */
    public function isOpen(): bool
    {
        return $this->status === 'open';
    }

    /**
     * Check if the session is closed.
     */
    public function isClosed(): bool
    {
        return $this->status === 'closed';
    }
}
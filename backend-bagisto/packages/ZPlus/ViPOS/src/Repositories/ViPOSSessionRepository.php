<?php

namespace ZPlus\ViPOS\Repositories;

use ZPlus\ViPOS\Models\ViPOSSession;
use Webkul\Core\Eloquent\Repository;

class ViPOSSessionRepository extends Repository
{
    /**
     * Specify model class name.
     */
    public function model(): string
    {
        return ViPOSSession::class;
    }

    /**
     * Get the current open session for a user.
     */
    public function getCurrentSession(int $userId): ?ViPOSSession
    {
        return $this->where('user_id', $userId)
                    ->where('status', 'open')
                    ->latest('opened_at')
                    ->first();
    }

    /**
     * Start a new session.
     */
    public function startSession(array $data): ViPOSSession
    {
        // Close any open sessions for this user first
        $this->where('user_id', $data['user_id'])
             ->where('status', 'open')
             ->update(['status' => 'closed', 'closed_at' => now()]);

        return $this->create(array_merge($data, [
            'status' => 'open',
            'opened_at' => now(),
        ]));
    }

    /**
     * Close a session.
     */
    public function closeSession(int $sessionId, array $data): bool
    {
        return $this->where('id', $sessionId)
                    ->update(array_merge($data, [
                        'status' => 'closed',
                        'closed_at' => now(),
                    ]));
    }

    /**
     * Update session sales totals.
     */
    public function updateSalesTotals(int $sessionId, float $orderTotal): void
    {
        $session = $this->find($sessionId);
        
        if ($session) {
            $session->increment('total_sales', $orderTotal);
            $session->increment('total_orders');
            $session->update(['expected_amount' => $session->opening_amount + $session->total_sales]);
        }
    }

    /**
     * Get sessions for a date range.
     */
    public function getSessionsByDateRange($startDate, $endDate, int $userId = null)
    {
        $query = $this->whereBetween('opened_at', [$startDate, $endDate]);
        
        if ($userId) {
            $query->where('user_id', $userId);
        }
        
        return $query->with('user')->orderBy('opened_at', 'desc')->get();
    }
}
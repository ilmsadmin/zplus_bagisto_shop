<?php

namespace ZPlus\ViPOS\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use ZPlus\ViPOS\Repositories\ViPOSSessionRepository;

class ViPOSController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct(
        protected ViPOSSessionRepository $sessionRepository
    ) {}

    /**
     * Display the main POS interface.
     */
    public function index(): View
    {
        $currentSession = $this->sessionRepository->getCurrentSession(auth()->guard('admin')->id());
        
        return view('vipos::pos.index', [
            'currentSession' => $currentSession,
        ]);
    }

    /**
     * Start a new POS session.
     */
    public function startSession(Request $request)
    {
        $request->validate([
            'opening_amount' => 'required|numeric|min:0',
            'notes' => 'nullable|string|max:255',
        ]);

        try {
            $session = $this->sessionRepository->startSession([
                'user_id' => auth()->guard('admin')->id(),
                'opening_amount' => $request->opening_amount,
                'opening_notes' => $request->notes,
                'expected_amount' => $request->opening_amount,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Session started successfully',
                'data' => $session,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to start session: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Close the current POS session.
     */
    public function closeSession(Request $request)
    {
        $request->validate([
            'closing_amount' => 'required|numeric|min:0',
            'notes' => 'nullable|string|max:255',
        ]);

        try {
            $currentSession = $this->sessionRepository->getCurrentSession(auth()->guard('admin')->id());
            
            if (!$currentSession) {
                return response()->json([
                    'success' => false,
                    'message' => 'No open session found',
                ], 404);
            }

            $this->sessionRepository->closeSession($currentSession->id, [
                'closing_amount' => $request->closing_amount,
                'closing_notes' => $request->notes,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Session closed successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to close session: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get current session status.
     */
    public function getSessionStatus()
    {
        $currentSession = $this->sessionRepository->getCurrentSession(auth()->guard('admin')->id());
        
        return response()->json([
            'has_open_session' => $currentSession !== null,
            'session' => $currentSession,
        ]);
    }
}
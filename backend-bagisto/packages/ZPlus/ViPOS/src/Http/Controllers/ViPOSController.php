<?php

namespace ZPlus\ViPOS\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class ViPOSController extends Controller
{
    /**
     * Display the main POS interface.
     */
    public function index(): View
    {
        return view('vipos::pos.index');
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

        // TODO: Implement session management
        return response()->json([
            'success' => true,
            'message' => 'Session started successfully',
        ]);
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

        // TODO: Implement session closing
        return response()->json([
            'success' => true,
            'message' => 'Session closed successfully',
        ]);
    }
}
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Game;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ApiGameController extends Controller
{

    public function index(Request $request)
    {
        $request->validate([
            'player_id' => 'required|numeric',
        ]);

        $games = Game::where('player_id', $request->player_id)
            ->orderByDesc('created_at')
            ->limit(3)
            ->get();

        return response()->json(['games' => $games], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'figure' => 'required|numeric',
            'player_id' => 'required|numeric',
        ]);

        $figure = (int) $request->figure;
        
        $isWin = $figure % 2 === 0;
        $winAmount = $isWin ? Game::calculateWinAmount($figure) : 0;

        $game = Game::create([
            'player_id' => $request->player_id,
            'random_figure' => $figure,
            'reward' => $winAmount,
        ]);
        
        if ($game) {
            return response()->json([
                'result' => $isWin ? 'Win' : 'Lose',
                'amount' => $winAmount,
            ]);
        }

        return response()->json(['error' => 'Failed to save the game'], 500);

    }
}

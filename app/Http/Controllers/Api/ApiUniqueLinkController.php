<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UniqueLink;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ApiUniqueLinkController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'player_id' => 'required|numeric',
        ]);

        $uniqueLink = Str::uuid();

        $link = UniqueLink::create([
            'player_id' => $request->player_id,
            'unique_link' => $uniqueLink,
            'expires_at' => Carbon::now()->addDays(7),
        ]);

        if ($link) {
            return response()->json(['unique_link' => $uniqueLink], 200);
        }

        return response()->json(['error' => 'Failed to create link'], 500);
    }

    public function deactivate(Request $request)
    {
        $request->validate([
            'link' => 'required|string|max:255',
        ]);

        $link = UniqueLink::where('unique_link', $request->link)->first();

        if ($link) {
            $link->is_active = false;
            $link->save();
            return response()->json(['success' => 'Link deactivated'], 200);
        }

        return response()->json(['error' => 'Link not found'], 404);
    }
}

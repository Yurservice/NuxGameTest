<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UniqueLink;
use App\Models\Player;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class MainController extends Controller
{
    public function showForm()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
        ]);

        $uniqueLink = Str::uuid();

        DB::beginTransaction();
        $player = Player::create([
            'username' => $request->username,
            'phone_number' => $request->phone_number,
        ]);

        $link = UniqueLink::create([
            'player_id' => $player->id,
            'unique_link' => $uniqueLink,
            'expires_at' => Carbon::now()->addDays(7), 
        ]);
        
        if ($player && $link) {
            DB::commit();
            return redirect()->route('success', ['link' => route('access.page', $uniqueLink)]);
        }
        else { 
            DB::rollBack();
            abort(500, 'An unknown error has occurred!');
        }
    }

    public function accessPage($uniqueLink)
    {
        $uniqueLink = UniqueLink::where('unique_link', $uniqueLink)
            ->where('expires_at', '>', Carbon::now())
            ->where('is_active', '=', true)
            ->first();

        if (!$uniqueLink) {
            abort(404, 'Link is invalid');
        }
        
        $player = Player::find($uniqueLink->player_id);

        return view('access_page', compact('player', 'uniqueLink'));
    }
}

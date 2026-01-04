<?php

namespace App\Http\Controllers;

use App\Models\Deck;
use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VoteController extends Controller
{
    public function store(Request $request, Deck $deck)
    {
        $request->validate([
            'is_like' => 'required|boolean',
        ]);

        $existingVote = Vote::where('user_id', Auth::id())
                            ->where('deck_id', $deck->id)
                            ->first();

        if ($existingVote) {
            
            if ($existingVote->is_like == $request->is_like) {
                $existingVote->delete();
            } else {
                $existingVote->is_like = $request->is_like;
                $existingVote->save();
            }
        } else {
            Vote::create([
                'user_id' => Auth::id(),
                'deck_id' => $deck->id,
                'is_like' => $request->is_like
            ]);
        }

        return back();
    }
}
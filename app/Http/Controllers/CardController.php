<?php

namespace App\Http\Controllers;

use App\Models\Card;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Gate;

class CardController extends Controller
{
    public function index(Request $request)
{
    $query = Card::query();

    if ($request->filled('rarity')) {
        $query->where('rarity', $request->rarity);
    }

    $sort = $request->get('sort', 'name'); 
    $direction = $request->get('direction', 'asc');

    if (in_array($sort, ['name', 'elixir_cost', 'created_at'])) {
        $query->orderBy($sort, $direction);
    }

    $cards = $query->get();

    return view('cards.index', ['cards' => $cards]);
}

    public function create()
    {
        Gate::authorize('access-admin');
        return view('cards.create');
    }

    public function store(Request $request)
    {
        Gate::authorize('access-admin');

        $request->validate([
            'name' => 'required|string|max:255',
            'elixir_cost' => 'required|integer|min:1|max:9',
            'rarity' => 'required|string',
            'arena' => 'required|integer',
            'image' => 'nullable|image|max:2048'
        ]);

        $path = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('cards', 'public');
        }

        Card::create([
            'name' => $request->name,
            'elixir_cost' => $request->elixir_cost,
            'rarity' => $request->rarity,
            'arena' => $request->arena,
            'image' => $path
        ]);

        return redirect()->route('cards.index');
    }

    public function edit(Card $card)
    {
        Gate::authorize('access-admin');
        return view('cards.edit', ['card' => $card]);
    }

    public function update(Request $request, Card $card)
    {
        Gate::authorize('access-admin');

        $request->validate([
            'name' => 'required|string|max:255',
            'elixir_cost' => 'required|integer|min:1|max:9',
            'rarity' => 'required|string',
            'arena' => 'required|integer',
            'image' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('image')) {
            if ($card->image) {
                Storage::disk('public')->delete($card->image);
            }
            $card->image = $request->file('image')->store('cards', 'public');
        }

        $card->update($request->except('image'));
        if($request->hasFile('image')) {
            $card->save();
        }

        return redirect()->route('cards.index');
    }

    public function destroy(Card $card)
    {
        Gate::authorize('access-admin');

        if ($card->image) {
            Storage::disk('public')->delete($card->image);
        }
        $card->delete();
        return redirect()->route('cards.index');
    }
}
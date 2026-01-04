<?php

namespace App\Http\Controllers;

use App\Models\Deck;
use App\Models\Card;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeckController extends Controller
{

    // Méthode Index pour la galerie publique
    public function index(Request $request)
    {
        $query = Deck::where('is_public', true)
            ->with(['user', 'cards', 'votes'])
            ->withAvg('cards', 'elixir_cost');

        $sort = $request->get('sort', 'created_at');
        $direction = $request->get('direction', 'desc');

        if ($sort === 'avg_cost') {
            $query->orderBy('cards_avg_elixir_cost', $direction);
        } elseif (in_array($sort, ['title', 'created_at'])) {
            $query->orderBy($sort, $direction);
        }

        $decks = $query->paginate(12)->withQueryString();

        return view('welcome', ['decks' => $decks]);
    }

    // Affiche les decks de l'utilisateur connecté
    public function myDecks()
    {
        // Récupérer l'ID de l'utilisateur courant
        $userId = Auth::id();
        // Récupérer les decks où user_id correspond
        $decks = Deck::where('user_id', $userId)->get();

        return view('decks.my-decks', ['decks' => $decks]);
    }

    // Formulaire de création
    public function create()
    {
        // On a besoin de la liste des cartes pour les cocher
        $cards = Card::all();
        return view('decks.create', ['cards' => $cards]);
    }

    // Enregistrement du deck
    public function store(Request $request)
    {
        // Validation des données
        // On s'assure qu'il y a exactement 8 cartes sélectionnées
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'cards' => 'required|array|size:8',
            'is_public' => 'boolean'
        ]);

        // Création du deck
        $deck = Deck::create([
            'title' => $request->title,
            'description' => $request->description,
            'is_public' => $request->has('is_public'), // Checkbox cochée ou non
            'user_id' => Auth::id() // Lier à l'utilisateur connecté
        ]);

        // Gestion de la relation Many-to-Many (Attacher les cartes)
        // Note : attach() est la méthode standard pour remplir la table pivot 'card_deck'
        $deck->cards()->attach($request->cards);

        return redirect('/my-decks');
    }

    // Formulaire de modification
    public function edit(Deck $deck)
    {
        // Vérifier que le deck appartient bien à l'utilisateur (Sécurité basique)
        if ($deck->user_id !== Auth::id()) {
            abort(403);
        }

        $cards = Card::all();
        return view('decks.edit', ['deck' => $deck, 'cards' => $cards]);
    }

    // Mise à jour du deck
    public function update(Request $request, Deck $deck)
    {
        if ($deck->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'cards' => 'required|array|size:8',
        ]);

        // Mise à jour des infos
        $deck->title = $request->title;
        $deck->description = $request->description;
        $deck->is_public = $request->has('is_public');
        $deck->save();

        // Mise à jour des cartes (sync remplace les anciennes relations par les nouvelles)
        $deck->cards()->sync($request->cards);

        return redirect('/my-decks');
    }

    // Suppression
    public function destroy(Deck $deck)
    {
        if ($deck->user_id !== Auth::id()) {
            abort(403);
        }

        $deck->delete();
        return redirect('/my-decks');
    }

    // Méthode nécessaire pour la partie publique
    public function show(Deck $deck)
    {
        if (!$deck->is_public && $deck->user_id !== Auth::id()) {
            abort(403);
        }
        
        $deck->load(['cards', 'user', 'votes']); 
        
        return view('decks.show', ['deck' => $deck]);
    }
    
    public function publicProfile(\App\Models\User $user)
    {
        $decks = $user->decks()
                      ->where('is_public', true)
                      ->with(['cards', 'votes'])
                      ->orderByDesc('created_at')
                      ->get();

        return view('profile.public', [
            'user' => $user,
            'decks' => $decks
        ]);
    }
}


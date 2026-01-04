<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ClashDeck Builder</title>
    
    <link href="https://fonts.bunny.net/css?family=bangers:400" rel="stylesheet" />
    <link href="https://fonts.bunny.net/css?family=verdana:400" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-gray-100">

    @include('layouts.navigation')

    <header class="hero-section">
        <h1 class="hero-title">Les Meilleurs Decks</h1>
        <p class="hero-subtitle">Votez pour vos compositions préférées !</p>
    </header>

        <form action="{{ route('home') }}" method="GET" class="mb-8 flex flex-wrap gap-4 bg-gray-100 p-6 rounded-lg shadow-sm">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Trier par :</label>
                <select name="sort" class="rounded border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="created_at" {{ request('sort') == 'created_at' ? 'selected' : '' }}>Date</option>
                    <option value="title" {{ request('sort') == 'title' ? 'selected' : '' }}>Nom du deck</option>
                    <option value="avg_cost" {{ request('sort') == 'avg_cost' ? 'selected' : '' }}>Coût moyen</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Ordre :</label>
                <select name="direction" class="rounded border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="desc" {{ request('direction') == 'desc' ? 'selected' : '' }}>Décroissant</option>
                    <option value="asc" {{ request('direction') == 'asc' ? 'selected' : '' }}>Croissant</option>
                </select>
            </div>

            <div class="flex items-end">
                <x-primary-button type="submit">
                    {{ __('Filtrer') }}
                </x-primary-button>
            </div>
        </form>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="deck-grid">
            @foreach ($decks as $deck)
            <div class="deck-card">
                
                <div class="card-header">
                    <h3 class="deck-title">{{ $deck->title }}</h3>
                    <div class="deck-meta">
                        <span class="author">
                            par <a href="{{ route('profile.public', $deck->user) }}">{{ $deck->user->name }}</a>
                        </span>
                        <span class="elixir-avg">
                            Moy. <strong>{{ number_format($deck->cards->avg('elixir_cost'), 1) }}</strong>
                        </span>
                    </div>
                </div>

                <div class="card-body">
                    <div class="mini-cards-grid">
                        @foreach($deck->cards->take(8) as $card)
                        <div class="mini-card" title="{{ $card->name }}">
                            @if($card->image)
                                <img src="{{ asset('storage/' . $card->image) }}" alt="{{ $card->name }}" class="mini-card-img">
                            @else
                                <span class="card-name">{{ $card->name }}</span>
                            @endif
                            <span class="elixir-badge">{{ $card->elixir_cost }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="card-desc">
                    "{{ Str::limit($deck->description, 60) }}"
                </div>

                <div class="card-footer">
                    @php
                        $likes = $deck->relationLoaded('votes') ? $deck->votes->where('is_like', true)->count() : 0;
                        $dislikes = $deck->relationLoaded('votes') ? $deck->votes->where('is_like', false)->count() : 0;
                        $score = $likes - $dislikes;
                        
                        $myVote = Auth::check() && $deck->relationLoaded('votes') ? $deck->votes->where('user_id', Auth::id())->first() : null;
                        $hasLiked = $myVote && $myVote->is_like;
                        $hasDisliked = $myVote && !$myVote->is_like;
                    @endphp

                    <div class="score {{ $score >= 0 ? 'text-green-600' : 'text-red-600' }}">
                        Score: {{ $score > 0 ? '+'.$score : $score }}
                    </div>

                    <div class="vote-buttons">
                        @auth
                            <form action="{{ route('votes.store', $deck) }}" method="POST">
                                @csrf <input type="hidden" name="is_like" value="1">
                                <button type="submit" class="btn-vote {{ $hasLiked ? 'active-like' : '' }}">👍 {{ $likes }}</button>
                            </form>
                            <form action="{{ route('votes.store', $deck) }}" method="POST">
                                @csrf <input type="hidden" name="is_like" value="0">
                                <button type="submit" class="btn-vote {{ $hasDisliked ? 'active-dislike' : '' }}">👎 {{ $dislikes }}</button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="login-link">Voter</a>
                        @endauth
                        
                        <a href="{{ route('decks.show', $deck) }}" class="btn-details">Voir</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-8 text-center">
            {{ $decks->links() }}
        </div>
    </div>

    <style>
        body { font-family: 'Verdana', sans-serif; }
        
        .hero-section { background-color: #b22222; color: white; text-align: center; padding: 40px 20px; border-bottom: 4px solid #800000; box-shadow: inset 0 0 20px rgba(0,0,0,0.3); }
        .hero-title { font-family: 'Bangers', cursive; font-size: 3rem; color: #f1c40f; margin: 0; text-shadow: 3px 3px 0 #000; letter-spacing: 2px; }
        .hero-subtitle { font-size: 1.2rem; opacity: 0.9; margin-top: 10px; }

        .deck-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 30px; }
        
        .deck-card { background: white; border: 2px solid #cca046; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.1); transition: transform 0.2s; display: flex; flex-direction: column; }
        .deck-card:hover { transform: translateY(-5px); border-color: #f1c40f; box-shadow: 0 10px 20px rgba(0,0,0,0.15); }

        .card-header { background: #f9f9f9; padding: 15px; border-bottom: 1px solid #eee; }
        .deck-title { margin: 0; color: #b22222; font-size: 1.3rem; font-family: 'Bangers', cursive; letter-spacing: 0.5px; }
        .deck-meta { display: flex; justify-content: space-between; align-items: center; margin-top: 5px; font-size: 0.85rem; color: #666; }
        .deck-meta a { color: #1e90ff; font-weight: bold; text-decoration: none; }
        .elixir-avg { color: #9c27b0; font-weight: bold; }

        .card-body { padding: 15px; background-color: rgba(108, 142, 164, 0.1); flex-grow: 1; }
        .mini-cards-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 5px; }
        .mini-card { background: white; border: 1px solid #ccc; border-radius: 4px; position: relative; height: 50px; display: flex; align-items: center; justify-content: center; overflow: hidden; }
        .mini-card-img { width: 100%; height: 100%; object-fit: contain; }
        .card-name { font-size: 0.65rem; text-align: center; padding: 2px; line-height: 1.1; }
        .elixir-badge { position: absolute; top: 0; right: 0; background: #9c27b0; color: white; width: 14px; height: 14px; border-bottom-left-radius: 4px; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 0.6rem; }

        .card-desc { padding: 12px 15px; font-style: italic; color: #555; font-size: 0.85rem; border-top: 1px solid #eee; background: #fff; }

        .card-footer { padding: 10px 15px; background: #f8f8f8; border-top: 1px solid #eee; display: flex; justify-content: space-between; align-items: center; }
        .score { font-weight: bold; font-size: 1rem; }
        
        .vote-buttons { display: flex; gap: 5px; align-items: center; }
        .vote-buttons form { display: inline-flex; }
        .btn-vote { background: white; border: 1px solid #ddd; padding: 3px 8px; border-radius: 15px; cursor: pointer; font-size: 0.85rem; transition: 0.2s; }
        .btn-vote:hover { background: #eee; transform: scale(1.05); }
        .active-like { background-color: #e6fffa; color: #27ae60; border-color: #27ae60; font-weight: bold; }
        .active-dislike { background-color: #fff5f5; color: #c0392b; border-color: #c0392b; font-weight: bold; }
        .btn-details { background: #333; color: white; padding: 3px 8px; border-radius: 4px; font-size: 0.85rem; text-decoration: none; margin-left: 5px; }
        .login-link { font-size: 0.8rem; color: #1e90ff; text-decoration: underline; }
    </style>
</body>
</html>
<x-app-layout>
    <style>@import url('https://fonts.bunny.net/css?family=bangers:400');</style>

    <div class="profile-page-wrapper">
        <div class="profile-container">
            
            <div class="profile-header-card">
                <div class="profile-content">
                    
                    <div class="profile-avatar">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>

                    <div class="profile-details">
                        <h1 class="profile-name">
                            {{ $user->name }}
                        </h1>
                        
                        @if($user->player_tag)
                            <span class="profile-tag">
                                {{ $user->player_tag }}
                            </span>
                        @else
                            <span class="profile-no-tag">Aucun Tag défini</span>
                        @endif

                        <div class="profile-bio">
                            "{{ $user->bio ?: 'Ce joueur préfère rester mystérieux...' }}"
                        </div>
                        
                        <div class="profile-date">
                            Membre depuis le {{ $user->created_at->format('d/m/Y') }}
                        </div>
                    </div>
                </div>
            </div>

            <h3 class="section-title">
                Decks Publics de {{ $user->name }}
            </h3>

            <div class="decks-grid">
                @forelse($decks as $deck)
                    <div class="deck-card">
                        
                        <div class="deck-header">
                            <h4 class="deck-title">{{ $deck->title }}</h4>
                            
                            @php
                                $likes = $deck->relationLoaded('votes') ? $deck->votes->where('is_like', true)->count() : 0;
                                $dislikes = $deck->relationLoaded('votes') ? $deck->votes->where('is_like', false)->count() : 0;
                                $score = $likes - $dislikes;
                            @endphp
                            <div class="deck-score {{ $score >= 0 ? 'score-pos' : 'score-neg' }}">
                                {{ $score > 0 ? '+' : '' }}{{ $score }} 🏆
                            </div>
                        </div>

                        <div class="deck-body">
                            <div class="deck-stats">
                                <span class="stat-elixir">Moy: {{ number_format($deck->cards->avg('elixir_cost'), 1) }}</span>
                                <span class="stat-count">{{ $deck->cards->count() }} Cartes</span>
                            </div>

                            <p class="deck-desc">
                                "{{ Str::limit($deck->description, 60) }}"
                            </p>
                            
                            <div class="mini-cards">
                                @foreach($deck->cards->take(5) as $card)
                                    <div class="mini-card" title="{{ $card->name }}">
                                        @if($card->image)
                                            <img src="{{ asset('storage/' . $card->image) }}" class="mini-img">
                                        @else
                                            <span>{{ substr($card->name, 0, 2) }}</span>
                                        @endif
                                    </div>
                                @endforeach
                                @if($deck->cards->count() > 5) 
                                    <div class="mini-more">+{{ $deck->cards->count() - 5 }}</div> 
                                @endif
                            </div>
                        </div>

                        <div class="deck-footer">
                            <a href="{{ route('decks.show', $deck) }}" class="btn-view">
                                Voir le Deck →
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="empty-state">
                        <p>Ce joueur n'a pas encore partagé de decks publics.</p>
                    </div>
                @endforelse
            </div>

        </div>
    </div>

    <style>
        .profile-page-wrapper { background-color: #f0f0f0; min-h-screen; padding: 40px 20px; font-family: 'Verdana', sans-serif; }
        .profile-container { max-width: 900px; margin: 0 auto; } /* Largeur contrainte */

        .profile-header-card { 
            background: white; 
            border-radius: 12px; 
            box-shadow: 0 4px 15px rgba(0,0,0,0.1); 
            margin-bottom: 40px; 
            border-left: 8px solid #b22222; 
            overflow: hidden;
        }
        .profile-content { padding: 30px; display: flex; gap: 30px; align-items: flex-start; }
        
        .profile-avatar { 
            width: 100px; height: 100px; flex-shrink: 0;
            background-color: #b22222;
            color: white; 
            border-radius: 50%; 
            display: flex; align-items: center; justify-content: center; 
            font-size: 3rem; font-weight: bold; font-family: 'Bangers', cursive;
            border: 4px solid #fff; 
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
            text-shadow: 2px 2px 0px rgba(0,0,0,0.2);
        }

        .profile-details { flex-grow: 1; }
        .profile-name { margin: 0 0 10px 0; font-size: 2.5rem; color: #333; font-family: 'Bangers', cursive; line-height: 1; }
        
        .profile-tag { 
            background-color: #333; color: #f1c40f; 
            padding: 4px 10px; border-radius: 4px; 
            font-family: monospace; font-weight: bold; font-size: 0.9rem;
            display: inline-block; margin-bottom: 15px;
        }
        .profile-no-tag { color: #999; font-style: italic; font-size: 0.9rem; margin-bottom: 15px; display: block; }

        .profile-bio { 
            background: #f9f9f9; border-left: 4px solid #ddd; 
            padding: 15px; font-style: italic; color: #555; 
            border-radius: 0 8px 8px 0;
        }
        .profile-date { margin-top: 10px; font-size: 0.8rem; color: #aaa; text-transform: uppercase; font-weight: bold; }

        /* Section Decks */
        .section-title { 
            font-family: 'Bangers', cursive; font-size: 2rem; color: #b22222; 
            border-bottom: 4px solid #f1c40f; display: inline-block; 
            margin-bottom: 20px; padding-right: 20px;
        }

        .decks-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 25px; }

        .deck-card { 
            background: white; border: 2px solid #ddd; 
            border-radius: 10px; overflow: hidden; 
            transition: transform 0.2s; display: flex; flex-direction: column;
        }
        .deck-card:hover { border-color: #f1c40f; transform: translateY(-5px); box-shadow: 0 5px 15px rgba(0,0,0,0.1); }

        .deck-header { 
            background: #f8f8f8; padding: 15px; border-bottom: 1px solid #eee; 
            display: flex; justify-content: space-between; align-items: center;
        }
        .deck-title { margin: 0; font-family: 'Bangers', cursive; font-size: 1.4rem; color: #b22222; }
        
        .deck-score { font-weight: bold; font-size: 0.9rem; padding: 2px 8px; border-radius: 10px; border: 1px solid #ccc; background: white; }
        .score-pos { color: green; border-color: green; }
        .score-neg { color: red; border-color: red; }

        .deck-body { padding: 15px; flex-grow: 1; }
        .deck-stats { display: flex; justify-content: space-between; font-size: 0.75rem; color: #888; font-weight: bold; text-transform: uppercase; margin-bottom: 10px; }
        .stat-elixir { color: #9c27b0; }

        .deck-desc { font-style: italic; color: #666; font-size: 0.9rem; margin-bottom: 15px; min-height: 40px; }

        .mini-cards { display: flex; gap: 5px; }
        .mini-card { 
            width: 30px; height: 40px; background: #eee; border: 1px solid #ccc; 
            border-radius: 3px; display: flex; align-items: center; justify-content: center; 
            font-size: 0.6rem; overflow: hidden; 
        }
        .mini-img { width: 100%; height: 100%; object-fit: contain; }
        .mini-more { 
            width: 30px; height: 40px; display: flex; align-items: center; 
            justify-content: center; font-size: 0.8rem; color: #999; font-weight: bold; 
        }

        .deck-footer { padding: 12px; background: #f8f8f8; border-top: 1px solid #eee; text-align: right; }
        .btn-view { 
            background: #333; color: white; text-decoration: none; 
            padding: 8px 15px; border-radius: 5px; font-weight: bold; font-size: 0.9rem; 
            transition: background 0.2s; display: inline-block;
        }
        .btn-view:hover { background: #000; }

        .empty-state { grid-column: 1 / -1; text-align: center; padding: 40px; border: 2px dashed #ccc; border-radius: 10px; color: #888; }

        /* Responsive */
        @media (max-width: 600px) {
            .profile-content { flex-direction: column; text-align: center; align-items: center; }
            .profile-bio { border-left: none; border-top: 4px solid #ddd; border-radius: 0 0 8px 8px; }
        }
    </style>
</x-app-layout>
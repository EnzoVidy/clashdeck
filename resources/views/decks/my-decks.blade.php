<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mes Decks') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="action-bar">
                <a href="{{ route('decks.create') }}" class="btn-create">+ Nouveau Deck</a>
            </div>

            @if($decks->isEmpty())
                <div class="empty-state">
                    <p>Vous n'avez pas encore de deck.</p>
                    <a href="{{ route('decks.create') }}">Créer le premier</a>
                </div>
            @else
                <div class="my-decks-grid">
                    @foreach ($decks as $deck)
                    <div class="my-deck-card">
                        <div class="card-top">
                            <h3>{{ $deck->title }}</h3>
                            <span class="status {{ $deck->is_public ? 'pub' : 'priv' }}">
                                {{ $deck->is_public ? 'Public' : 'Privé' }}
                            </span>
                        </div>
                        
                        <p class="date">Créé le {{ $deck->created_at->format('d/m/Y') }}</p>

                        <div class="mini-list">
                            @foreach($deck->cards->take(8) as $card)
                                <span class="mini-item">{{ $card->name }}</span>
                            @endforeach
                        </div>

                        <div class="card-actions">
                            <a href="{{ route('decks.edit', $deck) }}" class="link-edit">Modifier</a>
                            
                            <form action="{{ route('decks.destroy', $deck) }}" method="POST" onsubmit="return confirm('Sûr ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delete">Supprimer</button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <style>
        .action-bar { margin-bottom: 20px; text-align: right; }
        .btn-create { background: #b22222; color: white; padding: 10px 20px; border-radius: 5px; text-decoration: none; font-weight: bold; }
        .btn-create:hover { background: #900; }

        .empty-state { background: white; padding: 20px; text-align: center; border-radius: 8px; }

        .my-decks-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px; }
        
        .my-deck-card { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); border-left: 5px solid #f1c40f; }
        
        .card-top { display: flex; justify-content: space-between; align-items: center; margin-bottom: 5px; }
        .card-top h3 { margin: 0; color: #333; font-size: 1.2em; }
        
        .status { font-size: 0.8em; padding: 2px 6px; border-radius: 4px; }
        .status.pub { background: #e6fffa; color: green; }
        .status.priv { background: #eee; color: #666; }
        
        .date { font-size: 0.8em; color: #888; margin-bottom: 10px; }

        .mini-list { display: flex; flex-wrap: wrap; gap: 5px; margin-bottom: 15px; }
        .mini-item { font-size: 0.7em; background: #eee; padding: 2px 5px; border-radius: 3px; border: 1px solid #ddd; }

        .card-actions { display: flex; justify-content: space-between; border-top: 1px solid #eee; padding-top: 10px; }
        .link-edit { color: blue; font-weight: bold; }
        .btn-delete { color: red; background: none; border: none; font-weight: bold; cursor: pointer; }
    </style>
</x-app-layout>
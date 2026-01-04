<x-app-layout>
    <style>@import url('https://fonts.bunny.net/css?family=bangers:400');</style>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight" style="font-family: 'Bangers', cursive; letter-spacing: 1px; color: #b22222;">
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
                <a href="{{ route('decks.create') }}" style="color: #b22222; font-weight: bold;">Créer le premier</a>
            </div>
            @else
            <div class="my-decks-grid">
                @foreach ($decks as $deck)
                <div class="my-deck-card">

                    <div class="card-top">
                        <h3 class="deck-title">
                            <a href="{{ route('decks.show', $deck) }}">{{ $deck->title }}</a>
                        </h3>
                        <span class="status {{ $deck->is_public ? 'pub' : 'priv' }}">
                                {{ $deck->is_public ? 'Public' : 'Privé' }}
                            </span>
                    </div>

                    <p class="date">Créé le {{ $deck->created_at->format('d/m/Y') }}</p>

                    <div class="deck-preview-grid">
                        @foreach($deck->cards->take(8) as $card)
                        <div class="mini-card-item">
                            @if($card->image)
                            <img src="{{ asset('storage/' . $card->image) }}" alt="{{ $card->name }}">
                            @else
                            <div class="no-img">?</div>
                            @endif
                            <span class="mini-name">{{ $card->name }}</span>
                        </div>
                        @endforeach
                    </div>

                    <div class="card-actions">
                        <a href="{{ route('decks.edit', $deck) }}" class="link-edit">Modifier</a>

                        <form action="{{ route('decks.destroy', $deck) }}" method="POST" onsubmit="return confirm('Sûr de vouloir supprimer ce deck ?');">
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
        body { font-family: 'Verdana', sans-serif; background-color: #f0f0f0; }

        .action-bar { margin-bottom: 20px; text-align: right; }
        .btn-create { background: #b22222; color: white; padding: 10px 20px; border-radius: 5px; text-decoration: none; font-weight: bold; box-shadow: 0 2px 4px rgba(0,0,0,0.2); transition: 0.2s; }
        .btn-create:hover { background: #900; transform: scale(1.05); }

        .empty-state { background: white; padding: 40px; text-align: center; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }

        .my-decks-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 20px; }

        .my-deck-card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            border-left: 5px solid #f1c40f; /* Bordure jaune style Clash */
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .card-top { display: flex; justify-content: space-between; align-items: start; margin-bottom: 5px; }
        .deck-title { margin: 0; font-size: 1.2em; font-weight: bold; }
        .deck-title a { color: #333; text-decoration: none; transition: 0.2s; }
        .deck-title a:hover { color: #b22222; }

        .status { font-size: 0.75em; padding: 2px 8px; border-radius: 12px; font-weight: bold; text-transform: uppercase; }
        .status.pub { background: #dcfce7; color: #166534; border: 1px solid #86efac; }
        .status.priv { background: #f3f4f6; color: #4b5563; border: 1px solid #d1d5db; }

        .date { font-size: 0.8em; color: #888; margin-bottom: 15px; font-style: italic; }

        /* --- NOUVEAU STYLE POUR LA GRILLE DE CARTES --- */
        .deck-preview-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr); /* 4 cartes par ligne */
            gap: 8px;
            margin-bottom: 20px;
            background-color: #f9fafb;
            padding: 10px;
            border-radius: 6px;
            border: 1px solid #eee;
        }

        .mini-card-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .mini-card-item img {
            height: 40px;
            width: auto;
            object-fit: contain;
            margin-bottom: 2px;
            filter: drop-shadow(0 1px 1px rgba(0,0,0,0.3));
        }

        .mini-card-item .no-img {
            height: 40px; width: 30px; background: #eee;
            display: flex; align-items: center; justify-content: center;
            font-size: 10px; color: #999; border-radius: 3px;
        }

        .mini-name {
            font-size: 0.6rem; /* Texte très petit */
            line-height: 1;
            color: #555;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 100%;
        }

        /* Actions */
        .card-actions { display: flex; justify-content: space-between; border-top: 1px solid #eee; padding-top: 15px; margin-top: auto; }
        .link-edit { color: #2563eb; font-weight: bold; text-decoration: none; font-size: 0.9em; }
        .link-edit:hover { text-decoration: underline; }
        .btn-delete { color: #dc2626; background: none; border: none; font-weight: bold; cursor: pointer; font-size: 0.9em; }
        .btn-delete:hover { color: #991b1b; text-decoration: underline; }
    </style>
</x-app-layout>

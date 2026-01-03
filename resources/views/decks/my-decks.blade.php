<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight clash-header">
            {{ __('Mes Decks') }}
        </h2>
    </x-slot>

    <div class="clash-decks py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-4">
                <a href="{{ route('decks.create') }}" class="btn-create">
                    + Créer un nouveau Deck
                </a>
            </div>

            <div class="decks-container">
                @if($decks->isEmpty())
                <p>Vous n'avez pas encore créé de deck.</p>
                @else
                <table class="decks-table">
                    <thead>
                    <tr>
                        <th>Titre</th>
                        <th>Visibilité</th>
                        <th>Date de création</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($decks as $deck)
                    <tr class="deck-row">
                        <td>{{ $deck->title }}</td>
                        <td>{{ $deck->is_public ? 'Public' : 'Privé' }}</td>
                        <td>{{ $deck->created_at->format('d/m/Y') }}</td>
                        <td class="actions">
                            <a href="{{ route('decks.edit', $deck) }}" class="edit-btn">Modifier</a>
                            <form action="{{ route('decks.destroy', $deck) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="delete-btn">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
                @endif
            </div>
        </div>
    </div>

    <style>
        /* Container général */
        .clash-decks {
            font-family: 'Verdana', sans-serif;
            background: linear-gradient(to bottom, #f9f2e7, #ffd700);
            padding: 20px;
            border-radius: 10px;
            max-width: 1000px;
            margin: auto;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }

        /* Header */
        .clash-header {
            color: #b22222;
            text-shadow: 2px 2px #ffeaa7;
            text-align: center;
        }

        /* Bouton créer */
        .btn-create {
            background-color: #b22222;
            color: #fff;
            font-weight: bold;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            transition: transform 0.2s, background-color 0.2s;
        }
        .btn-create:hover {
            background-color: #ff4500;
            transform: scale(1.05);
        }

        /* Table des decks */
        .decks-table {
            width: 100%;
            border-collapse: collapse;
        }

        .decks-table thead tr {
            background: linear-gradient(to right, #f1c40f, #f39c12);
            color: #fff;
        }

        .decks-table th, .decks-table td {
            padding: 12px;
            text-align: left;
        }

        .deck-row {
            background-color: #fff9e6;
            border: 2px solid #f39c12;
            border-radius: 8px;
            margin-bottom: 10px;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .deck-row:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
        }

        /* Actions */
        .actions {
            display: flex;
            gap: 10px;
        }
        .edit-btn {
            color: #1e90ff;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.2s;
        }
        .edit-btn:hover {
            color: #104e8b;
        }

        .delete-btn {
            color: #ff4500;
            background: none;
            border: none;
            font-weight: bold;
            cursor: pointer;
            transition: color 0.2s, transform 0.2s;
        }
        .delete-btn:hover {
            color: #b22222;
            transform: scale(1.05);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .actions {
                flex-direction: column;
            }
        }
    </style>
</x-app-layout>

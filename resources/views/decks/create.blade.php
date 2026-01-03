<x-app-layout>
    <div class="clash-theme">
        <!-- Top section avec bouton retour et titre -->
        <div class="top-section">
            <a href="{{ route('decks.my') }}" class="btn-back">← Retour</a>
            <h1>Créer un nouveau Deck</h1>
        </div>

        <!-- Affichage des erreurs -->
        @if ($errors->any())
        <ul class="error-list">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
        @endif

        <!-- Formulaire -->
        <form method="POST" action="/decks">
            @csrf
            <label for="title">Nom du Deck</label>
            <input type="text" name="title" id="title" required>

            <label for="description">Description</label>
            <textarea name="description" id="description" required></textarea>

            <label for="is_public">
                <input type="checkbox" name="is_public" id="is_public" value="1">
                Public ?
            </label>

            <h3>Sélectionnez 8 cartes :</h3>
            <div class="cards-container">
                @foreach ($cards as $card)
                <label class="card-item">
                    <input type="checkbox" name="cards[]" value="{{ $card->id }}">
                    <div class="card-content">
                        {{ $card->name }} ({{ $card->elixir_cost }} Elixir)
                    </div>
                </label>
                @endforeach
            </div>

            <button type="submit" class="btn-submit">Créer le Deck</button>
        </form>
    </div>

    <style>
        /* Container général */
        .clash-theme {
            font-family: 'Verdana', sans-serif;
            background: linear-gradient(to bottom, #f9f2e7, #ffd700);
            padding: 20px;
            border-radius: 10px;
            max-width: 900px;
            margin: auto;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }

        /* Top section */
        .top-section {
            display: flex;
            align-items: center;
            gap: 20px;
            margin-bottom: 20px;
        }

        .top-section h1 {
            color: #b22222;
            text-shadow: 2px 2px #ffeaa7;
            margin: 0;
        }

        /* Bouton retour */
        .btn-back {
            background-color: #b22222;
            color: #fff;
            font-weight: bold;
            padding: 8px 15px;
            border-radius: 8px;
            text-decoration: none;
            transition: transform 0.2s, background-color 0.2s;
        }
        .btn-back:hover {
            background-color: #ff4500;
            transform: scale(1.05);
        }

        /* Erreurs */
        .error-list {
            background-color: #ffe6e6;
            border: 1px solid #ff4d4d;
            padding: 10px;
            border-radius: 5px;
            color: #900;
            list-style-type: square;
            margin-bottom: 20px;
        }

        /* Formulaire */
        .clash-theme label {
            display: block;
            margin: 10px 0 5px;
            font-weight: bold;
            color: #333;
        }

        .clash-theme input[type="text"],
        .clash-theme textarea {
            width: 100%;
            padding: 8px;
            border: 2px solid #f1c40f;
            border-radius: 5px;
            margin-bottom: 15px;
        }

        .clash-theme input[type="checkbox"] {
            margin-right: 5px;
        }

        /* Sélection des cartes */
        .cards-container {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 20px;
        }

        .card-item {
            flex: 0 0 150px;
            border: 2px solid #f39c12;
            border-radius: 8px;
            padding: 10px;
            text-align: center;
            background-color: #fff9e6;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
        }

        .card-item input[type="checkbox"] {
            display: none;
        }

        .card-item input[type="checkbox"]:checked + .card-content {
            background-color: #ffd700;
            border-radius: 5px;
            padding: 5px;
            font-weight: bold;
            color: #b22222;
        }

        /* Bouton soumission */
        .btn-submit {
            display: block;
            width: 100%;
            padding: 12px;
            background-color: #b22222;
            color: #fff;
            font-weight: bold;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.2s, transform 0.2s;
        }
        .btn-submit:hover {
            background-color: #ff4500;
            transform: scale(1.05);
        }
    </style>
</x-app-layout>

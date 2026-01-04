<x-app-layout>
    <style>@import url('https://fonts.bunny.net/css?family=bangers:400');</style>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="header-section">
                <a href="{{ route('decks.my') }}" class="btn-back">← Annuler</a>
                <h1 class="page-title">Modifier : {{ $deck->title }}</h1>
            </div>

            @if ($errors->any())
            <div class="error-box">
                <p><strong>Oups ! Il y a un problème :</strong></p>
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <div class="form-container">
                <form method="POST" action="{{ route('decks.update', $deck) }}">
                    @csrf
                    @method('PATCH')

                    <div class="form-group">
                        <label for="title">Nom du Deck</label>
                        <input type="text" name="title" id="title" required value="{{ old('title', $deck->title) }}">
                    </div>

                    <div class="form-group">
                        <label for="description">Stratégie / Description</label>
                        <textarea name="description" id="description" rows="3" required>{{ old('description', $deck->description) }}</textarea>
                    </div>

                    <div class="form-group checkbox-group">
                        <input type="checkbox" name="is_public" id="is_public" value="1"
                               {{ old('is_public', $deck->is_public) ? 'checked' : '' }}>
                        <label for="is_public">Rendre ce deck public</label>
                    </div>

                    <hr>

                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                        <h3 class="section-title" style="margin:0;">Modifier la composition (8 cartes)</h3>
                        <span id="card-counter" style="background: #b22222; color: white; padding: 5px 15px; border-radius: 20px; font-weight: bold;">0 / 8</span>
                    </div>

                    <div class="cards-selection-grid">
                        @foreach ($cards as $card)
                        @php
                        // Logique pour déterminer si la case est cochée :
                        // 1. Si on a une erreur de validation (old inputs), on regarde old()
                        // 2. Sinon, on regarde si la carte est dans le deck existant ($deck->cards)
                        $isChecked = false;
                        if (old('_token')) { // Le formulaire a été soumis
                        $isChecked = is_array(old('cards')) && in_array($card->id, old('cards'));
                        } else { // Premier chargement de la page
                        $isChecked = $deck->cards->contains($card->id);
                        }
                        @endphp

                        <label class="card-option">
                            <input type="checkbox" name="cards[]" value="{{ $card->id }}" class="card-checkbox"
                                   {{ $isChecked ? 'checked' : '' }}>

                            <div class="card-visual">
                                <div class="elixir-bubble">{{ $card->elixir_cost }}</div>

                                @if($card->image)
                                <img src="{{ asset('storage/' . $card->image) }}" alt="{{ $card->name }}" class="card-img">
                                @else
                                <div class="no-image-placeholder">No Image</div>
                                @endif

                                <span class="card-name">{{ $card->name }}</span>
                                <span class="card-rarity">{{ $card->rarity }}</span>
                            </div>
                        </label>
                        @endforeach
                    </div>

                    <button type="submit" class="btn-submit">ENREGISTRER LES MODIFICATIONS</button>
                </form>
            </div>
        </div>
    </div>

    {{-- SCRIPT JAVASCRIPT POUR LIMITER A 8 --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const checkboxes = document.querySelectorAll('.card-checkbox');
            const counterDisplay = document.getElementById('card-counter');
            const limit = 8;

            function updateState() {
                const checkedCount = document.querySelectorAll('.card-checkbox:checked').length;
                counterDisplay.textContent = checkedCount + " / " + limit;

                checkboxes.forEach(cb => {
                    if (!cb.checked) {
                        cb.disabled = checkedCount >= limit;
                        // Ajout du style curseur
                        if(checkedCount >= limit) {
                            cb.parentElement.style.cursor = 'not-allowed';
                        } else {
                            cb.parentElement.style.cursor = 'pointer';
                        }
                    }
                });

                if (checkedCount === limit) {
                    counterDisplay.style.backgroundColor = '#22c55e'; // Vert
                } else {
                    counterDisplay.style.backgroundColor = '#b22222'; // Rouge
                }
            }

            checkboxes.forEach(cb => {
                cb.addEventListener('change', updateState);
            });

            // Lancer immédiatement pour prendre en compte les cartes déjà présentes dans le deck
            updateState();
        });
    </script>

    <style>
        /* CSS GLOBAL */
        body { font-family: 'Verdana', sans-serif; background-color: #f0f0f0; }
        .header-section { display: flex; align-items: center; gap: 20px; margin-bottom: 20px; }
        .page-title { font-family: 'Bangers', cursive; font-size: 2.5rem; color: #b22222; letter-spacing: 1px; margin: 0; }
        .btn-back { color: #666; text-decoration: none; font-weight: bold; }
        .error-box { background: #fee2e2; border-left: 5px solid #ef4444; color: #b91c1c; padding: 15px; margin-bottom: 20px; border-radius: 5px; }
        .error-box ul { list-style: disc; margin-left: 20px; }
        .form-container { background: white; padding: 30px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); border-top: 5px solid #f1c40f; }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; font-weight: bold; margin-bottom: 5px; color: #333; }
        input[type="text"], textarea { width: 100%; padding: 10px; border: 2px solid #ddd; border-radius: 5px; font-size: 1rem; box-sizing: border-box; }
        input[type="text"]:focus, textarea:focus { border-color: #b22222; outline: none; }
        .checkbox-group { display: flex; align-items: center; gap: 10px; }
        .checkbox-group input { width: 20px; height: 20px; accent-color: #b22222; }
        .checkbox-group label { margin: 0; cursor: pointer; }
        hr { margin: 30px 0; border: 0; border-top: 1px solid #eee; }
        .section-title { color: #b22222; margin-bottom: 15px; font-size: 1.2rem; }
        .btn-submit { display: block; width: 100%; background-color: #b22222; color: white; font-size: 1.2rem; font-weight: bold; padding: 15px; border: none; border-radius: 8px; cursor: pointer; margin-top: 30px; transition: 0.2s; border-bottom: 4px solid #800000; }
        .btn-submit:hover { background-color: #d00000; transform: scale(1.01); }

        /* GRID CARTES */
        .cards-selection-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(130px, 1fr));
            gap: 1rem;
            max-height: 600px;
            overflow-y: auto;
            padding: 10px;
            border: 1px solid #eee;
            border-radius: 5px;
            background-color: #f9fafb;
        }

        .card-option { cursor: pointer; position: relative; }
        .card-option input[type="checkbox"] { position: absolute; opacity: 0; cursor: pointer; height: 0; width: 0; }

        .card-visual {
            background-color: white;
            border: 2px solid #d1d5db;
            border-radius: 0.5rem;
            padding: 0.75rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            position: relative;
            box-shadow: 0 1px 2px rgba(0,0,0,0.05);
            transition: all 0.2s ease;
            height: 100%;
        }

        .card-visual:hover { border-color: #f1c40f; transform: translateY(-2px); }

        /* ETAT SÉLECTIONNÉ */
        .card-option input:checked + .card-visual {
            border-color: #b22222;
            background-color: #fff1f2;
            box-shadow: 0 0 0 3px #b22222;
            transform: translateY(-4px);
        }

        /* ETAT DÉSACTIVÉ */
        .card-option input:disabled + .card-visual {
            opacity: 0.5;
            filter: grayscale(100%);
            cursor: not-allowed;
            transform: none !important;
            border-color: #e5e7eb;
        }

        /* Éléments internes */
        .elixir-bubble { position: absolute; top: -8px; right: -8px; background-color: #9333ea; color: white; font-size: 0.75rem; font-weight: bold; width: 24px; height: 24px; display: flex; align-items: center; justify-content: center; border-radius: 50%; border: 2px solid white; box-shadow: 0 2px 4px rgba(0,0,0,0.2); z-index: 10; }
        .card-img { height: 5rem; margin-bottom: 0.5rem; object-fit: contain; filter: drop-shadow(0 2px 2px rgba(0,0,0,0.3)); }
        .no-image-placeholder { height: 5rem; width: 100%; background-color: #f3f4f6; margin-bottom: 0.5rem; display: flex; align-items: center; justify-content: center; color: #9ca3af; font-size: 0.75rem; border-radius: 0.25rem; }
        .card-name { font-weight: bold; color: #1f2937; font-size: 0.85rem; line-height: 1.2; }
        .card-rarity { font-size: 0.7rem; color: #6b7280; margin-top: 2px; text-transform: capitalize; }
    </style>
</x-app-layout>

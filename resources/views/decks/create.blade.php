<x-app-layout>
    <style>@import url('https://fonts.bunny.net/css?family=bangers:400');</style>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="header-section">
                <a href="{{ route('decks.my') }}" class="btn-back">← Annuler</a>
                <h1 class="page-title">Forges ton Deck</h1>
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
                <form method="POST" action="/decks">
                    @csrf

                    <div class="form-group">
                        <label for="title">Nom du Deck</label>
                        <input type="text" name="title" id="title" placeholder="Ex: Hog Rider Cycle" required value="{{ old('title') }}">
                    </div>

                    <div class="form-group">
                        <label for="description">Stratégie / Description</label>
                        <textarea name="description" id="description" rows="3" placeholder="Comment jouer ce deck..." required>{{ old('description') }}</textarea>
                    </div>

                    <div class="form-group checkbox-group">
                        <input type="checkbox" name="is_public" id="is_public" value="1" {{ old('is_public') ? 'checked' : '' }}>
                        <label for="is_public">Rendre ce deck public (visible par tous)</label>
                    </div>

                    <hr>

                    <h3 class="section-title">Sélectionnez exactement 8 cartes</h3>
                    
                    <div class="cards-selection-grid">
                        @foreach ($cards as $card)
                        <label class="card-option">
                            <input type="checkbox" name="cards[]" value="{{ $card->id }}" 
                                {{ (is_array(old('cards')) && in_array($card->id, old('cards'))) ? 'checked' : '' }}>
                            
                            <div class="card-visual">
                                <span class="card-name">{{ $card->name }}</span>
                                <span class="card-elixir">{{ $card->elixir_cost }}</span>
                            </div>
                        </label>
                        @endforeach
                    </div>

                    <button type="submit" class="btn-submit">CRÉER LE DECK</button>
                </form>
            </div>
        </div>
    </div>

    <style>
        /* Mise en page globale */
        body { font-family: 'Verdana', sans-serif; background-color: #f0f0f0; }
        
        .header-section { display: flex; align-items: center; gap: 20px; margin-bottom: 20px; }
        .page-title { font-family: 'Bangers', cursive; font-size: 2.5rem; color: #b22222; letter-spacing: 1px; margin: 0; }
        .btn-back { color: #666; text-decoration: none; font-weight: bold; }
        .btn-back:hover { color: #333; }

        /* Erreurs */
        .error-box { background: #fee2e2; border-left: 5px solid #ef4444; color: #b91c1c; padding: 15px; margin-bottom: 20px; border-radius: 5px; }
        .error-box ul { list-style: disc; margin-left: 20px; }

        /* Formulaire */
        .form-container { background: white; padding: 30px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); border-top: 5px solid #f1c40f; }
        
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; font-weight: bold; margin-bottom: 5px; color: #333; }
        
        /* Inputs textuels */
        input[type="text"], textarea { 
            width: 100%; padding: 10px; border: 2px solid #ddd; border-radius: 5px; font-size: 1rem; box-sizing: border-box; 
        }
        input[type="text"]:focus, textarea:focus { border-color: #b22222; outline: none; }

        /* Checkbox Public */
        .checkbox-group { display: flex; align-items: center; gap: 10px; }
        .checkbox-group input { width: 20px; height: 20px; accent-color: #b22222; }
        .checkbox-group label { margin: 0; cursor: pointer; }

        hr { margin: 30px 0; border: 0; border-top: 1px solid #eee; }
        .section-title { color: #b22222; margin-bottom: 15px; font-size: 1.2rem; }

        /* Grille de sélection des cartes */
        .cards-selection-grid { 
            display: grid; 
            grid-template-columns: repeat(auto-fill, minmax(100px, 1fr)); 
            gap: 10px; 
            max-height: 400px; 
            overflow-y: auto; 
            padding: 5px; 
            border: 1px solid #eee; 
            border-radius: 5px; 
        }

        .card-option { cursor: pointer; position: relative; }
        
        /* On cache la checkbox par défaut */
        .card-option input[type="checkbox"] { position: absolute; opacity: 0; cursor: pointer; height: 0; width: 0; }

        /* Apparence de la carte non sélectionnée */
        .card-visual { 
            border: 2px solid #ddd; 
            border-radius: 8px; 
            padding: 10px; 
            text-align: center; 
            background: #f9f9f9; 
            transition: 0.2s; 
            height: 80px;
            display: flex; 
            flex-direction: column; 
            justify-content: center; 
            align-items: center;
        }

        .card-visual:hover { border-color: #f1c40f; transform: translateY(-2px); }

        .card-option input:checked + .card-visual {
            border-color: #b22222;
            background-color: #fff5f5;
            box-shadow: 0 0 0 2px #b22222;
            font-weight: bold;
        }

        .card-name { font-size: 0.8rem; display: block; line-height: 1.2; }
        .card-elixir { 
            background: #d0f; color: white; font-size: 0.7rem; 
            padding: 2px 6px; border-radius: 10px; margin-top: 5px; 
        }

        .btn-submit { 
            display: block; width: 100%; background-color: #b22222; color: white; 
            font-size: 1.2rem; font-weight: bold; padding: 15px; border: none; 
            border-radius: 8px; cursor: pointer; margin-top: 30px; transition: 0.2s; 
            border-bottom: 4px solid #800000;
        }
        .btn-submit:hover { background-color: #d00000; transform: scale(1.01); }

    </style>
</x-app-layout>
<x-app-layout>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-12">
        <div class="flex justify-between items-center mb-6">
            <div class="flex items-center gap-4">
                <a href="{{ route('home') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 transition ease-in-out duration-150">
                    {{ __('Retour Accueil') }}
                </a>
                <h1 class="text-3xl font-bold">Liste des Cartes</h1>
            </div>

            @can('access-admin')
                <a href="{{ route('cards.create') }}" class="bg-blue-500 text-black px-4 py-2 rounded shadow hover:bg-blue-600">
                    Ajouter une carte
                </a>
            @endcan
        </div>

        <form action="{{ route('cards.index') }}" method="GET" class="mb-6 flex flex-wrap gap-4 bg-gray-100 p-4 rounded">
            <div>
                <label class="block text-sm font-medium">Trier par :</label>
                <select name="sort" class="rounded border-gray-300 shadow-sm">
                    <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Nom</option>
                    <option value="elixir_cost" {{ request('sort') == 'elixir_cost' ? 'selected' : '' }}>Coût élixir</option>
                    <option value="created_at" {{ request('sort') == 'created_at' ? 'selected' : '' }}>Date d'ajout</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium">Ordre :</label>
                <select name="direction" class="rounded border-gray-300 shadow-sm">
                    <option value="asc" {{ request('direction') == 'asc' ? 'selected' : '' }}>Croissant</option>
                    <option value="desc" {{ request('direction') == 'desc' ? 'selected' : '' }}>Décroissant</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium">Rareté :</label>
                <select name="rarity" class="rounded border-gray-300 shadow-sm">
                    <option value="">Toutes</option>
                    <option value="Commune" {{ request('rarity') == 'Commune' ? 'selected' : '' }}>Commune</option>
                    <option value="Rare" {{ request('rarity') == 'Rare' ? 'selected' : '' }}>Rare</option>
                    <option value="Épique" {{ request('rarity') == 'Épique' ? 'selected' : '' }}>Épique</option>
                    <option value="Légendaire" {{ request('rarity') == 'Légendaire' ? 'selected' : '' }}>Légendaire</option>
                    <option value="Champion" {{ request('rarity') == 'Champion' ? 'selected' : '' }}>Champion</option>
                </select>
            </div>

            <div class="flex items-end">
                <x-primary-button type="submit">Filtrer</x-primary-button>
            </div>
        </form>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach($cards as $card)
                <div class="bg-white p-4 rounded shadow flex items-center justify-between">
                    <div class="flex-1 text-left">
                        <h2 class="font-bold text-lg">{{ $card->name }}</h2>
                        <p class="text-sm">Coût: {{ $card->elixir_cost }} | Arène: {{ $card->arena }}</p>
                        <p class="text-sm text-gray-500">{{ $card->rarity }}</p>
                    </div>

                    <div class="flex-1 flex justify-center">
                        @if($card->image)
                            <img src="{{ asset('storage/' . $card->image) }}" 
                                 alt="{{ $card->name }}" 
                                 class="h-16 object-contain">
                        @endif
                    </div>

                    <div class="flex-1 flex justify-end">
                        @can('access-admin')
                            <div class="flex items-center gap-3">
                                <a href="{{ route('cards.edit', $card) }}" class="text-yellow-600 font-bold hover:underline text-sm leading-none">
                                    Modifier
                                </a>

                                <form action="{{ route('cards.destroy', $card) }}" method="POST" onsubmit="return confirm('Supprimer cette carte ?')" class="inline-flex items-center">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 font-bold hover:underline text-sm leading-none">
                                        Supprimer
                                    </button>
                                </form>
                            </div>
                        @else
                            <div class="w-20"></div>
                        @endcan
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
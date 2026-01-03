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

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @foreach($cards as $card)
                <div class="bg-white p-4 rounded shadow text-center">
                    @if($card->image)
                         <img src="{{ asset('storage/' . $card->image) }}" alt="{{ $card->name }}" class="h-32 mx-auto mb-2 object-contain">
                    @endif
                    <h2 class="font-bold">{{ $card->name }}</h2>
                    <p>Coût: {{ $card->elixir_cost }} | Arène: {{ $card->arena }}</p>
                    <p class="text-sm text-gray-500">{{ $card->rarity }}</p>

                    @can('access-admin')
                        <div class="mt-2 flex justify-center gap-2">
                            <a href="{{ route('cards.edit', $card) }}" class="text-yellow-600 font-bold">Modifier</a>
                            <form action="{{ route('cards.destroy', $card) }}" method="POST" onsubmit="return confirm('Supprimer cette carte ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 font-bold">Supprimer</button>
                            </form>
                        </div>
                    @endcan
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
<x-app-layout>
    <div class="max-w-7xl mx-auto py-12">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <div class="flex items-center gap-4 mb-6">
                <a href="{{ route('cards.index') }}" class="text-gray-600 hover:text-gray-900">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
                <h1 class="text-2xl font-bold">Modifier la carte : {{ $card->name }}</h1>
            </div>

            <form action="{{ route('cards.update', $card) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <div class="mb-4">
                    <x-input-label for="name" value="Nom de la carte" />
                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $card->name)" required />
                </div>

                <div class="mb-4">
                    <x-input-label for="elixir_cost" value="Coût en élixir" />
                    <x-text-input id="elixir_cost" name="elixir_cost" type="number" min="1" max="9" class="mt-1 block w-full" :value="old('elixir_cost', $card->elixir_cost)" required />
                </div>

                <div class="mb-4">
                    <x-input-label for="rarity" value="Rareté" />
                    <select name="rarity" id="rarity" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full">
                        @foreach(['Commune', 'Rare', 'Épique', 'Légendaire', 'Champion'] as $rarity)
                            <option value="{{ $rarity }}" {{ $card->rarity == $rarity ? 'selected' : '' }}>{{ $rarity }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <x-input-label for="arena" value="Arène" />
                    <x-text-input id="arena" name="arena" type="number" class="mt-1 block w-full" :value="old('arena', $card->arena)" required />
                </div>

                <div class="mb-6">
                    <x-input-label for="image" value="Changer l'image (optionnel)" />
                    @if($card->image)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $card->image) }}" alt="Image actuelle" class="h-20">
                            <p class="text-xs text-gray-500">Image actuelle</p>
                        </div>
                    @endif
                    <input type="file" name="image" id="image" class="mt-1 block w-full">
                </div>

                <div class="flex items-center gap-4">
                    <x-primary-button>
                        {{ __('Mettre à jour') }}
                    </x-primary-button>

                    <a href="{{ route('cards.index') }}" class="text-sm text-gray-600 hover:text-gray-900 underline">
                        Annuler
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
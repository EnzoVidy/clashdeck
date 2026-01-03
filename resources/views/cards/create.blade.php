<x-app-layout>
    <div class="max-w-7xl mx-auto py-12">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <h1 class="text-2xl font-bold mb-6">Ajouter une nouvelle carte</h1>

            <form action="{{ route('cards.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-4">
                    <x-input-label for="name" value="Nom de la carte" />
                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" required />
                </div>

                <div class="mb-4">
                    <x-input-label for="elixir_cost" value="Coût en élixir" />
                    <x-text-input id="elixir_cost" name="elixir_cost" type="number" min="1" max="9" class="mt-1 block w-full" required />
                </div>

                <div class="mb-4">
                    <x-input-label for="rarity" value="Rareté" />
                    <select name="rarity" id="rarity" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full">
                        <option value="Commune">Commune</option>
                        <option value="Rare">Rare</option>
                        <option value="Épique">Épique</option>
                        <option value="Légendaire">Légendaire</option>
                        <option value="Champion">Champion</option>
                    </select>
                </div>

                <div class="mb-4">
                    <x-input-label for="arena" value="Arène" />
                    <x-text-input id="arena" name="arena" type="number" class="mt-1 block w-full" required />
                </div>

                <div class="mb-6">
                    <x-input-label for="image" value="Image de la carte" />
                    <input type="file" name="image" id="image" class="mt-1 block w-full">
                </div>

                <div class="flex items-center gap-4">
                    <x-primary-button>
                        {{ __('Enregistrer la carte') }}
                    </x-primary-button>

                    <a href="{{ route('cards.index') }}" class="text-gray-600 hover:text-gray-900">Annuler</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
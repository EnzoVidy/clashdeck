<x-app-layout>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-12">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold">{{ $deck->title }}</h1>
                <span class="text-sm text-gray-500">Créé par {{ $deck->user->name }}</span>
            </div>
            
            <p class="mb-8 text-gray-700">{{ $deck->description }}</p>

            <h3 class="text-xl font-semibold mb-4">Cartes du deck (Coût moyen : {{ $deck->cards->avg('elixir_cost') }})</h3>
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach($deck->cards as $card)
                    <div class="border rounded p-4 flex flex-col items-center text-center">
                        @if($card->image)
                            <img src="{{ asset('storage/' . $card->image) }}" alt="{{ $card->name }}" class="h-24 mb-2 object-contain">
                        @else
                            <div class="h-24 w-24 bg-gray-200 mb-2 flex items-center justify-center">Pas d'image</div>
                        @endif
                        <span class="font-bold">{{ $card->name }}</span>
                        <span class="text-purple-600 text-sm">{{ $card->elixir_cost }} Elixir</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
<x-app-layout>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-12">
        <h1 class="text-3xl font-bold mb-6">Galerie des Decks</h1>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($decks as $deck)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h2 class="text-xl font-bold">{{ $deck->title }}</h2>
                    <p class="text-sm text-gray-500 mb-4">Par {{ $deck->user->name }}</p>
                    <p class="mb-4">{{ Str::limit($deck->description, 100) }}</p>
                    <a href="{{ route('decks.show', $deck) }}" class="text-blue-500 hover:underline">
                        Voir le deck
                    </a>
                </div>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $decks->links() }}
        </div>
    </div>
</x-app-layout>
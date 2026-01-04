<x-app-layout>
    <style>@import url('https://fonts.bunny.net/css?family=bangers:400');</style>

    <div class="py-12" style="background-color: #f0f0f0; min-h-screen;">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border-t-4 border-[#b22222]">
                
                <div class="p-6 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
                    <div>
                        <h1 class="text-3xl font-bold text-[#b22222]" style="font-family: 'Bangers', cursive;">
                            {{ $deck->title }}
                        </h1>
                        <p class="text-sm text-gray-500 mt-1">
                            Créé par <a href="{{ route('profile.public', $deck->user) }}" class="text-blue-600 hover:underline font-bold">{{ $deck->user->name }}</a>
                            le {{ $deck->created_at->format('d/m/Y') }}
                        </p>
                    </div>
                    
                    @can('update-deck', $deck)
                        <a href="{{ route('decks.edit', $deck) }}" style="background-color: #facc15; color: black; padding: 8px 16px; border-radius: 4px; font-weight: bold; text-decoration: none; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                            Modifier
                        </a>
                    @endcan
                </div>

                <div class="p-6 bg-white">
                    <div class="p-4 bg-yellow-50 border-l-4 border-[#f1c40f] text-gray-700 italic">
                        "{{ $deck->description }}"
                    </div>
                </div>

                <div style="background-color: #f3f4f6; padding: 1.5rem;">
                    <h3 style="font-size: 1.25rem; font-weight: bold; margin-bottom: 1rem; display: flex; align-items: center;">
                        Composition de l'armée 
                        <span style="margin-left: 0.75rem; font-size: 0.875rem; background-color: #f3e8ff; color: #7e22ce; padding: 2px 8px; border-radius: 9999px; border: 1px solid #d8b4fe;">
                            Coût moyen : {{ number_format($deck->cards->avg('elixir_cost'), 1) }}
                        </span>
                    </h3>
                    
                    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1rem;">
                        @foreach($deck->cards as $card)
                            <div style="background-color: white; border: 2px solid #d1d5db; border-radius: 0.5rem; padding: 0.75rem; display: flex; flex-direction: column; align-items: center; text-align: center; position: relative; box-shadow: 0 1px 2px rgba(0,0,0,0.05); transition: 0.2s;"
                                onmouseover="this.style.borderColor='#b22222'; this.style.transform='translateY(-2px)'"
                                onmouseout="this.style.borderColor='#d1d5db'; this.style.transform='translateY(0)'">
                                
                                <div style="position: absolute; top: -5px; right: -5px; background-color: #9333ea; color: white; font-size: 0.75rem; font-weight: bold; width: 24px; height: 24px; display: flex; align-items: center; justify-content: center; border-radius: 50%; border: 2px solid white; box-shadow: 0 2px 4px rgba(0,0,0,0.2); z-index: 10;">
                                    {{ $card->elixir_cost }}
                                </div>

                                @if($card->image)
                                    <img src="{{ asset('storage/' . $card->image) }}" alt="{{ $card->name }}" style="height: 6rem; margin-bottom: 0.5rem; object-fit: contain; filter: drop-shadow(0 2px 2px rgba(0,0,0,0.3));">
                                @else
                                    <div style="height: 6rem; width: 100%; background-color: #f3f4f6; margin-bottom: 0.5rem; display: flex; align-items: center; justify-content: center; color: #9ca3af; font-size: 0.75rem; border-radius: 0.25rem;">
                                        No Image
                                    </div>
                                @endif
                                
                                <span style="font-weight: bold; color: #1f2937; font-size: 0.875rem; line-height: 1.2;">{{ $card->name }}</span>
                                <span style="font-size: 0.75rem; color: #6b7280; margin-top: 2px;">{{ $card->rarity }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div style="background-color: #333333; color: white; text-align: center; padding: 24px;">
                    <h3 style="color: #f1c40f; font-weight: bold; font-size: 1.25rem; margin-bottom: 16px;">
                        Que pensez-vous de ce deck ?
                    </h3>
                    
                    @php
                        $likes = $deck->votes->where('is_like', true)->count();
                        $dislikes = $deck->votes->where('is_like', false)->count();
                        
                        $myVote = Auth::check() ? $deck->votes->where('user_id', Auth::id())->first() : null;
                        $hasLiked = $myVote && $myVote->is_like;
                        $hasDisliked = $myVote && !$myVote->is_like;
                    @endphp

                    <div class="flex justify-center gap-6">
                        @auth
                            <form action="{{ route('votes.store', $deck) }}" method="POST">
                                @csrf <input type="hidden" name="is_like" value="1">
                                <button type="submit" 
                                    style="padding: 10px 24px; border-radius: 9999px; font-weight: bold; cursor: pointer; transition: transform 0.2s; border: none;
                                    {{ $hasLiked ? 'background-color: #22c55e; color: white; border: 2px solid white;' : 'background-color: #4b5563; color: #4ade80;' }}"
                                    onmouseover="this.style.transform='scale(1.05)'" 
                                    onmouseout="this.style.transform='scale(1)'">
                                    👍 J'aime ({{ $likes }})
                                </button>
                            </form>

                            <form action="{{ route('votes.store', $deck) }}" method="POST">
                                @csrf <input type="hidden" name="is_like" value="0">
                                <button type="submit" 
                                    style="padding: 10px 24px; border-radius: 9999px; font-weight: bold; cursor: pointer; transition: transform 0.2s; border: none;
                                    {{ $hasDisliked ? 'background-color: #ef4444; color: white; border: 2px solid white;' : 'background-color: #4b5563; color: #f87171;' }}"
                                    onmouseover="this.style.transform='scale(1.05)'" 
                                    onmouseout="this.style.transform='scale(1)'">
                                    👎 Bof ({{ $dislikes }})
                                </button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" style="color: #f1c40f; text-decoration: underline;">
                                Connectez-vous pour voter
                            </a>
                        @endauth
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
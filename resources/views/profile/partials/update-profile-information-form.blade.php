<section style="background-color: white; padding: 1.5rem; border-radius: 0.5rem; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); border-top: 4px solid #b22222;">
    <header>
        <h2 style="font-family: 'Bangers', cursive; letter-spacing: 1px; color: #b22222; font-size: 1.5rem; font-weight: 500;">
            {{ __('Informations du Profil') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Mettez à jour les informations de votre compte, votre pseudo de joueur et votre email.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <label for="name" class="block font-bold text-gray-700 mb-1">{{ __('Nom d\'utilisateur') }}</label>
            <input id="name" name="name" type="text" 
                   style="width: 100%; border: 2px solid #d1d5db; padding: 0.5rem; border-radius: 0.5rem;"
                   class="focus:outline-none focus:border-red-600 transition" 
                   value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <label for="player_tag" class="block font-bold text-gray-700 mb-1">{{ __('Tag Joueur (ex: #J89PLLQR)') }}</label>
            <input id="player_tag" name="player_tag" type="text" 
                   style="width: 100%; border: 2px solid #d1d5db; padding: 0.5rem; border-radius: 0.5rem; text-transform: uppercase; font-family: monospace;"
                   class="focus:outline-none focus:border-red-600 transition" 
                   value="{{ old('player_tag', $user->player_tag) }}" />
            <x-input-error class="mt-2" :messages="$errors->get('player_tag')" />
        </div>

        <div>
            <label for="bio" class="block font-bold text-gray-700 mb-1">{{ __('Biographie') }}</label>
            <textarea id="bio" name="bio" rows="3" 
                      style="width: 100%; border: 2px solid #d1d5db; padding: 0.5rem; border-radius: 0.5rem;"
                      class="focus:outline-none focus:border-red-600 transition" 
                      placeholder="Parlez-nous de votre style de jeu...">{{ old('bio', $user->bio) }}</textarea>
            <x-input-error class="mt-2" :messages="$errors->get('bio')" />
        </div>

        <div>
            <label for="email" class="block font-bold text-gray-700 mb-1">{{ __('Adresse Email') }}</label>
            <input id="email" name="email" type="email" 
                   style="width: 100%; border: 2px solid #d1d5db; padding: 0.5rem; border-radius: 0.5rem;"
                   class="focus:outline-none focus:border-red-600 transition" 
                   value="{{ old('email', $user->email) }}" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Votre adresse email n\'est pas vérifiée.') }}

                        <button form="send-verification" style="color: #b22222; text-decoration: underline;" class="text-sm hover:text-red-800 rounded-md focus:outline-none">
                            {{ __('Cliquez ici pour renvoyer l\'email de vérification.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('Un nouveau lien de vérification a été envoyé à votre adresse email.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" 
                    style="background-color: #b22222; color: white; font-weight: bold; padding: 10px 24px; border-radius: 0.25rem; border-bottom: 4px solid #800000; cursor: pointer;"
                    class="shadow hover:opacity-90 transition active:border-0 active:translate-y-1">
                {{ __('SAUVEGARDER') }}
            </button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-green-600 font-bold"
                >{{ __('Modifications enregistrées.') }}</p>
            @endif
        </div>
    </form>
</section>
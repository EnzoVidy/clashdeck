<section style="background-color: white; padding: 1.5rem; border-radius: 0.5rem; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); border-top: 4px solid #b22222;">
    <header>
        <h2 style="font-family: 'Bangers', cursive; letter-spacing: 1px; color: #b22222; font-size: 1.5rem; font-weight: 500;">
            {{ __('Modifier le mot de passe') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Assurez-vous que votre compte utilise un mot de passe long et aléatoire pour rester sécurisé.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div>
            <label for="update_password_current_password" class="block font-bold text-gray-700 mb-1">{{ __('Mot de passe actuel') }}</label>
            <input id="update_password_current_password" name="current_password" type="password" 
                   style="width: 100%; border: 2px solid #d1d5db; padding: 0.5rem; border-radius: 0.5rem;"
                   class="focus:outline-none focus:border-red-600 transition" 
                   autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div>
            <label for="update_password_password" class="block font-bold text-gray-700 mb-1">{{ __('Nouveau mot de passe') }}</label>
            <input id="update_password_password" name="password" type="password" 
                   style="width: 100%; border: 2px solid #d1d5db; padding: 0.5rem; border-radius: 0.5rem;"
                   class="focus:outline-none focus:border-red-600 transition" 
                   autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div>
            <label for="update_password_password_confirmation" class="block font-bold text-gray-700 mb-1">{{ __('Confirmer le mot de passe') }}</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" 
                   style="width: 100%; border: 2px solid #d1d5db; padding: 0.5rem; border-radius: 0.5rem;"
                   class="focus:outline-none focus:border-red-600 transition" 
                   autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" 
                    style="background-color: #b22222; color: white; font-weight: bold; padding: 10px 24px; border-radius: 0.25rem; border-bottom: 4px solid #800000; cursor: pointer;"
                    class="shadow hover:opacity-90 transition active:border-0 active:translate-y-1">
                {{ __('SAUVEGARDER') }}
            </button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-green-600 font-bold"
                >{{ __('Sauvegardé.') }}</p>
            @endif
        </div>
    </form>
</section>
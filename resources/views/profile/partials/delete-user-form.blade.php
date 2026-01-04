<section class="space-y-6" style="background-color: white; padding: 1.5rem; border-radius: 0.5rem; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); border-top: 4px solid #b22222;">
    <header>
        <h2 style="font-family: 'Bangers', cursive; letter-spacing: 1px; color: #b22222; font-size: 1.5rem; font-weight: 500;">
            {{ __('Supprimer le compte') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Une fois votre compte supprimé, toutes ses ressources et données seront définitivement effacées. Avant de supprimer votre compte, veuillez télécharger toutes les données ou informations que vous souhaitez conserver.') }}
        </p>
    </header>

    <button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        style="background-color: #b22222; color: white; font-weight: bold; padding: 10px 24px; border-radius: 0.25rem; border-bottom: 4px solid #800000; cursor: pointer;"
        class="shadow hover:opacity-90 transition active:border-0 active:translate-y-1"
    >{{ __('SUPPRIMER LE COMPTE') }}</button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-gray-900" style="font-family: 'Bangers', cursive; color: #b22222; font-size: 1.5rem;">
                {{ __('Êtes-vous sûr de vouloir supprimer votre compte ?') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                {{ __('Une fois votre compte supprimé, toutes ses ressources et données seront définitivement effacées. Veuillez saisir votre mot de passe pour confirmer que vous souhaitez supprimer définitivement votre compte.') }}
            </p>

            <div class="mt-6">
                <label for="password" class="sr-only">{{ __('Mot de passe') }}</label>

                <input
                    id="password"
                    name="password"
                    type="password"
                    style="width: 75%; border: 2px solid #d1d5db; padding: 0.5rem; border-radius: 0.5rem;"
                    class="mt-1 block focus:outline-none focus:border-red-600 transition"
                    placeholder="{{ __('Mot de passe') }}"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <button type="button" x-on:click="$dispatch('close')" 
                        style="background-color: #fff; color: #333; border: 1px solid #ccc; font-weight: bold; padding: 8px 16px; border-radius: 0.25rem; cursor: pointer;">
                    {{ __('Annuler') }}
                </button>

                <button type="submit" 
                        style="background-color: #b22222; color: white; font-weight: bold; padding: 8px 16px; border-radius: 0.25rem; border-bottom: 4px solid #800000; cursor: pointer;"
                        class="shadow hover:opacity-90 active:border-0 active:translate-y-1">
                    {{ __('Supprimer le compte') }}
                </button>
            </div>
        </form>
    </x-modal>
</section>
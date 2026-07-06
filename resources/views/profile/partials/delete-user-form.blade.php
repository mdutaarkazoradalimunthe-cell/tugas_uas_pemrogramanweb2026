<div>
    <h2 class="font-display text-2xl font-semibold text-ink tracking-tight">
        {{ __('Delete Account') }}
    </h2>
    <p class="mt-1 text-sm text-ink/50 max-w-lg">
        {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
    </p>

    <div class="mt-6">
        <button
            x-data=""
            x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
            class="inline-flex items-center px-5 py-2 bg-red-500 text-white font-medium rounded-full hover:bg-red-600 transition-colors duration-200 text-sm"
        >
            {{ __('Delete Account') }}
        </button>
    </div>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="font-display text-xl font-semibold text-ink tracking-tight">
                {{ __('Are you sure you want to delete your account?') }}
            </h2>

            <p class="mt-2 text-sm text-ink/50">
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-3/4"
                    placeholder="{{ __('Password') }}"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <button type="button" x-on:click="$dispatch('close')" class="inline-flex items-center px-5 py-2 text-ink/70 hover:text-ink font-medium rounded-full border border-ink/15 hover:border-ink/30 transition-colors duration-200 text-sm">
                    {{ __('Cancel') }}
                </button>

                <button type="submit" class="inline-flex items-center px-5 py-2 bg-red-500 text-white font-medium rounded-full hover:bg-red-600 transition-colors duration-200 text-sm">
                    {{ __('Delete Account') }}
                </button>
            </div>
        </form>
    </x-modal>
</div>
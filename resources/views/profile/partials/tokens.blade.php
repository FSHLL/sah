<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Tokens') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Use this token for conect with the SAM plugin') }}
        </p>
    </header>

    <form method="post" action="{{ route('tokens.store') }}" class="mt-6 space-y-6">
        @csrf

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" class="mt-1 block w-full" autocomplete="Token name" />
            <x-input-error :messages="$errors->updatePassword->get('name')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Create') }}</x-primary-button>

            @if ($token = session('token'))
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 15000)"
                    class="text-sm text-gray-600 dark:text-gray-400">{{ $token }}</p>
            @endif
            @if (session('token-deleted'))
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400">{{ __('Token Deleted') }}</p>
            @endif
        </div>
    </form>
    <hr class="m-2">
    <div class="relative overflow-x-auto">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Name
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Expires_at
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Created_at
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Action
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach (Auth::user()->tokens as $token)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <th scope="row"
                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $token->name }}
                        </th>
                        <td class="px-6 py-4">{{ $token->expires_at ?? 'Never' }}</td>
                        <td class="px-6 py-4">{{ $token->created_at }}</td>
                        <td class="px-6 py-4">
                            <a href="#" x-data=""
                                x-on:click.prevent="$dispatch('open-modal', 'confirm-token-deletion-{{ $token->id }}')"
                                class="font-medium text-red-600 dark:text-red-500 hover:underline">
                                Delete
                            </a>
                            <x-modal name="confirm-token-deletion-{{ $token->id }}" :show="$errors->userDeletion->isNotEmpty()" focusable>
                                <form method="post" action="{{ route('tokens.destroy', $token) }}" class="p-6">
                                    @csrf
                                    @method('delete')

                                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                        {{ __('Are you sure you want to delete this token?') }}
                                    </h2>

                                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                        {{ __('Once your token is deleted, all of its resources and data will be permanently deleted.') }}
                                    </p>

                                    <div class="mt-6 flex justify-end">
                                        <x-secondary-button x-on:click="$dispatch('close')">
                                            {{ __('Cancel') }}
                                        </x-secondary-button>

                                        <x-danger-button class="ms-3">
                                            {{ __('Delete Token') }}
                                        </x-danger-button>
                                    </div>
                                </form>
                            </x-modal>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>

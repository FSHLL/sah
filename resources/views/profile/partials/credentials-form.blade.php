<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Credential') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Use this credential for conect with you Cloud Provider') }}
        </p>
    </header>

    @php
        $credential = Auth::user()->credential;
    @endphp

    <form method="post"
        action="{{ $credential ? route('credentials.update', $credential) : route('credentials.store') }}"
        class="mt-6 space-y-6">
        @csrf
        @method($credential ? 'put' : 'post')

        <div>
            <x-input-label for="name" :value="__('Acces Key Id')" />
            <x-text-input id="access_key_id" name="access_key_id" class="mt-1 block w-full" autocomplete="Access key id"
                required />
            <x-input-error :messages="$errors->get('access_key_id')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="name" :value="__('Acces Key Secret')" />
            <x-text-input type="password" id="access_key_secret" name="access_key_secret" class="mt-1 block w-full"
                autocomplete="Access key secret" required />
            <x-input-error :messages="$errors->get('access_key_secret')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="region" :value="__('Region')" />
            <x-select id="region" name="region" class="mt-1 block w-full" required>
                @foreach (App\Enums\AWSRegion::values() as $region)
                    <option :value="$region">{{ $region }}</option>
                @endforeach
            </x-select>
            <x-input-error :messages="$errors->get('region')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __($credential ? 'Update' : 'Create') }}</x-primary-button>

            @if ($token = session('credential'))
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 6000)"
                    class="text-sm text-gray-600 dark:text-gray-400">{{ __('Credential Saved') }}</p>
            @endif
            @if (session('credential-deleted'))
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 6000)"
                    class="text-sm text-gray-600 dark:text-gray-400">{{ __('Credential Deleted') }}</p>
            @endif
        </div>
    </form>
    <hr class="m-2">
    @if ($credential)
        <div class="relative overflow-x-auto">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Type
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Created_at
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Updated_at
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <th scope="row"
                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $credential->type }}
                        </th>
                        <td class="px-6 py-4">{{ $credential->created_at }}</td>
                        <td class="px-6 py-4">{{ $credential->updated_at }}</td>
                        <td class="px-6 py-4">
                            <a href="#" x-data=""
                                x-on:click.prevent="$dispatch('open-modal', 'confirm-credential-deletion-{{ $credential->id }}')"
                                class="font-medium text-red-600 dark:text-red-500 hover:underline">
                                Delete
                            </a>
                            <x-modal name="confirm-credential-deletion-{{ $credential->id }}" :show="$errors->credentialDeletion->isNotEmpty()"
                                focusable>
                                <form method="post" action="{{ route('credentials.destroy', $credential) }}"
                                    class="p-6">
                                    @csrf
                                    @method('delete')

                                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                        {{ __('Are you sure you want to delete this credential?') }}
                                    </h2>

                                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                        {{ __('Once your credential is deleted, all of its resources and data will be permanently deleted.') }}
                                    </p>

                                    <div class="mt-6 flex justify-end">
                                        <x-secondary-button x-on:click="$dispatch('close')">
                                            {{ __('Cancel') }}
                                        </x-secondary-button>

                                        <x-danger-button class="ms-3">
                                            {{ __('Delete Credential') }}
                                        </x-danger-button>
                                    </div>
                                </form>
                            </x-modal>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    @endif
</section>

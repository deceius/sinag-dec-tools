<section>
    <x-ui.card.table>
        <x-slot:title>
            {{ __('Discord Info') }}
        </x-slot>
        <x-slot:icon>
            <x-icons.master-table/>
        </x-slot>
        <x-slot:content >
            <div class="overflow-x-auto">
                <table id="table" class="min-w-full">
                        <tbody>
                            <tr class="border-t-2 border-gray-700 dark:border-gray-700 text-start">
                                <td class="border-t py-3 px-5 font-medium"> Discord Name</td>
                                <td class="border-t py-3 px-5">{{ $user->global_name }}</td>
                            </tr>
                            {{-- <tr class="border-t-2 border-gray-700 dark:border-gray-700 text-start">
                                <td class="border-t py-3 px-5 font-medium"> Roles</td>
                                <td class="border-t py-3 px-5">{{ collect($roles)->implode(",") }}</td>
                            </tr> --}}
                        </tbody>
                    </table>
            </div>

        </x-slot>
    </x-ui.card>
{{--
    <x-ui.card>
        <x-slot:title><h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Bind Albion Online Character') }}

        </h2>
       </x-slot>
        <x-slot:icon>
           <x-icons.form/>
        </x-slot>
        <x-slot:buttons>
            <x-ui.search model="filter.search" click-method="load()"/>

        </x-slot>
        <x-slot:content>
            <form method="post" action="{{ route('home') }}" >
                @csrf
                @method('put')

                <div class="mb-6">
                    <x-ui.form.input.label for="update_ao_character" :value="__('Search IGN')" />
                    <x-ui.form.input.text id="update_ao_character" name="ao_character" type="text" class="mt-1 block w-full" />
                    <x-ui.form.input.error :messages="$errors->updatePassword->get('ao_character')" class="mt-2" />
                </div>

                <div class="flex items-center gap-4">
                    <x-ui.button text="Search"/>

                    @if (session('status') === 'password-updated')
                        <p
                            x-data="{ show: true }"
                            x-show="show"
                            x-transition
                            x-init="setTimeout(() => show = false, 2000)"
                            class="text-sm text-gray-600 dark:text-gray-400"
                        >{{ __('Saved.') }}</p>
                    @endif
                </div>
            </form>
        </x-slot>
    </x-ui.card> --}}


</section>

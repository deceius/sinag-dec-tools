<section x-data="builds" x-init="init()">
    <x-ui.card.table>
        <x-slot:title>
            {{ __('Builds') }}
        </x-slot>
        <x-slot:icon>
            <x-icons.master-table/>
        </x-slot>
        <x-slot:content>
                <div class="overflow-x-auto" >
                    <table id="table" class="min-w-full table-auto">
                            <thead class="font-medium">
                                <tr class=" border-gray-700 dark:border-gray-700">
                                    <th scope="col" class="text-start py-3 px-5">
                                        {{ __('Equipment') }}
                                    </th>
                                    <th scope="col" class="text-start py-3 px-5">
                                        &nbsp;
                                    </th>
                                </tr>
                            </thead>

                            <tbody>
                                <template x-for="build in builds">
                                    <tr class="border-t-2 border-gray-700 dark:border-gray-700 text-start ">
                                        <td class="border-t py-3 px-5 align-top">
                                            <div class="grid grid-cols-2 w-96">
                                                <div class="grid grid-cols-5 gap-3 w-40 mb-6">
                                                    <template x-for="item in build.equipment_list">
                                                        <div class="grid grid-cols-1 w-9">
                                                            <template x-for="sub in item">
                                                                    <div class="w-9">
                                                                        <img :class="{'opacity-25 grayscale': !sub }" x-bind:src="`https://render.albiononline.com/v1/item/${ sub ? sub : 'QUESTITEM_TOKEN_ADC_FRAME' }?size=64`">
                                                                    </div>
                                                            </template>
                                                        </div>
                                                    </template>
                                                </div>
                                                <div class="grid grid-cols-3 gap-3 w-24">
                                                    <template x-for="item in build.consumable_list">
                                                        <div class="grid grid-cols-1 w-9">
                                                            <template x-for="sub in item">
                                                                    <div class="w-9">
                                                                        <img :class="{'opacity-25 grayscale': !sub }" x-bind:src="`https://render.albiononline.com/v1/item/${ sub ? sub : 'QUESTITEM_TOKEN_ADC_FRAME' }?size=64`">
                                                                    </div>
                                                            </template>
                                                        </div>
                                                    </template>
                                                </div>
                                            </div>
                                    </td>
                                        <td class="border-t py-3 px-5 align-top">

                                        </td>

                                    </tr>
                                </template>

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

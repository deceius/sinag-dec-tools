<section>
    <x-ui.card.table>
        <x-slot:title>
            {{ __('Regears List') }}
        </x-slot>
        <x-slot:icon>
            <x-icons.master-table/>
        </x-slot>
        <x-slot:content>
            <div class="overflow-x-auto" x-show="data.length == 0">
                &nbsp;
            </div>
            <template x-if="data.length > 0">
                <div class="overflow-x-auto" >
                    <table id="table" class="min-w-full table-auto">
                            <thead class="font-medium">
                                <tr class=" border-gray-700 dark:border-gray-700">
                                    <th scope="col" class="text-start py-3 px-5">
                                        {{ __('Battle ID') }}
                                    </th>
                                    <th scope="col" class="text-start py-3 px-5">
                                        {{ __('Name') }}
                                    </th>
                                    <th scope="col" class="text-start py-3 px-5">
                                        {{ __('Equipment Lost') }}
                                    </th>
                                    <th scope="col" class="text-start py-3 px-5">
                                        {{ __('Death (UTC)') }}
                                    </th>
                                    <th scope="col" class="text-start py-3 px-5">
                                        {{ __('Regeared By') }}
                                    </th>
                                    <th scope="col" class="text-start py-3 px-5">
                                        <div class="flex gap-2">
                                            <abbr title="Estimated via parsing max value buy orders, and did an average through all markets that have the item available.">{{ __('Est. Regear Cost') }} </abbr>
                                        </div>
                                    </th>
                                    <th scope="col" class="text-start py-3 px-5">
                                        &nbsp;
                                    </th>
                                </tr>
                            </thead>
                            <tbody>

                            <template x-for="item in data">
                                    <tr class="border-t-2 border-gray-700 dark:border-gray-700 text-start" :class="{'opacity-50' : item.status == 0}">

                                        <td class="border-t py-3 px-5"><a class="underline text-indigo-600" target="_blank" x-bind:href="'https://east.albionbattles.com/multilog?ids=' + item.battle_id" x-text="item.battle_id"></a></td>
                                        <td class="border-t py-3 px-5" x-text='item.name'></td>
                                        <td class="dark:border-gray-700 py-1 px-5">
                                            <template x-for="equips in item.equipment.split(',')">
                                                <img :class="{'opacity-25 grayscale': equips.includes('!') }" class="inline" x-bind:src="`https://render.albiononline.com/v1/item/${equips.includes('!no_') ? 'QUESTITEM_TOKEN_ADC_FRAME' : equips.includes('!') ? equips.substring(1) : equips }?size=48`" alt="">
                                            </template>
                                        </td>
                                        <td class="py-3 px-5" x-text='item.timestamp'></td>
                                        <td class="py-3 px-5" x-text='item.regearing_officer ? item.regearing_officer.username : ""'></td>
                                       <td class="py-3 px-5" x-text='parseInt(item.regear_cost.toFixed(0)).toLocaleString("en-US")'></td>
                                            <td class=" whitespace-nowrap border-t py-3 px-5 text-end">
                                                <form method="post" :action="item.url + '/update'" >
                                                    @csrf
                                                    @method('patch')
                                                    <x-ui.button.button-icon type="submit" style="success" text="Approve" x-bind:disabled="item.status == 0 || isLoading" x-show="item.status == 2">
                                                       <x-icons.button.approve/>
                                                    </x-ui.button.button-icon>
                                                    <x-ui.icon-pill  x-show="item.status == 1">
                                                       <x-icons.button.check/>
                                                    </x-ui.icon-pill>
                                                </form>
                                            </td>
                                    </tr>
                            </template>
                            </tbody>
                        </table>
                </div>
            </template>


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

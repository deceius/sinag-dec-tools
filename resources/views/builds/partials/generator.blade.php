<section x-data="builds">
    <x-ui.card.table>
        <x-slot:title>
            {{ __('Build Generator') }}
        </x-slot>
        <x-slot:icon>
            <x-icons.master-table/>
        </x-slot>
        <x-slot:buttons>
            <form method="post"  >
                @csrf
                @method('patch')
                <x-ui.button type="submit" style="success" text="Create Build" >
                    <x-slot:icon><x-icons.button.create/></x-slot>
                </x-ui.button>
            </form>
        </x-slot>
        <x-slot:content>
                <div class="overflow-x-auto" >
                    <table id="table" class="min-w-full table-auto">
                            <thead class="font-medium">
                                <tr class=" border-gray-700 dark:border-gray-700">
                                    <th scope="col" class="text-start py-3 px-5">
                                        {{ __('Role') }}
                                    </th>
                                    <th scope="col" class="text-start py-3 px-5">
                                        {{ __('Equipment') }}
                                    </th>
                                    <th scope="col" class="text-start py-3 px-5">
                                        {{ __('Consumables') }}
                                    </th>
                                    <th scope="col" class="text-start py-3 px-5">
                                        &nbsp;
                                    </th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr class="border-t-2 border-gray-700 dark:border-gray-700 text-start ">
                                    <td class="border-t py-3 px-5 align-top">
                                        <x-ui.form.select>
                                            <option value="0" >Tank</option>
                                            <option value="1" >DPS</option>
                                            <option value="2" >Support</option>
                                            <option value="3" >Healer</option>
                                        </x-ui.form.select>
                                    </td>
                                    <td class="border-t py-3 px-5 align-top">
                                        <template x-for="item in equipment">
                                            <div class="mb-2">
                                                <img :class="{'opacity-25 grayscale': item.item_id == null, 'animate-pulse': isLoading }" class="inline mb-2" x-bind:src="`https://render.albiononline.com/v1/item/${ item.item_id ? item.item_id : 'QUESTITEM_TOKEN_ADC_FRAME'}?size=32&quality=4`" tooltip="item.type">
                                                <x-ui.search model="item.filter" click-method="load(item)" x-bind:placeholder="item.type" x-bind:disabled="item.disabled"/>
                                            </div>
                                        </template>
                                    </td>

                                </tr>
                                <tr class="border-t-2 border-transparent dark:border-transparent text-start ">
                                    <td class="border-t py-3 px-5 align-top" colspan="4">
                                        <x-ui.form.input.text placeholder="Notes" class="min-w-full"/>
                                    </td>

                                </tr>
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

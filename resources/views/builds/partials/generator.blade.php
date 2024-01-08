<section x-data="builds">
    <x-ui.card.table class="mt-6">
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
                <x-ui.button  x-bind:disabled="isLoading" x-on:click="saveBuild()" style="success" text="Create Build" >
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
                                        {{ __('Others') }}
                                    </th>
                                    <th scope="col" class="text-start py-3 px-5">
                                        &nbsp;
                                    </th>
                                </tr>
                            </thead>

                            <tbody>
                                <tr class="border-t-2 border-gray-700 dark:border-gray-700 text-start ">
                                    <td class="border-t py-3 px-5 align-top">
                                        <x-ui.form.select x-model="data.role_id">
                                            <template x-for="(role, index) in roles">
                                                <option x-bind:value="index" x-text="role"/>
                                            </template>
                                        </x-ui.form.select>
                                    </td>
                                    <td class="border-t py-3 px-5 align-top">
                                        <template x-for="item in equipment">
                                            <div class="mb-2">
                                                <img x-show="item.items.length == 0" class="opacity-25 grayscale" x-bind:src="`https://render.albiononline.com/v1/item/QUESTITEM_TOKEN_ADC_FRAME?size=32`">
                                                <div :class="{'animate-pulse': isLoading}">
                                                    <template x-for="item_id in item.items">
                                                        <img x-on:click="removeItem(item, item_id)" :class="{'opacity-25 grayscale': item_id == null }" class="inline" x-bind:src="`https://render.albiononline.com/v1/item/${ item_id ? item_id : 'QUESTITEM_TOKEN_ADC_FRAME'}?size=32`" tooltip="item.type">
                                                    </template>
                                                </div>
                                                <x-ui.search model="item.filter" click-method="load(item)" x-bind:placeholder="item.type" x-bind:disabled="item.disabled"/>
                                            </div>
                                        </template>
                                    </td>
                                    <td class="border-t py-3 px-5 align-top">
                                        <template x-for="item in consumables">
                                            <div class="mb-2">
                                                <img x-show="item.items.length == 0" class="opacity-25 grayscale" x-bind:src="`https://render.albiononline.com/v1/item/QUESTITEM_TOKEN_ADC_FRAME?size=32`">
                                                <div :class="{'animate-pulse': isLoading}">
                                                    <template x-for="item_id in item.items">
                                                        <img x-on:click="removeItem(item, item_id)" :class="{'opacity-25 grayscale': item_id == null }" class="inline" x-bind:src="`https://render.albiononline.com/v1/item/${ item_id ? item_id : 'QUESTITEM_TOKEN_ADC_FRAME'}?size=32`" tooltip="item.type">
                                                    </template>
                                                </div>
                                                <x-ui.search model="item.filter" click-method="load(item)" x-bind:placeholder="item.type" x-bind:disabled="item.disabled"/>
                                            </div>
                                        </template>
                                    </td>
                                </tr>
                                <tr class="border-t-2 border-transparent dark:border-transparent text-start ">
                                    <td class="border-t py-3 px-5 align-top" colspan="4">
                                        <x-ui.form.input.text placeholder="Notes" x-model="data.notes" class="min-w-full"/>
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

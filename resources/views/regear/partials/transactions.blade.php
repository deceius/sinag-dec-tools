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
                                        <div class="flex gap-2">
                                            <abbr title="Estimated via parsing max value buy orders, and did an average through all markets that have the item available.">{{ __('Est. Regear Cost') }} </abbr>
                                        </div>
                                    </th>
                                    <th scope="col" class="text-start py-3 px-5">
                                        {{ __('Processed By') }}
                                    </th>
                                    <th scope="col" class="text-start py-3 px-5">
                                        &nbsp;
                                    </th>
                                </tr>
                            </thead>
                            <tbody>

                            <template x-for="item in data">
                                    <tr class="border-t-2 border-gray-700 dark:border-gray-700 text-start" :class="{'opacity-50' : item.status <= 0}">

                                        <td class="border-t py-3 px-5"><a class="underline text-indigo-600" target="_blank" x-bind:href="'https://east.albionbattles.com/multilog?ids=' + item.battle_id" x-text="item.battle_id"></a></td>
                                        <td class="border-t py-3 px-5" x-text='item.name'></td>
                                        <td class="dark:border-gray-700 py-1 px-5">
                                            <template x-for="equips in item.equipment.split(',')">
                                                <img :class="{'opacity-25 grayscale': equips.includes('!') }" class="inline" x-bind:src="`https://render.albiononline.com/v1/item/${equips.includes('!no_') ? 'QUESTITEM_TOKEN_ADC_FRAME' : equips.includes('!') ? equips.substring(1) : equips }?size=48`" alt="">
                                            </template>
                                        </td>
                                        <td class="py-3 px-5" x-text='item.timestamp'></td>
                                       <td class="py-3 px-5" x-text='parseInt(item.regear_cost.toFixed(0)).toLocaleString("en-US")'></td>
                                       <td class="py-3 px-5" x-text='item.regearing_officer ? item.regearing_officer.username : ""'></td>

                                       <td class=" whitespace-nowrap border-t py-3 px-5 text-end">
                                                <div class="space-x-2 flex ">
                                                    <form method="post" :action="item.url + '/update'" >
                                                        @csrf
                                                        @method('patch')
                                                        <x-ui.button.button-icon type="submit" style="success" x-bind:disabled="item.status == 0 || isLoading" x-show="item.status == 2">
                                                           <x-icons.button.approve/>
                                                        </x-ui.button.button-icon>
                                                        <x-ui.icon-pill  x-show="item.status == 1">
                                                           <x-icons.button.check/>
                                                        </x-ui.icon-pill>
                                                    </form>
                                                    <form method="post" :action="item.url + '/update?reject=1'"  x-show="item.status == 2">
                                                        @csrf
                                                        @method('patch')
                                                        <x-ui.button.button-icon type="submit" style="danger"  x-bind:disabled="item.status == 0 || isLoading" x-show="item.status == 2">
                                                           <x-icons.button.close/>
                                                        </x-ui.button.button-icon>
                                                    </form>
                                                    <x-ui.icon-pill  x-show="item.status == -1">
                                                        <x-icons.button.close/>
                                                     </x-ui.icon-pill>
                                                </div>

                                            </td>
                                    </tr>
                            </template>
                            </tbody>
                        </table>
                </div>
            </template>


        </x-slot>
    </x-ui.card>


</section>

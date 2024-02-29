<x-app-layout>
    <x-slot:header>
        <x-ui.header title="{{ __('Regear Summary') }}"/>
    </x-slot>

    <div class="py-12"  x-data="regearReports"  x-init="init()">

        <div class="max-w-full sm:px-6 lg:px-8 mb-6">
            <section>
                <x-ui.card.table>
                    <x-slot:title>
                        {{ __('Regear Costs') }}
                    </x-slot>
                    <x-slot:icon>
                        <x-icons.info/>
                    </x-slot>
                    <x-slot:content>
                        <template x-if="true">
                            <div class="overflow-x-auto">
                                <table id="table" class="min-w-full table-auto" :class="{ 'opacity-50' : isLoading}">
                                        <thead class="font-medium">
                                            <tr class="border-gray-700">
                                                <th scope="col" class="text-start py-3 px-5">
                                                    {{ __('Battle ID') }}
                                                </th>
                                                <th scope="col" class="text-end py-3 px-5">
                                                    {{ __('Deaths') }}
                                                </th>
                                                <th scope="col" class="text-end py-3 px-5">
                                                    {{ __('Total Death Fame') }}
                                                </th>
                                                <th scope="col" class="text-end py-3 px-5">
                                                    {{ __('Qty. Lost') }}
                                                </th>
                                                <th scope="col" class="text-end py-3 px-5">
                                                    {{ __('Est. Cost') }}
                                                </th>
                                                <th scope="col" class="text-end py-3 px-5">
                                                    {{ __('Regear Est. Cost') }}
                                                </th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="border-t-2 border-gray-700 text-start font-medium bg-gray-900">
                                                <td class="border-t py-3 px-5" x-text='"All CTAs"'/>
                                                <td class="border-t py-3 px-5 text-end" >{{ number_format($unfiltered->death_count, 0) }}</td>
                                                <td class="border-t py-3 px-5 text-end" >{{ number_format($unfiltered->death_fame, 0) }}</td>
                                                <td class="border-t py-3 px-5 text-end" >{{ number_format($unfiltered->unit, 0) }}</td>
                                                <td class="border-t py-3 px-5 text-end" >{{ number_format($unfiltered->cost, 0) }}</td>
                                                <td class="border-t py-3 px-5 text-end" >{{ number_format($unfiltered->regeared_cost, 0) }}</td>
                                            </tr>
                                        <template x-for="item in losses.data">
                                                <tr class="border-t-2 border-gray-700 text-start">
                                                    <td class="border-t py-3 px-5"><a class="underline text-indigo-600" target="_blank" x-bind:href="'https://east.albionbattles.com/multilog?ids=' + item.battle_id" x-text="item.battle_id"></a></td>
                                                    <td class="border-t py-3 px-5 text-end" x-text='item.death_count.toLocaleString("en-US")'></td>
                                                    <td class="border-t py-3 px-5 text-end" x-text='item.death_fame.toLocaleString("en-US")'></td>
                                                    <td class="border-t py-3 px-5 text-end" x-text='item.unit.toLocaleString("en-US")'></td>
                                                    <td class="border-t py-3 px-5 text-end" x-text='parseInt(item.cost).toLocaleString("en-US")'></td>
                                                    <td class="border-t py-3 px-5 text-end" x-text='parseInt(item.regeared_cost).toLocaleString("en-US")'></td>
                                                </tr>
                                        </template>
                                        </tbody>
                                    </table>

                                    <div class="p-6 flex justify-end" x-show="losses.last_page > 1">
                                        <x-ui.pagination links="losses.links" click-method="loadLosses(link.url)"></x-ui.pagination>
                                    </div>
                            </div>
                        </template>


                    </x-slot>
                </x-ui.card>
            </section>
        </div>

        <div class="max-w-full sm:px-6 lg:px-8 mb-6">
            <section>
                <x-ui.card.table>
                    <x-slot:title>
                        {{ __('Member Death Stats') }}
                    </x-slot>
                    <x-slot:icon>
                        <x-icons.identification/>
                    </x-slot>
                    <x-slot:buttons>
                        <x-ui.form.select x-model="filter.status">
                            <template x-for="(status, name) in status">
                                <option x-bind:value="status" x-text="name"/>
                            </template>
                        </x-ui.form.select>
                    </x-slot:buttons>
                    <x-slot:content>
                        <template x-if="true">
                            <div class="overflow-x-auto">
                                <table id="table" class="min-w-full table-auto" :class="{ 'opacity-50' : isLoading}">
                                        <thead class="font-medium">
                                            <tr class="border-gray-700">
                                                <th scope="col" class="text-start py-3 px-5">
                                                    {{ __('Name') }}
                                                </th>
                                                <th scope="col" class="text-end py-3 px-5">
                                                    {{ __('Deaths') }}
                                                </th>
                                                <th scope="col" class="text-end py-3 px-5">
                                                    {{ __('Death Fame') }}
                                                </th>
                                                <th scope="col" class="text-end py-3 px-5">
                                                    {{ __('Items Lost') }}
                                                </th>

                                                <th scope="col" class="text-end py-3 px-5">
                                                    {{ __('Total Cost') }}
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <template x-for="item in deathStats.data">
                                                <tr class="border-t-2 border-gray-700 text-start">
                                                    <td class="border-t py-3 px-5 text-start" x-text='item.name'></td>
                                                    <td class="border-t py-3 px-5 text-end" x-text='item.death_count.toLocaleString("en-US")'></td>
                                                    <td class="border-t py-3 px-5 text-end" x-text='item.death_fame.toLocaleString("en-US")'></td>
                                                    <td class="border-t py-3 px-5 text-end" x-text='item.items_lost.toLocaleString("en-US")'></td>
                                                    <td class="border-t py-3 px-5 text-end" x-text='parseInt(item.cost).toLocaleString("en-US")'></td>
                                                </tr>
                                        </template>
                                        </tbody>
                                    </table>

                                    <div class="p-6 flex justify-end" x-show="deathStats.last_page > 1">
                                        <x-ui.pagination links="deathStats.links" click-method="loadDeathStats(link.url)"></x-ui.pagination>
                                    </div>
                            </div>
                        </template>


                    </x-slot>
                </x-ui.card>
            </section>
        </div>

        <div class="max-w-full sm:px-6 lg:px-8">
            <section>
                <x-ui.card.table>
                    <x-slot:title>
                        {{ __('Pending Regear Count') }}
                    </x-slot>
                    <x-slot:icon>
                        <x-icons.list/>
                    </x-slot>
                    <x-slot:buttons>
                        <x-ui.form.select x-model="filter.tier" class="lg:mt-0 mt-4 ">
                            @foreach ($tiers as $key => $value)
                                <option value="{{ $value }}">{{ $key }}</option>
                            @endforeach
                        </x-ui.form.select>
                    </x-slot:buttons>
                    <x-slot:content>
                        <div class="overflow-x-auto" x-show="!data && isLoading">
                            &nbsp;
                        </div>
                        <template x-if="true">
                            <div class="overflow-x-auto" :class="{'animate-pulse opacity-50': isLoading}" >
                                <table id="table" class="min-w-full table-auto">
                                        <thead class="font-medium">
                                            <tr class="border-gray-700">
                                                <th scope="col" class="text-start py-3 px-5">
                                                    {{ __('') }}
                                                </th>
                                                <th scope="col" class="text-start py-3 px-5">
                                                    {{ __('Item ID') }}
                                                </th>
                                                <th scope="col" class="text-start py-3 px-5">
                                                    {{ __('Name') }}
                                                </th>
                                                <th scope="col" class="text-end py-3 px-5">
                                                    {{ __('Count') }}
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="border-t-2 border-gray-700 text-start  bg-gray-900">
                                                <td class="border-t py-3 px-5"/>
                                                <td class="border-t py-3 px-5"/>
                                                <td class="border-t py-3 px-5 " x-text='"Total Item Count"'/>
                                                <td class="border-t py-3 px-5 text-end" x-text='totalPendingRegearItems.toLocaleString("en-US")'></td>
                                            </tr>
                                        <template x-for="(item, key) in data">
                                                <tr class="border-t-2 border-gray-700 text-start" :class="{'opacity-50' : item.status == 0}">
                                                    <td class="py-1 px-5">
                                                        <img  class="inline" x-bind:src="`https://render.albiononline.com/v1/item/${ 'T8_' + key }?size=48`" alt="">
                                                    </td>
                                                    <td class="border-t py-1 px-5" x-text='key'></td>
                                                    <td class="border-t py-1 px-5" x-text='item.name'></td>
                                                    <td class="border-t py-1 px-5 text-end" x-text='item.items.length'></td>
                                                </tr>
                                        </template>
                                        </tbody>
                                    </table>
                            </div>
                        </template>


                    </x-slot>
                </x-ui.card>
            </section>
        </div>
    </div>
</x-app-layout>

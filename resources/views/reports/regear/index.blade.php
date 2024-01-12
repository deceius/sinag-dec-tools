<x-app-layout>
    <x-slot:header>
        <x-ui.header title="{{ __('Regear Summary') }}"/>
    </x-slot>
    <div class="py-12"  x-data="regearReports"  x-init="init()">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-6">
            <section>
                <x-ui.card.table>
                    <x-slot:title>
                        {{ __('Est. Regear Costs (Per Battle ID)') }}
                    </x-slot>
                    <x-slot:icon>
                        <x-icons.master-table/>
                    </x-slot>
                    <x-slot:content>
                        <div class="overflow-x-auto" x-show="losses.length == 0 && isLoading">
                            &nbsp;
                        </div>
                        <template x-if="true">
                            <div class="overflow-x-auto">
                                <table id="table" class="min-w-full table-auto">
                                        <thead class="font-medium">
                                            <tr class="border-gray-700">
                                                <th scope="col" class="text-start py-3 px-5">
                                                    {{ __('Battle ID') }}
                                                </th>
                                                <th scope="col" class="text-start py-3 px-5">
                                                    {{ __('Deaths') }}
                                                </th>
                                                <th scope="col" class="text-start py-3 px-5">
                                                    {{ __('Total Death Fame') }}
                                                </th>
                                                <th scope="col" class="text-start py-3 px-5">
                                                    {{ __('Est. Regear Cost') }}
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        <template x-for="item in losses">
                                                <tr class="border-t-2 border-gray-700 text-start">
                                                    <td class="border-t py-3 px-5"><a class="underline text-indigo-600" target="_blank" x-bind:href="'https://east.albionbattles.com/multilog?ids=' + item.battle_id" x-text="item.battle_id"></a></td>
                                                    <td class="border-t py-3 px-5" x-text='item.death_count'></td>
                                                    <td class="border-t py-3 px-5" x-text='item.death_fame.toLocaleString("en-US")'></td>
                                                    <td class="border-t py-3 px-5" x-text='parseInt(item.cost).toLocaleString("en-US")'></td>
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
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <section>
                <x-ui.card.table>
                    <x-slot:title>
                        {{ __('Pending Regear Count') }}
                    </x-slot>
                    <x-slot:icon>
                        <x-icons.master-table/>
                    </x-slot>
                    <x-slot:content>
                        <div class="overflow-x-auto" x-show="data.length == 0">
                            &nbsp;
                        </div>
                        <template x-if="true">
                            <div class="overflow-x-auto">
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
                                                <th scope="col" class="text-start py-3 px-5">
                                                    {{ __('Count') }}
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        <template x-for="(item, key) in data">
                                                <tr class="border-t-2 border-gray-700 text-start" :class="{'opacity-50' : item.status == 0}">
                                                    <td class="py-1 px-5">
                                                        <img  class="inline" x-bind:src="`https://render.albiononline.com/v1/item/${ 'T8_' + key }?size=48`" alt="">
                                                    </td>
                                                    <td class="border-t py-1 px-5" x-text='key'></td>
                                                    <td class="border-t py-1 px-5" x-text='item.name'></td>
                                                    <td class="border-t py-1 px-5" x-text='item.items.length'></td>
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

@section('title', 'SINAG Tools - Market Price Checker')
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            {{ __('Black Market') }}
        </h2>
    </x-slot>
    <div class="p-4 bg-red-600 text-sm text-gray-200 leading-tight">
       Welcome to the secret module of SINAG web tool. This was supposed to be a "personal use only" module, but here we are. Few people are given access, so don't tell anyone.
    </div>
    <div class="py-12">


        <div class="max-w-full sm:px-6 lg:px-8 space-y-6" x-data="blackmarket" x-init="init(true)">


            <x-ui.card.table>
                <x-slot:title>
                    {{ __('Gold Prices') }}
                </x-slot>
                <x-slot:icon>
                    <x-icons.circle-stack/>
                </x-slot>
                <x-slot:content>
                    <div class="overflow-x-auto" >
                        <table id="table" class="min-w-full text-start text-sm border-gray-700">
                                <thead class="font-medium">
                                <tr>
                                    @foreach ($gold as $item)
                                    <th class="whitespace-nowrap border-t border-gray-700 px-6 py-3  text-start">{{ date('Y-m-d H:i', strtotime($item->timestamp)) }}</th>

                                    @endforeach

                                </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        @foreach ($gold as $item)
                                        <td class="whitespace-nowrap border-t border-gray-700 px-6 py-3  text-start">{{ number_format($item->price, 0) }}</td>

                                        @endforeach

                                    </tr>
                                </tbody>
                            </table>
                    </div>


                </x-slot>
            </x-ui.card>

            <x-ui.card.table>
                <x-slot:title>
                    {{ __('Black Market Items') }}
                </x-slot>
                <x-slot:icon>
                    <x-icons.branch/>
                </x-slot>
                <x-slot:buttons>
                    <x-ui.form.input.text x-model="filters.keyword"  placeholder="Search Item..." class="w-full lg:mt-0 mt-4 " />

                        <x-ui.form.select x-model="filters.tier" class="lg:mt-0 mt-4 ">
                            @foreach ($tiers as $value)
                                <option value="{{ $loop->index }}">{{ ($loop->index ? 'Tier ' : '') . $value }}</option>
                            @endforeach
                        </x-ui.form.select>
                        <x-ui.form.select x-model="filters.enchant" class="lg:mt-0 mt-4 ">
                            @foreach ($enchantments as $value)
                                <option value="{{ $loop->index }}">{{ $value }}</option>
                            @endforeach
                        </x-ui.form.select>
                        <x-ui.button x-on:click="init()" class="text-center lg:mt-0 mt-4 " text="Search"/>
                </x-slot>
                <x-slot:content>
                    <div class="overflow-x-auto" >
                        <table id="table"
                                class="min-w-full text-center text-sm border-gray-700">
                                <thead class="font-medium">
                                <tr>
                                    <th scope="col"  width='120px' class="border-b border-gray-700 px-6 py-3 text-start">
                                    &nbsp;
                                    </th>
                                    <th scope="col" class="border-b border-gray-700 text-start px-6 py-3">
                                        Item ID
                                    </th>
                                    <th scope="col" class="border-b border-gray-700 px-6 py-3 text-right">
                                        Min. BP
                                    </th>
                                    <th scope="col" class="border-b border-gray-700 px-6 py-3 text-right">
                                        Max. BP
                                    </th>
                                    <th scope="col" class="border-b border-gray-700 px-6 py-3 text-right">
                                        Min. SP
                                    </th>
                                    <th scope="col" class="border-b border-gray-700 px-6 py-3 text-right">
                                        Max. SP
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                    <template x-if="isLoading">
                                        <tr>
                                            <td class="whitespace-nowrap border-t border-gray-700 p-6" colspan="6">
                                                <div class="p-6 content-center w-full">
                                                    <img src="/assets/sinag-logo.png" class="mx-auto h-9 w-auto fill-current text-gray-200 animate-ping">
                                                </div>
                                            </td>
                                        </tr>
                                    </template>
                                    <tr x-show="!data.length && !isLoading">
                                        <td class="whitespace-nowrap border-t border-gray-700 p-6" colspan="6">
                                            <div class="p-6 content-center w-full">
                                                No Data.
                                            </div>
                                        </td>
                                    </tr>
                                    <template x-for="item in data" x-show="!isLoading">
                                        <tr class="border-t border-gray-700" x-show="item.has_prices">
                                            <td class="whitespace-nowrap border-t border-gray-700 px-6">
                                                <img x-bind:src="`https://render.albiononline.com/v1/item/${item.item_id}?size=48&quality=${item.quality}`" alt="">
                                            </td>
                                            <td class="whitespace-nowrap border-t border-gray-700 px-6 text-start" x-text='item.item_name'></td>
                                            <td class="whitespace-nowrap border-t border-gray-700 px-6 text-right" x-text='item.buy_price_min.toLocaleString("en-US")'></td>
                                            <td class="whitespace-nowrap border-t border-gray-700 px-6 text-right" x-text='item.buy_price_max.toLocaleString("en-US")'></td>
                                            <td class="whitespace-nowrap border-t border-gray-700 px-6 text-right" x-text='item.sell_price_min.toLocaleString("en-US")'></td>
                                            <td class="whitespace-nowrap border-t border-gray-700 px-6 text-right" x-text='item.sell_price_max.toLocaleString("en-US")'></td>
                                            </tr>
                                    </template>
                                </tbody>
                            </table>
                    </div>


                </x-slot>
            </x-ui.card>
        </div>
    </div>

</x-app-layout>

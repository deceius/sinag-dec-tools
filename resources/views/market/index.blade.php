@section('title', 'SINAG Tools - Market Price Checker')
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            {{ __('Market Price Checker') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-full sm:px-6 lg:px-8 space-y-6" x-data="market">

            <div class="p-4 sm:p-8 bg-gray-800 shadow sm:rounded-lg">
                <form @submit.prevent=""  action="{{ url('market') }}">
                    <div class="mt-4 flex flex-col sm:flex-row  md:space-x-4">
                        <x-ui.form.input.text x-model="filter.keyword" value="{{ $searchKeyword }}" type="text" placeholder="Search Item..." class="w-full mt-4" />
                        <x-ui.form.select x-model="filter.city" class="mt-4">
                            @foreach ($cities as $key => $value)
                                <option value="{{ $value }}" {{$value == $city ? 'selected' : '' }}>{{ $key }}</option>
                            @endforeach
                        </x-ui.form.select>
                        <x-ui.form.select x-model="filter.tier" class="mt-4" >
                            @foreach ($tiers as $value)
                                <option value="{{ $value }}" {{$value == $tier ? 'selected' : '' }}>{{ $value }}</option>
                            @endforeach
                        </x-ui.form.select>
                        <x-ui.form.select x-model="filter.enchantment" class="mt-4" >
                            @foreach ($enchantments as $value)
                                <option value="{{ $value }}" {{$value == $enchantment ? 'selected' : '' }}>{{ $value }}</option>
                            @endforeach
                        </x-ui.form.select>
                        <x-ui.button x-on:click="filter()" class="mt-4 text-center" text="Search"/>
                    </div>
                </form>
            </div>
            <x-ui.card.table>

                <x-slot:content>
                    <div class="overflow-x-auto" >
                        <table id="table"
                                class="min-w-full text-center text-sm border-gray-700">
                                <thead class="font-medium">
                                <tr>
                                    <th scope="col"  width='120px' class="border-b border-gray-700 px-6 py-3 text-center">
                                    Item
                                    </th>
                                    <th scope="col" class="border-b border-gray-700 px-6 py-3 text-center">
                                        City
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
                                    <th scope="col" class="border-b border-gray-700 px-6 py-4 text-right">
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
                                                <img x-bind:src="`https://render.albiononline.com/v1/item/${item.item_id}?size=64&quality=${item.quality}`" alt="">
                                            </td>
                                            <td class="whitespace-nowrap border-t border-gray-700 px-6 text-center" x-text='item.city == "5003" ? "Brecilien" : item.city'></td>
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

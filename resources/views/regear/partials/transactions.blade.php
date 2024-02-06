<section>
    <x-ui.card.table>
        <x-slot:title>
           <span x-text="'Regear List ' + (result.total ? '(' + result.total + ' total)'  : '')"/>
        </x-slot>
        <x-slot:icon>
            <x-icons.master-table/>
        </x-slot>
        <x-slot:buttons>
            <x-ui.form.input.text placeholder="Filter Name..." x-model="nameSearch" @input.debounce="reloadData()" />
            <x-ui.form.input.text placeholder="Filter Battle ID..." x-model="battleIdSearch" @input.debounce="reloadData()" />

            <x-ui.form.select x-model="filter.tier">
                <option value="">All Tiers</option>
                @foreach ($tiers as $name => $tier)
                    <option value="{{ $tier }}"> {{ $name }}</option>
                @endforeach
            </x-ui.form.select>

            <x-ui.form.select x-model="filter.status">
                <template x-for="(status, name) in status">
                    <option x-bind:value="status" x-text="name"/>
                </template>
            </x-ui.form.select>

            <x-ui.form.select x-model="filter.role_id">
                <template x-for="(role, index) in ['All Roles'].concat(roles)">
                    <option x-bind:value="index" x-text="role"/>
                </template>
            </x-ui.form.select>
        </x-slot>
        <x-slot:content>
            <div class="overflow-x-auto" x-show="!result.data">
                &nbsp;
            </div>
            <template x-if="result.data">
                <div class="overflow-x-auto" >
                    <table id="table" class="min-w-full table-auto" :class="{ 'opacity-50' : isLoading}">
                            <thead class="font-medium">
                                <tr class="border-gray-700">
                                    <th scope="col" class="text-start py-3 px-5 max-sm:hidden">
                                        {{ __('Battle ID') }}
                                    </th>
                                    <th scope="col" class="text-start py-3 px-5">
                                        {{ __('Name') }}
                                    </th>
                                    <th scope="col" class="text-start py-3 px-5 max-sm:hidden">
                                        {{ __('Tier') }}
                                    </th>
                                    <th scope="col" class="text-start py-3 px-5">
                                        {{ __('Equipment Lost') }}
                                    </th>
                                    <th scope="col" class="text-start py-3 px-5 max-sm:hidden">
                                        {{ __('Death (UTC)') }}
                                    </th>
                                    <th scope="col" class="text-start py-3 px-5 max-sm:hidden">
                                        {{ __('Last Update (UTC)') }}
                                    </th>
                                    <th scope="col" class="text-start py-3 px-5 max-sm:hidden">
                                        {{ __('Chest # / Reason') }}
                                    </th>
                                    <th scope="col" class="text-start py-3 px-5 max-sm:hidden">
                                        {{ __('Processed By') }}
                                    </th>
                                    <th scope="col" class="text-start py-3 px-5">
                                        &nbsp;
                                    </th>
                                </tr>
                            </thead>
                            <tbody>

                            <template x-for="item in result.data">
                                    <tr class="border-t-2 border-gray-700 text-start" :class="{'opacity-50' : item.status <= 0}">

                                        <td class="border-t py-3 px-5 max-sm:hidden"><a class="underline text-indigo-600" target="_blank" x-bind:href="'https://east.albionbattles.com/multilog?ids=' + item.battle_id" x-text="item.battle_id"></a></td>
                                        <td class="border-t py-3 px-5" >
                                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                                                <div class="flex align-middle space-x-1">
                                                    <x-custom.image-icon ::class="'role-' + fetchRoleIcon(item.role_id)"/>
                                                    <span x-text='item.name'/>
                                                </div>
                                                <span class="font-light text-sm sm:hidden" x-text='item.timestamp'/>
                                             </div>
                                        </td>
                                        <td class="border-t py-3 px-5 max-sm:hidden">
                                            <div class="flex align-middle space-x-1">
                                                <x-custom.image-icon ::class="'icon-' + item.member_info.member_tier.toLowerCase()"/>
                                                <span x-text='item.member_info ? item.member_info.member_tier : ""'/>
                                            </div>
                                        </td>
                                        {{-- <td class="border-t py-3 px-5" x-text='item.role_id == -1 ? "N/A" : roles[item.role_id]'></td> --}}
                                        <td class="border-t  py-1 px-5">
                                            <template x-for="equips in item.equipment.split(',')">
                                                <img :class="{'opacity-25 grayscale': equips.includes('!') }" class="inline" x-bind:src="`https://render.albiononline.com/v1/item/${equips.includes('!no_') ? 'QUESTITEM_TOKEN_ADC_FRAME' : equips.includes('!') ? equips.substring(1) : equips }?size=32`" alt="">
                                            </template>
                                        </td>
                                        <td class="border-t py-3 px-5 max-sm:hidden" x-text='item.timestamp'></td>
                                        <td class="border-t py-3 px-5 max-sm:hidden" x-text='item.updated_at'></td>
                                       <td class="border-t py-3 px-5 max-sm:hidden" x-text='item.remarks'></td>
                                       <td class="border-t py-3 px-5 max-sm:hidden" x-text='item.regearing_officer ? item.regearing_officer.username : ""'></td>

                                       <td class=" whitespace-nowrap border-t py-3 px-5">
                                                <div class="space-x-2 flex justify-end">
                                                    <x-ui.button.button-icon type="submit" x-on:click="confirmRegear(item.url)" style="success" x-bind:disabled="item.status == 0 || isLoading" x-show="item.status == 2">
                                                        <x-icons.button.approve/>
                                                     </x-ui.button.button-icon>
                                                     <x-ui.icon-pill  x-show="item.status == 1">
                                                        <x-icons.button.check/>
                                                     </x-ui.icon-pill>
                                                     <x-ui.button.button-icon type="submit" style="danger" x-on:click="confirmRegear(item.url, false)" x-bind:disabled="item.status == 0 || isLoading" x-show="item.status == 2">
                                                        <x-icons.button.close/>
                                                     </x-ui.button.button-icon>
                                                    <x-ui.icon-pill  x-show="item.status == -1">
                                                        <x-icons.button.close/>
                                                     </x-ui.icon-pill>
                                                     <form method="post" :action="item.url + '/request'" x-show="item.status == 0">
                                                        @csrf
                                                        @method('patch')
                                                        <x-ui.button.button-icon type="submit">
                                                            <x-icons.button.create/>
                                                        </x-ui.button.button-icon>
                                                    </form>
                                                </div>

                                            </td>
                                    </tr>
                            </template>
                            </tbody>
                        </table>
                </div>
            </template>
            <div class="p-6 flex justify-end" x-show="result.last_page > 1">
                <x-ui.pagination links="result.links" click-method="loadRegear(link.url)"></x-ui.pagination>
            </div>

        </x-slot>
    </x-ui.card>

    <x-ui.modal name="confirm-regear" focusable>
        <div class="p-6">

            <h2 class="text-lg font-medium text-gray-100">
                <span x-text="ui.confirmHeader"/>
            </h2>

            <div class="mt-6">
                <x-ui.form.input.text
                    class="mt-1 block w-full"
                    x-model="ui.remarks"
                    x-bind:placeholder="ui.confirmPlaceholder"
                />

            </div>

            <div class="mt-6 flex justify-end">
                <x-ui.button style="secondary" text="{{ __('Cancel') }}" x-on:click="$dispatch('close')">
                </x-ui.button>
                <x-ui.button type="submit" style="success" class="ml-3" text="{{ __('Proceed') }}" x-on:click="proceedRegear()">
                </x-ui.button>
            </div>
        </div>
    </x-ui.modal>

</section>

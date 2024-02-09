<section x-data="builds" x-init="init()">
    <div class="overflow-x-auto" >
        <x-ui.card.table class="mb-6">
            <x-slot:title>
                {{ __("Approved ZvZ Builds")}}
            </x-slot>
            <x-slot:icon>
                <x-icons.master-table/>
            </x-slot>
            <x-slot:buttons>
                <span x-show="isLoading" class="flex items-center animate-spin mr-2 max-sm:hidden"><x-icons.button.refresh /></span>
                <x-ui.form.select x-model="filter.role_id">
                    <template x-for="(role, index) in ['All Roles'].concat(roles)">
                        <option x-bind:value="index" x-text="role"/>
                    </template>
                </x-ui.form.select>
            </x-slot>
            <x-slot:content>
                <table class="min-w-full table-auto">
                    <thead class="font-medium">
                        <tr class="border-gray-700">
                            <th scope="col" class="text-start py-3 px-5">
                                {{ __('Role') }}
                            </th>
                            <th scope="col" class="text-start py-3 px-5">
                                {{ __('Equipment') }}
                            </th>

                            <th scope="col" class="text-start py-3 px-5 max-sm:hidden">
                                {{ __('Alt Equipment') }}
                            </th>
                            <th scope="col" class="text-start py-3 px-5 max-sm:hidden">
                                {{ __('Notes') }}
                            </th>

                        </tr>
                    </thead>
                    <tbody>
                        <template x-for="build in builds">
                            <tr class="border-t-2 border-gray-700 text-start">
                                <td class="border-t py-3 px-5" >
                                    <div class="flex  items-center space-x-1">
                                        <x-custom.image-icon ::class="'role-' + build.role_id"/>
                                        <span x-text='roles[build.role_id]'/>
                                    </div>
                                </td>
                                <td class="border-t  py-1 px-5">
                                    <template x-for="equips in build.equipment_list">
                                        <img :class="{'opacity-25 grayscale': equips[0].includes('!') || !equips[0] }" class="inline" x-bind:src="`https://render.albiononline.com/v1/item/${equips[0].includes('!no_') || !equips[0] ? 'QUESTITEM_TOKEN_ADC_FRAME' : equips[0].includes('!') ? equips[0].substring(1) : equips[0] }?size=48`" alt="">
                                    </template>
                                    <template x-for="items in build.consumable_list">
                                        <template x-for="(equip, index) in items">
                                            <img :class="{'opacity-25 grayscale': equip.includes('!') }" class="inline" x-bind:src="`https://render.albiononline.com/v1/item/${equip.includes('!no_') ? 'QUESTITEM_TOKEN_ADC_FRAME' : equip.includes('!') ? equip.substring(1) : equip }?size=48`" alt="">
                                        </template>
                                    </template>
                                </td>
                                <td class="border-t  py-1 px-5 max-sm:hidden">
                                    <template x-for="equips in build.equipment_list">
                                        <template x-for="(equip, index) in equips">
                                            <img x-show="index != 0" class="inline opacity-50" x-bind:src="`https://render.albiononline.com/v1/item/${equip.includes('!no_') ? 'QUESTITEM_TOKEN_ADC_FRAME' : equip.includes('!') ? equip.substring(1) : equip }?size=48`" alt="">
                                        </template>
                                    </template>
                                </td>

                               <td class="border-t py-3 px-5 max-sm:hidden" x-text='build.notes'></td>


                            </tr>
                    </template>
                    </tbody>
                </table>


            </x-slot>
        </x-ui.card>
</div>

</section>

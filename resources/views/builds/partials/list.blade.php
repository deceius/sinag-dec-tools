<section x-data="builds" x-init="init()">
    <div>
     <x-ui.card.table class="mb-6">
        <x-slot:title>
            <span x-text="'Build List'"/>
        </x-slot>
        <x-slot:icon>
            <x-icons.master-table/>
        </x-slot>
        <x-slot:buttons>
            <x-ui.form.select x-model="filter.role_id">
                <template x-for="(role, index) in ['All Roles'].concat(roles)">
                    <option x-bind:value="index" x-text="role"/>
                </template>
            </x-ui.form.select>
        </x-slot>
        <x-slot:content>
            <table class="min-w-full" x-show="builds.length != 0">
                <thead>
                    <th class="text-start py-3 px-5">Role</th>
                    <th class="text-start py-3 px-5">Equipment</th>
                    <th class="text-start py-3 px-5">Notes</th>
                    <th class="text-start py-3 px-5">Last Update</th>
                    <th class="text-start py-3 px-5"></th>
                </thead>
                <tbody>
                    <template x-for="build in builds">
                        <tr class="  border-t border-gray-700 ">
                            <td class="py-3 px-5" >
                                <div class="flex  items-center space-x-1">
                                    <x-custom.image-icon ::class="'role-' + build.role_id"/>
                                    <span x-text='roles[build.role_id]'/>
                                </div>
                            </td>
                            <td class="py-2 px-5">
                                <template x-for="equips in build.equipment_list">
                                    <img :class="{'opacity-25 grayscale': equips[0].includes('!') || !equips[0] }" class="inline" x-bind:src="`https://render.albiononline.com/v1/item/${equips[0].includes('!no_') || !equips[0] ? 'QUESTITEM_TOKEN_ADC_FRAME' : equips[0].includes('!') ? equips[0].substring(1) : equips[0] }?size=48`" alt="">
                                </template>
                                <template x-for="items in build.consumable_list">
                                    <template x-for="(equip, index) in items">
                                        <img :class="{'opacity-25 grayscale': equip.includes('!') }" class="inline" x-bind:src="`https://render.albiononline.com/v1/item/${equip.includes('!no_') ? 'QUESTITEM_TOKEN_ADC_FRAME' : equip.includes('!') ? equip.substring(1) : equip }?size=48`" alt="">
                                    </template>
                                </template>
                            </td>
                            <td class="py-2 px-5" x-text="build.notes"/>
                            <td class="py-2 px-5" x-text="build.updated_at"/>
                            <td class=" whitespace-nowrap py-3 px-5 text-end">
                                <div class="space-x-2 flex justify-end">
                                    <form method="get" :action="build.url + '/edit'" >
                                        <x-ui.button.button-icon type="submit" style="success">
                                            <x-icons.button.edit/>
                                        </x-ui.button>
                                    </form>
                                    <form method="post" :action="build.url + '/delete'" >
                                        @csrf
                                        @method('post')
                                        <x-ui.button.button-icon type="submit" style="danger">
                                            <x-icons.button.close/>
                                        </x-ui.button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>


        </x-slot>
    </x-ui.card>
</div>

</section>

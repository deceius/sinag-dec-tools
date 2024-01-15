<section x-data="builds" x-init="init()">
    <div>
     <x-ui.card.table class="mb-6">
        <x-slot:title>
            <span x-text="'Approved Builds'"/>
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
                    <th class="text-start py-3 px-5">Weapon</th>
                    <th class="text-start py-3 px-5">Role</th>
                    <th class="text-start py-3 px-5">Created Date</th>
                    <th class="text-start py-3 px-5">Notes</th>
                    <th class="text-start py-3 px-5"></th>
                </thead>
                <tbody>
                    <template x-for="build in builds">
                        <tr class="  border-t border-gray-700 ">
                            <td class="py-2 px-5">
                                <img x-bind:src="`https://render.albiononline.com/v1/item/${  build.equipment_list[0][0] }?size=64`">
                            </td>
                            <td class="py-2 px-5" x-text="roles[build.role_id]"/>
                            <td class="py-2 px-5" x-text="build.created_at"/>
                            <td class="py-2 px-5" x-text="build.notes"/>
                            <td class=" whitespace-nowrap py-3 px-5 text-end">
                                <form method="get" :action="build.url + '/edit'" >
                                    <x-ui.button.button-icon type="submit" style="primary">
                                        <x-icons.button.edit/>
                                    </x-ui.button>
                                </form>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>


        </x-slot>
    </x-ui.card>
</div>

</section>

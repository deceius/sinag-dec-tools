<section>
    <x-ui.card.table class="mb-6">
        <x-slot:title>
            {{ __('SINAG Weekly Top 5 KF Kills') }}
        </x-slot>
        <x-slot:icon>
            <x-icons.master-table/>
        </x-slot>
        <x-slot:buttons>
            <span x-show="isLoading" class="animate-spin mr-2 max-sm:hidden"><x-icons.button.refresh /></span>
        </x-slot>
        <x-slot:content>
            <div class="overflow-x-auto" x-show="!killsData">
                &nbsp;
            </div>
            <template x-if="killsData">
                <div class="overflow-x-auto" >
                    <table id="table" class="min-w-full table-auto">
                            <thead class="font-medium">
                                <tr class="border-gray-700">
                                    <th scope="col" class="text-start py-3 px-5">
                                        {{ __('Killer ') }}
                                    </th>
                                    <th scope="col" class="text-start py-3 px-5">
                                        {{ __('Victim') }}
                                    </th>
                                    <th scope="col" class="text-start py-3 px-5">
                                        {{ __('Kill Fame') }}
                                    </th>

                                </tr>
                            </thead>
                            <tbody>

                            <template x-for="item in killsData">
                                    <tr class="border-t-2 border-gray-700 text-start" >
                                        <td class="border-t py-3 px-5">
                                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                                               <span x-text='item.Killer.Name'/>
                                               <small x-text='item.Killer.GuildName'/>
                                            </div>
                                        </td>
                                        <td class="border-t py-3 px-5" >
                                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                                                <span x-text='item.Victim.Name'/>
                                                <small x-text='item.Victim.GuildName'/>
                                             </div>
                                        </td>
                                        <td class="border-t py-3 px-5" x-text='item.TotalVictimKillFame.toLocaleString("en-US")'></td>


                                    </tr>
                            </template>
                            </tbody>
                        </table>
                </div>
            </template>

        </x-slot>
    </x-ui.card>


</section>

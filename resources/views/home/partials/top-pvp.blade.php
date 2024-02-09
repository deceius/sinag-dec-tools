<section>
    <x-ui.card.table class="mb-6">
        <x-slot:title>
            {{ __('SINAG Top 5 PvP G.O.A.T.') }}
        </x-slot>
        <x-slot:icon>
            <x-icons.master-table/>
        </x-slot>
        <x-slot:buttons>
            <span x-show="isLoading" class="flex items-center animate-spin mr-2 max-sm:hidden"><x-icons.button.refresh /></span>
        </x-slot>
        <x-slot:content>
            <div class="overflow-x-auto" x-show="!goatData">
                &nbsp;
            </div>
            <template x-if="goatData">
                <div class="overflow-x-auto" >
                    <table id="table" class="min-w-full table-auto">
                            <thead class="font-medium">
                                <tr class="border-gray-700">
                                    <th scope="col" class="text-start py-3 px-5">
                                        {{ __('Name') }}
                                    </th>
                                    <th scope="col" class="text-start py-3 px-5">
                                        {{ __('Total Kill Fame') }}
                                    </th>

                                </tr>
                            </thead>
                            <tbody>

                            <template x-for="item in goatData">
                                    <tr class="border-t-2 border-gray-700 text-start" >
                                        <td class="border-t py-3 px-5">
                                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                                               <span x-text='item.Name'/>
                                               <small x-text='"KD Ratio: " + item.FameRatio'/>
                                            </div>
                                        </td>
                                        <td class="border-t py-3 px-5" x-text='item.KillFame.toLocaleString("en-US")'></td>


                                    </tr>
                            </template>
                            </tbody>
                        </table>
                </div>
            </template>

        </x-slot>
    </x-ui.card>


</section>

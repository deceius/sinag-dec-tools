<section>
    <x-ui.card.table class="mb-6">
        <x-slot:title>
            {{ __('SINAG Top 5 CTA DPS of All Time') }}
        </x-slot>
        <x-slot:icon>
            <x-icons.fire-solid/>
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
                                        {{ __('Kill Fame') }}
                                    </th>

                                </tr>
                            </thead>
                            <tbody>

                            <template x-for="item in goatData">
                                    <tr class="border-t-2 border-gray-700 text-start" >
                                        <td class="border-t py-3 px-5">
                                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                                               <span x-text='item.name'/>
                                            </div>
                                            <span class="font-light text-sm" x-text='"KD Ratio: " + item.c_ratio'/>
                                        </td>
                                        <td class="border-t py-3 px-5">
                                            <div style="display: flex; flex-direction: column; align-items: flex-start;">
                                                <span x-text='item.kf.toLocaleString("en-US")'/>
                                            </div>
                                            <span class="font-light text-sm" x-text='"Fame Ratio: " + item.f_ratio'/>
                                        </td>
                                    </tr>
                            </template>
                            </tbody>
                        </table>
                </div>
            </template>

        </x-slot>
    </x-ui.card>


</section>

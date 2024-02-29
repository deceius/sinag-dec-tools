<section x-data="deathlog"  x-init="init('{{ Auth::user()->ao_character_id }}')">
    <x-ui.card.table>
        <x-slot:title>
            {{ __('Request Regears') }}
        </x-slot>
        <x-slot:icon>
            <x-icons.request/>
        </x-slot>
        <x-slot:buttons>
            {{-- <x-ui.button.link href="{{ route('build.create') }}" style="success" text="{{ __('OC Break Request') }}">
                <x-slot:icon>
                    <x-icons.button.bolt/>
                </x-slot>
            </x-ui.button.link> --}}
        </x-slot>
        <x-slot:content>
            <div class="overflow-x-auto" x-show="!result.data">
                &nbsp;
            </div>
            <template x-if="result.data">
                <div class="overflow-x-auto" >
                    <table id="table" class="min-w-full table-auto">
                            <thead class="font-medium">
                                <tr class="border-gray-700">
                                    <th scope="col" class="text-start py-3 px-5">
                                        {{ __('Battle ID') }}
                                    </th>
                                    <th scope="col" class="text-start py-3 px-5">
                                        {{ __('Equipment Lost') }}
                                    </th>
                                    <th scope="col" class="text-start py-3 px-5 max-sm:hidden">
                                        {{ __('Chest # / Reason') }}
                                    </th>
                                    <th scope="col" class="text-start py-3 px-5 max-sm:hidden">
                                        {{ __('Last Updated') }}
                                    </th>
                                    <th scope="col" class="text-start py-3 px-5  max-sm:hidden">
                                        {{ __('Processed By') }}
                                    </th>
                                    <th scope="col" class="text-start py-3 px-5">
                                        &nbsp;
                                    </th>
                                </tr>
                            </thead>
                            <tbody>

                            <template x-for="item in result.data">
                                    <tr class="border-t-2 border-gray-700 text-start" :class="{'opacity-50' : item.status < 0}">
                                        <td class="border-t py-3 px-5" >
                                            <a class="underline text-indigo-600" target="_blank" x-bind:href="'https://east.albionbattles.com/multilog?ids=' + item.battle_id" x-text="item.battle_id"></a>
                                            <small class="font-light block" x-text='item.timestamp'/>
                                        </td>
                                            <td class="border-gray-700 py-1 px-5">
                                            <template x-for="equips in item.equipment.split(',')">
                                                <img :class="{'opacity-25 grayscale': equips.includes('!') }" class="inline" x-bind:src="`https://render.albiononline.com/v1/item/${equips.includes('!no_') ? 'QUESTITEM_TOKEN_ADC_FRAME' : equips.includes('!') ? equips.substring(1) : equips }?size=48`" alt="">
                                            </template>
                                        </td>
                                        <td class="py-3 px-5 max-sm:hidden " x-text='item.remarks'></td>
                                        <td class="py-3 px-5 max-sm:hidden " x-text='item.updated_at'></td>
                                        <td class="py-3 px-5  max-sm:hidden" x-text='item.regearing_officer ? item.regearing_officer.username : ""'></td>
                                            <td class=" whitespace-nowrap border-t py-3 px-5 text-end">

                                                <div class="space-x-2 flex justify-end">
                                                <form method="post" :action="item.url + '/request'" >
                                                    @csrf
                                                    @method('patch')
                                                    <x-ui.button type="submit" style="success" text="Request" x-show="item.status == 0">
                                                        <x-slot:icon><x-icons.button.create/></x-slot>
                                                    </x-ui.button>
                                                    <x-ui.icon-pill x-show="item.status == 2">
                                                        <x-icons.button.doc-text/>
                                                     </x-ui.icon-pill>
                                                    <x-ui.icon-pill  x-show="item.status == 1">
                                                        <x-icons.button.check/>
                                                     </x-ui.icon-pill>
                                                     <x-ui.icon-pill  x-show="item.status == -1">
                                                        <x-icons.button.close/>
                                                     </x-ui.icon-pill>
                                                </form>

                                                <form method="post" :action="item.url + '/discard'"  x-show="item.status == 0">
                                                    @csrf
                                                    @method('patch')
                                                    <x-ui.button type="submit" style="danger" text="Discard" x-show="item.status == 0">
                                                        <x-slot:icon><x-icons.button.close/></x-slot>
                                                    </x-ui.button>
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
                <x-ui.pagination links="result.links" click-method="loadDeathLog(link.url, albionId)"></x-ui.pagination>
            </div>
        </x-slot>
    </x-ui.card>

</section>

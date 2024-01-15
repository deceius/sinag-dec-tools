<section x-data="builds" x-init="init()">
    <div>
<template x-for="(role, index) in roles">
     <x-ui.card.table class="mb-6">
        <x-slot:title>
            <span x-text="role"/>
        </x-slot>
        <x-slot:icon>
            <x-icons.master-table/>
        </x-slot>
        <x-slot:content>
            <table class="min-w-full">
                <tbody>
                    <template x-for="build in builds">
                        <tr class=" flex border-t border-gray-700 " x-show="build.role_id == index">
                            <td class="py-2 px-5">
                                <div class=" align-top">
                                    <div class="grid xl:grid-cols-9 grid-cols-5">
                                        <template x-for="item in build.equipment_list">
                                            <div class="grid grid-cols-1 align-top">
                                                <template x-for="(sub, index) in item">
                                                        <div class="w-16 h-16">
                                                            <img :class="{'opacity-25 grayscale': !sub, 'opacity-50' : index != 0}" x-bind:src="`https://render.albiononline.com/v1/item/${ sub ? sub : 'QUESTITEM_TOKEN_ADC_FRAME' }?size=64`">
                                                        </div>
                                                </template>
                                            </div>
                                        </template>
                                        <template x-for="item in build.consumable_list">
                                            <div class="grid grid-cols-1">
                                                <template x-for="(sub, index) in item">
                                                        <div class="w-16">
                                                            <img :class="{'opacity-25 grayscale': !sub, 'opacity-50' : index != 0}" x-bind:src="`https://render.albiononline.com/v1/item/${ sub ? sub : 'QUESTITEM_TOKEN_ADC_FRAME' }?size=64`">
                                                        </div>
                                                </template>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </td>

                            <td class="py-2 px-5" x-text="build.notes"/>
                        </tr>
                    </template>
                </tbody>
            </table>


        </x-slot>
    </x-ui.card>
</template>
</div>

</section>

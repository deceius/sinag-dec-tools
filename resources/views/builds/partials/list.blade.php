<section x-data="builds" x-init="init()">
    <div >
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
                        <tr class=" flex border-t border-gray-700 dark:border-gray-700" x-show="build.role_id == index">
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
                        </tr>
                    </template>
                </tbody>
            </table>


        </x-slot>
    </x-ui.card>
</template>
</div>
{{--
    <x-ui.card>
        <x-slot:title><h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Bind Albion Online Character') }}

        </h2>
       </x-slot>
        <x-slot:icon>
           <x-icons.form/>
        </x-slot>
        <x-slot:buttons>
            <x-ui.search model="filter.search" click-method="load()"/>

        </x-slot>
        <x-slot:content>
            <form method="post" action="{{ route('home') }}" >
                @csrf
                @method('put')

                <div class="mb-6">
                    <x-ui.form.input.label for="update_ao_character" :value="__('Search IGN')" />
                    <x-ui.form.input.text id="update_ao_character" name="ao_character" type="text" class="mt-1 block w-full" />
                    <x-ui.form.input.error :messages="$errors->updatePassword->get('ao_character')" class="mt-2" />
                </div>

                <div class="flex items-center gap-4">
                    <x-ui.button text="Search"/>

                    @if (session('status') === 'password-updated')
                        <p
                            x-data="{ show: true }"
                            x-show="show"
                            x-transition
                            x-init="setTimeout(() => show = false, 2000)"
                            class="text-sm text-gray-600 dark:text-gray-400"
                        >{{ __('Saved.') }}</p>
                    @endif
                </div>
            </form>
        </x-slot>
    </x-ui.card> --}}


</section>

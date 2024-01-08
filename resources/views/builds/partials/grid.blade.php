<section x-data="builds" x-init="init()">
    <template x-for="(role, index) in roles">
        <x-ui.card.table class="mb-6">
            <x-slot:title>
                <span x-text="role"/>
            </x-slot>
            <x-slot:icon>
                <x-icons.master-table/>
            </x-slot>
            <x-slot:content>
                <div class="flex ">
                    <div class="grid grid-flow-col auto-cols-max">
                        <template x-for="build in builds">
                                <div class="py-2 px-5 mb-6" x-show="build.role_id == index">
                                    <div class="flex align-top">
                                        <div class="grid grid-cols-3 grid-rows-3">
                                            <div></div>
                                            <x-custom.item-img x-show="build.equipment_list[2][0]" item="parseImage(build.equipment_list[2][0])"/>
                                            <x-custom.item-img x-show="build.equipment_list[5][0]" item="parseImage(build.equipment_list[5][0])"/>
                                            <x-custom.item-img x-show="build.equipment_list[0][0]" item="parseImage(build.equipment_list[0][0])"/>
                                            <x-custom.item-img x-show="build.equipment_list[3][0]" item="parseImage(build.equipment_list[3][0])"/>
                                            <x-custom.item-img x-show="build.equipment_list[1][0]" item="parseImage(build.equipment_list[1][0])"/>
                                            <x-custom.item-img x-show="build.consumable_list[0][0]" item="parseImage(build.consumable_list[0][0])"/>
                                            <x-custom.item-img x-show="build.equipment_list[4][0]" item="parseImage(build.equipment_list[4][0])"/>
                                            <x-custom.item-img x-show="build.consumable_list[1][0]" item="parseImage(build.consumable_list[1][0])"/>
                                        </div>
                                    </div>
                                    <div class="flex  align-top">
                                        <div class="grid grid-cols-3">
                                            <div></div>
                                            <x-custom.item-img x-show="build.consumable_list[2][0]" item="parseImage(build.consumable_list[2][0])"/>
                                            <div></div>
                                        </div>
                                    </div>
                                </div>
                        </template>
                    </div>
                </div>



            </x-slot>
        </x-ui.card>
    </template>
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

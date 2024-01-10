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
            <table class="min-w-full" x-show="builds.length > 1">
                <thead>
                    <th class="text-start py-3 px-5">Weapon</th>
                    <th class="text-start py-3 px-5">Role</th>
                    <th class="text-start py-3 px-5">Created Date</th>
                    <th class="text-start py-3 px-5">Notes</th>
                    <th class="text-start py-3 px-5"></th>
                </thead>
                <tbody>
                    <template x-for="build in builds">
                        <tr class="  border-t border-gray-700 dark:border-gray-700">
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

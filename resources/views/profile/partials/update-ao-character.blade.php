<section x-data="profile">
    <x-ui.card.table>
        <x-slot:title>
            {{ __('IGN Lookup') }}
        </x-slot>
        <x-slot:icon>
            <x-icons.master-table/>
        </x-slot>
        <x-slot:buttons>
            <x-ui.search model="filter.ign" click-method="loadFromAPI()" placeholder="Search..."/>

        </x-slot>
        <x-slot:content ::class="{ 'opacity-50' : isLoading }">

            <div class="overflow-x-auto" x-show="data.length == 0">
                &nbsp;
            </div>
            <template x-if="data.length > 0">
                <div class="overflow-x-auto" >
                    <table id="table" class="min-w-full">
                            <thead class="font-medium">
                                <tr class="border-b-2border-gray-700">
                                    <th scope="col" class="text-start py-3 px-5">
                                        {{ __('Name') }}
                                    </th>
                                    <th scope="col" class="text-start py-3 px-5">
                                        {{ __('Guild') }}
                                    </th>
                                    <th scope="col" class="text-start py-3 px-5">
                                        {{ __('Kill Fame') }}
                                    </th>
                                    <th scope="col" class="text-start py-3 px-5">
                                        &nbsp;
                                    </th>
                                    <th scope="col" class="text-start py-3 px-5">
                                        &nbsp;
                                    </th>
                                </tr>
                            </thead>
                            <tbody>

                            <template x-for="item in data">
                                    <tr class="border-t-2 border-gray-700 text-start">
                                        <td class="border-t py-3 px-5" x-text='item.Name'></td>
                                        <td class="border-t py-3 px-5" x-text='parseGuildName(item.AllianceName, item.GuildName)'></td>
                                        <td class="border-t py-3 px-5" x-text='item.KillFame.toLocaleString("en-US")'></td>
                                        <td class="border-t py-3 px-5 text-gray-400 italic" x-text='item.last'></td>
                                        <td class=" whitespace-nowrap border-t py-3 px-5 text-end">
                                            <td class=" whitespace-nowrap border-t py-3 px-5 text-end">
                                                <form method="post" :action="'{{ Auth::user()->url }}' + '?id=' + item.Id + '&name=' + item.Name" >
                                                    @csrf
                                                    @method('patch')
                                                    <x-ui.button.button-icon type="submit" style="success">
                                                        <x-icons.button.check/>
                                                    </x-ui.button>
                                                </form>
                                            </td>
                                        </td>
                                    </tr>
                            </template>
                            </tbody>
                        </table>
                </div>
            </template>


        </x-slot>
    </x-ui.card>
{{--
    <x-ui.card>
        <x-slot:title><h2 class="text-lg font-medium text-gray-100">
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
                            class="text-sm text-gray-400"
                        >{{ __('Saved.') }}</p>
                    @endif
                </div>
            </form>
        </x-slot>
    </x-ui.card> --}}


</section>

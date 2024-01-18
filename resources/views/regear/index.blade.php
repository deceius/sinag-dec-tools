<x-app-layout>
    <x-slot:header>
        <x-ui.header title="{{ __('Regear Management') }}"/>
    </x-slot>


    <div class="py-12"  x-data="manageRegears"  x-init="init()">
        <div class="max-w-full sm:px-6 lg:px-8 mb-6">
            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div  class="p-6 text-gray-400">
                    <div class="flex justify-between h-5 items-center">
                        <div class="flex space-x-2 items-center leading-tight font-semibold">
                                <x-icons.clipboard/>
                                <span>Open Regears</span>
                        </div>
                        <div class="space-x-1 flex items-center" >
                            <span x-show="isLoading" class="animate-spin mr-2"><x-icons.button.refresh /></span>

                            <x-ui.search-custom-icon placeholder="Enter Battle IDs..."
                            click-method="parseBattles()"
                            disabled="isLoading"
                            model="filter.battleIds">
                                <x-icons.breadcrumb x-if="isLoading"/>
                            </x-ui.search-custom-icon>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="max-w-full sm:px-6 lg:px-8">
            @include('regear.partials.transactions')
        </div>
    </div>
</x-app-layout>

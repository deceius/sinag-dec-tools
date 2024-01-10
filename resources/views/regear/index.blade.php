<x-app-layout>
    <x-slot:header>
        <x-ui.header title="{{ __('Regear Management') }}">
            <x-slot:icon>
                <x-icons.branch-group/>
            </x-slot>
            <x-slot:buttons>
                <x-ui.search-custom-icon placeholder="Enter Battle IDs..."
                model="item.filter"
                click-method="load(item)"
                >
                <x-icons.breadcrumb/>
            </x-ui.search-custom-icon>


            </x-slot>
        </x-ui.header>
    </x-slot>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @include('regear.partials.deathlog')
        </div>
    </div>
</x-app-layout>

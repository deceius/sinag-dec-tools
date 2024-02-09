<x-app-layout>
    <x-slot:header>
        <x-ui.header title="{{ __('Sinag Builds') }}">
            <x-slot:icon>
                <x-icons.branch-group/>
            </x-slot>
        </x-ui.header>
    </x-slot>

    <div class="py-12">
        <div class="max-w-full sm:px-6 lg:px-8">
            @include('builds.partials.grid')
        </div>
    </div>
</x-app-layout>

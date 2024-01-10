<x-app-layout>
    <x-slot:header>
        <x-ui.header title="{{ __('Builds Management') }}">
            <x-slot:icon>
                <x-icons.branch-group/>
            </x-slot>
            <x-slot:buttons>
                <x-ui.button.link href="{{ route('build.create') }}" style="success" text="{{ __('Add New Build') }}">
                    <x-slot:icon>
                        <x-icons.button.create/>
                    </x-slot>
                </x-ui.button.link>
            </x-slot>
        </x-ui.header>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @include('builds.partials.list')
        </div>
    </div>
</x-app-layout>

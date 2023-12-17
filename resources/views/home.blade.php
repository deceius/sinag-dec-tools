<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Home') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-6">
            <x-ui.card>
                <x-slot:title>{{ __('Regear Status') }}</x-slot>
                <x-slot:icon>
                   <x-icons.form/>
                </x-slot>
                <x-slot:content>
                </x-slot>
            </x-ui.card>
        </div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-ui.card>
                <x-slot:title>{{ __('Approved ZvZ Builds') }}</x-slot>
                <x-slot:icon>
                   <x-icons.list/>
                </x-slot>
                <x-slot:content>
                </x-slot>
            </x-ui.card>
        </div>
    </div>
</x-app-layout>

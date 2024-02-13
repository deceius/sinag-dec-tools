<x-app-layout>
    <x-slot:header>
        <x-ui.header title="{{ __('Create OC Break Regear Request') }}"/>
    </x-slot>


    <div class="py-12">
        <div class="max-w-full sm:px-6 lg:px-8 mb-6">
            @include('regear.partials.oc-break-generator')
        </div>
    </div>
</x-app-layout>

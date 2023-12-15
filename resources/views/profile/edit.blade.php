<x-app-layout>
    <x-slot name="header">
        <x-ui.header title="{{ 'Profile' }}" subtitle="{{ 'Bind your AO Character to your SINAG Discord account. Use the IGN Lookup to search for your character.'}}"/>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @include('profile.partials.update-ao-character')
        </div>
    </div>
</x-app-layout>

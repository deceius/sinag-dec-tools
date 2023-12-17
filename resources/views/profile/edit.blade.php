<x-app-layout>
    <x-slot name="header">
        <x-ui.header title="{{ 'Profile' }}" subtitle="{{ Auth::user()->ao_character_id ? 'Below are your Character and SINAG Discord details.' : 'Bind your AO Character to your SINAG Discord account. Use the IGN Lookup to search for your character.'}}"/>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if(Auth::user()->ao_character_id)
                @include('profile.partials.discord-account-info')
                @include('profile.partials.ao-character-info')
                @include('profile.partials.ao-death-info')
            @else
                @include('profile.partials.update-ao-character')
            @endif
        </div>
    </div>
</x-app-layout>

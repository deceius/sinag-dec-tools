<x-app-layout>
    <x-slot name="header">
        <x-ui.header title="{{ 'Profile' }}" subtitle="{{ Auth::user()->ao_character_id ? 'Below are your Character and Oathbreakers Discord details.' : 'Bind your AO Character to your Oathbreakers Discord account. The character must be in the guild IN-GAME for it to appear in IGN Lookup.'}}"/>
    </x-slot>

    <div class="py-12">
        <div class="max-w-full sm:px-6 lg:px-8 space-y-6">
            @if(Auth::user()->ao_character_id)
                @include('profile.partials.ao-character-info')
            @else
                @include('profile.partials.update-ao-character')
            @endif
        </div>
    </div>
</x-app-layout>

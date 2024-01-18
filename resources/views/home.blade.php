<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            {{ __('Home') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-full sm:px-6 lg:px-8 mb-6 space-y-6">
            @if(Auth::user()->ao_character_id)
                @include('regear.partials.member')
                @include('profile.partials.ao-character-info')
            @else
                @include('profile.partials.update-ao-character')
            @endif
        </div>


        <div class="lg:grid lg:grid-cols-2 lg:gap-6 max-w-full sm:px-6 lg:px-8" x-data="home" x-init="init()">
            @include('home.partials.top-pvp')
            @include('home.partials.top-kills')
        </div>

    </div>
</x-app-layout>

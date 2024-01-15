<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-200 leading-tight">
            {{ __('Home') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-6">
            @include('regear.partials.member')
        </div>

        <div class="lg:grid lg:grid-cols-2 lg:gap-6 max-w-7xl mx-auto sm:px-6 lg:px-8" x-data="home" x-init="init()">
            @include('home.partials.top-pvp')
            @include('home.partials.top-kills')
        </div>

    </div>
</x-app-layout>

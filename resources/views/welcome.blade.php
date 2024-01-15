<x-guest-layout>

    <div class="flex justify-center mt-6">
        <img src="{{ url('assets/sinag-logo.png')}}" width="256px"/>

    </div>
    <div class="py-12" x-data="home" x-init="init()">

        <div class="lg:grid lg:grid-cols-2 lg:gap-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
            @include('home.partials.top-pvp')
            @include('home.partials.top-kills')
        </div>
    </div>
</x-app-layout>

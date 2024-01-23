<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ (config('app.debug') ? 'DEV' : config('app.name')) . ' - v' . config('app.version') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-900">
            @include('layouts.dev-banner')
            @if (!Auth::user()->ao_character_id)
                        <div class="p-4 bg-red-600 font-semibold text-sm text-gray-200 leading-tight">
                            It appears that you haven't registered you AO character. Click <a class="underline text-gray-100" href="/home">here</a> to register.
                        </div>
                    @endif
            @include('layouts.navigation')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-gray-800 shadow">

                    <div class="max-w-full py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>

                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>

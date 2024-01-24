@if (App::environment('local'))
    <div class="p-2 bg-yellow-600 font-semibold text-sm text-gray-200 leading-tight">
        {{ (config('app.debug') ? 'Dev Build' : config('app.name') ). ' - v' . config('app.version') }}
    </div>
@endif

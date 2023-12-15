
@props(['action', 'method', 'text', 'style' => 'primary'])
<form method="{{ $method }}" action="{{ $action }}">
    @csrf
    @method('PATCH')
    <x-ui.button type="submit" style="{{ $style }}" text="{{ $text }}">
        <x-slot:icon>
            {{ $slot }}
        </x-slot>
    </x-ui.button>
</form>


@props(['action', 'text'])
<x-ui.button.form-button method="post" action="{{ $action }}" text="{{ $text }}" style="danger">
    <x-icons.button.close/>
</x-ui.button.form-button>

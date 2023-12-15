
@props(['action', 'text'])
<x-ui.button.form-button method="post" action="{{ $action }}" text="{{ $text }}" style="success">
    <x-icons.button.check/>
</x-ui.button.form-button>

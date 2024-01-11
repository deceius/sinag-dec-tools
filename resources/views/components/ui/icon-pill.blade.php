
@props(['style' => 'primary', 'type' => 'button'])
@php
switch ($style) {
    case 'secondary':
        $classes = 'inline-flex items-center p-2 bg-white dark:bg-gray-800  border dark:border-gray-700 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm disabled:opacity-25 transition ease-in-out duration-150';
        break;
    case 'success':
        $classes = 'inline-flex items-center p-2 bg-green-600  border border-transparent rounded-md font-semibold text-xs text-gray-600 dark:text-gray-100 uppercase tracking-widest transition ease-in-out duration-150';
        break;
    case 'danger':
        $classes = 'inline-flex items-center p-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-gray-600 dark:text-gray-400 uppercase tracking-widest transition ease-in-out duration-150';
        break;
    default:
        $classes = 'inline-flex items-center p-2 bg-gray-800  border dark:border-gray-700 rounded-md font-semibold text-xs text-gray-600 dark:text-gray-400 uppercase tracking-widest transition ease-in-out duration-150';
        break;
}
@endphp
<div {{ $attributes->merge(['class' => $classes]) }}>
    <div class="flex space-x-2 items-center h-5">
        {{ $slot }}
   </div>
</div>

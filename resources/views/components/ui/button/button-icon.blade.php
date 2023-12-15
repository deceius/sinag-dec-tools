
@props(['style' => 'primary', 'type' => 'button'])
@php
switch ($style) {
    case 'secondary':
        $classes = 'inline-flex items-center p-2 bg-white disabled:opacity-25 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150';
        break;
    case 'success':
        $classes = 'inline-flex items-center p-2 bg-green-600 disabled:opacity-25 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-500 active:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150';
        break;
    case 'danger':
        $classes = 'inline-flex items-center p-2 bg-red-600 disabled:opacity-25 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150';
        break;
    default:
        $classes = 'inline-flex items-center p-2 bg-gray-800 disabled:opacity-25 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150';
        break;
}
@endphp
<button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
    <div class="flex space-x-2 items-center h-5">
        {{ $slot }}
   </div>
  </button>

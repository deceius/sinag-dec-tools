

@php
$classes = ($active ?? false)
            ? 'block w-full px-4 py-2 text-left text-sm leading-5 font-semibold border-indigo-600 text-sm font-medium leading-5 text-gray-100 focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out'
            : 'block w-full px-4 py-2 text-left text-sm leading-5 border-transparent text-sm font-medium leading-5 text-gray-400 hover:text-gray-300 hover:border-gray-700 focus:outline-none focus:text-gray-300 focus:border-gray-300 focus:border-gray-700 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>{{ $slot }}</a>

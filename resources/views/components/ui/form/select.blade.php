@props(['disabled' => false])

<select {{ $disabled ? 'disabled' : '' }}
{!! $attributes->merge(['class' => ' text-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-600 rounded-md shadow-sm disabled:opacity-50']) !!}>
    {{ $slot }}
</select>

<div {{ $attributes->merge(['class' => 'bg-white dark:bg-gray-800 md:overflow-hidden shadow-sm']) }}>
    <div class="text-gray-900 py-6 px-4 sm:px-6 lg:px-8 flex justify-between">
        {{ $slot }}
    </div>
</div>

@props(['clickMethod', 'model'])
<div class="inline-flex items-center bg-white dark:bg-gray-800 disabled:bg-gray-200 border border-gray-300 rounded-md text-xs text-gray-700 uppercase tracking-widest shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
    <input x-model="{{ $model }}" x-on:keyup.enter="{{ $clickMethod }}" class="text-sm border-0 px-5 rounded-lg focus:ring-0" type="text" name="search" placeholder="Search">
    <button x-on:click="{{ $clickMethod }}" type="button" class="px-3 py-2">
        <x-icons.search-bar-icon/>
    </button>
</div>

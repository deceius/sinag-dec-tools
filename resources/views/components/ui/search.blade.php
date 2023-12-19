@props(['clickMethod', 'model', 'prompt' => 'Search'])
<div class="inline-flex items-center bg-transparent dark:bg-gray-900 disabled:bg-gray-200 border border-gray-300 dark:border-gray-700 rounded-md text-xs text-gray-700 uppercase tracking-widest shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
    <input x-model="{{ $model }}" x-on:keyup.enter="{{ $clickMethod }}" class="bg-transparent dark:bg-gray-900 text-sm dark:text-gray-400 border-0 px-5 rounded-lg focus:ring-0" type="text" name="search" placeholder="{{ $prompt }}">
    <button x-on:click="{{ $clickMethod }}" type="button" class="px-3 py-2 ">
        <x-icons.search-bar-icon/>
    </button>
</div>

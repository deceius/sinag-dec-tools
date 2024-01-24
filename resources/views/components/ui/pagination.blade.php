@props(['links', 'clickMethod' => 'loadPage(link.url)'])
<nav class="isolate -space-x-px rounded-md shadow-sm">
    <template x-for="(link, index) in {{ $links }}">
        <x-ui.pagination.link class="text-gray-400 bg-gray-800 hover:bg-gray-700 focus:bg-gray-700" x-on:click=" {{ $clickMethod }}" x-text="link.label" index="index" ::class="{ 'opacity-25' : !link.active, 'bg-gray-900' : link.active, 'hover:bg-gray-100' : !link.active, 'rounded-l-md' : index == 0, 'rounded-r-md' : index == {{ $links }}.length - 1 }" ></x-ui.pagination.link>
    </template>
</nav>

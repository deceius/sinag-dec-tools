@props(['links'])
<nav class="isolate -space-x-px rounded-md shadow-sm">
    <template x-for="(link, index) in {{ $links }}">
        <x-ui.pagination.link x-on:click="loadPage(link.url)" x-text="link.label" index="index" ::class="{ 'bg-gray-800' : !link.active, 'bg-gray-900 text-white' : link.active, 'text-gray-900 hover:bg-gray-100' : !link.active, 'rounded-l-md' : index == 0, 'rounded-r-md' : index == {{ $links }}.length - 1 }" ></x-ui.pagination.link>
    </template>
</nav>

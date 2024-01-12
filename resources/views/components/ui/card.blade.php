
@props(['title'])
<div {{ $attributes->merge(['class' => 'bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg']) }}>
    @isset($title)
    <div  {{ $title->attributes->merge(['class' => 'p-6 text-gray-400']) }}>
        <div class="flex justify-between h-5 items-center">
            <div class="flex space-x-2 items-center leading-tight font-semibold">
                    {{ $icon ?? '' }}
                    <span>{{ $title ?? '' }}</span>
            </div>
            <div class="space-x-1 flex items-center">
                {{ $buttons ?? '' }}
            </div>
        </div>
    </div>
    <x-ui.separator></x-ui.separator>
    @endisset

    <div {{ $content->attributes->merge(['class' => 'p-6 text-gray-900']) }}>
        {{ $content }}
    </div>
</div>

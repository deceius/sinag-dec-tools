
@props(['title'])
<div {{ $attributes->merge(['class' => 'bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg']) }}>
    @isset($title)
    <div  {{ $title->attributes->merge(['class' => 'p-6 text-gray-400']) }}>
        <div class="flex flex-col sm:flex-row justify-between lg:h-5 lg:items-center">
            <div class="flex space-x-2 items-center leading-tight font-semibold max-sm:mb-2">
                    {{ $icon ?? '' }}
                    <span>{{ $title ?? '' }}</span>
            </div>
            <div class="lg:space-x-2 max-sm:space-y-2 flex flex-col sm:flex-row">
                {{ $buttons ?? '' }}
            </div>
        </div>
    </div>
    <x-ui.separator></x-ui.separator>
    @endisset

    <div {{ $content->attributes->merge(['class' => 'text-gray-400']) }}>
        {{ $content }}
    </div>
</div>

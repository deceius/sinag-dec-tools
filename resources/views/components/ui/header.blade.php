<h2 class="flex font-semibold text-md text-gray-800 leading-tight justify-between">
    <div class="flex space-x-2 items-center h-5">
        {{ $icon ?? '' }}
        {{ $prevLevel ?? '' }}
        <span>{{ $title }}</span>
   </div>
   <div class="space-x-2 flex items-center h-5">
        {{ $buttons ?? ''}}
    </div>
</h2>

@props(['data'])
<div class="space-y-3 justify-center flex flex-col items-center text-gray-400 mb-6">
    <div>
        <svg xmlns="http://www.w3.org/2000/svg" width="120" height="120" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
            <path d="M15 15m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
            <path d="M18.5 18.5l2.5 2.5" />
            <path d="M4 6h16" />
            <path d="M4 12h4" />
            <path d="M4 18h4" />
          </svg>
    </div>
    <span>No {{ $data }} Data found.</span>
</div>

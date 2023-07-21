{{-- alert success start --}}
<div id="greenAlert"
    class="floating-alert items-center p-3 mb-4 w-md text-sm text-green-800 border border-green-300 rounded-lg bg-green-50 relative hidden"
    role="alert">
    <svg class="flex-shrink-0 inline w-4 h-4 mr-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
        viewBox="0 0 20 20">
        <path
            d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
    </svg>
    <span class="sr-only">Info</span>
    <span class="font-medium">Success !</span>
    <span id="greenMsg">
        {{-- success message content --}}
    </span>
    <div class="absolute bottom-0 left-0 w-full h-1 bg-green-500">
        <div class="loadingBarGreen h-full bg-green-200 w-0"></div>
    </div>
</div>
{{-- alert success end --}}
{{-- alert error start --}}
<div id="redAlert"
    class="floating-alert items-center p-3 mb-4 w-md text-sm text-red-800 border border-red-300 rounded-lg bg-red-50 relative hidden"
    role="alert">
    <svg class="flex-shrink-0 inline w-4 h-4 mr-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
        fill="currentColor" viewBox="0 0 20 20">
        <path
            d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
    </svg>
    <span class="sr-only">Info</span>
    <span class="font-medium">Error !</span>
    <span id="redMsg">
        {{-- error message content --}}
    </span>
    <div class="absolute bottom-0 left-0 w-full h-1 bg-red-500">
        <div class="loadingBarRed h-full bg-red-200 w-0"></div>
    </div>
</div>
{{-- alert error end --}}

<div>
    @if($show)
        <div x-data="{ show: @entangle('show') }" x-show="show" x-transition:leave.opacity.duration.1500ms {{-- Ligne
            modifiée: Utilise x-init pour masquer après 3 secondes --}} x-init="setTimeout(() => { show = false }, 3000)"
            class="fixed top-5 right-5 p-4 rounded-md shadow-lg z-50
                        {{ $type === 'success' ? 'bg-green-500 text-white' : '' }}
                        {{ $type === 'error' ? 'bg-red-500 text-white' : '' }}
                        {{ $type === 'warning' ? 'bg-yellow-500 text-gray-800' : '' }}" role="alert">
            <div class="flex items-center">
                <p>{{ $message }}</p>
                <button @click="show = false"
                    class="ml-auto -mx-1.5 -my-1.5 bg-transparent text-white rounded-lg focus:ring-2 focus:ring-gray-400 p-1.5 hover:bg-gray-200 hover:text-gray-900 inline-flex items-center justify-center h-8 w-8 dark:hover:bg-gray-700 dark:hover:text-white"
                    aria-label="Close">
                    <span class="sr-only">Close</span>
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                </button>
            </div>
        </div>
    @endif
</div>
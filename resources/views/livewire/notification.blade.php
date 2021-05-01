<div class="fixed inset-0 flex items-end justify-center px-4 py-6 pointer-events-none sm:p-6 sm:items-start sm:justify-end | z-50">
    <div
        x-init="setTimeout(() => open = true, 50)"
        x-data="{ open: false }"
        x-show="open"
        x-transition:enter="transform ease-out duration-300 transition"
        x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
        x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
        x-transition:leave="transition ease-in duration-100"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="max-w-sm w-full bg-white shadow-lg rounded-lg pointer-events-auto"
    >
        <div class="rounded-lg ring overflow-hidden">
            <div class="p-4">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        @if ($type === 'info')
                            <i class="fas fa-exclamation-circle text-blue-600"></i>
                        @elseif ($type === 'error')
                            <i class="far fa-times-circle text-red-800"></i>
                        @else
                            <i class="far fa-check-circle text-green-800"></i>
                        @endif
                    </div>
                    <div class="ml-3 w-0 flex-1 pt-0.5">
                        <p class="text-sm leading-5 font-medium text-gray-900">{{ $title }}</p>
                        @if ($description)
                            <p class="mt-1 text-sm leading-5 text-gray-600">{{ $description }}</p>
                        @endif
                    </div>
                    <div class="ml-4 flex-shrink-0 flex">
                        <button x-on:click="open = false; $wire.dismiss()" class="inline-flex text-gray-400 focus:outline-none focus:text-gray-600 hover:text-gray-600 transition ease-in-out duration-150">
                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

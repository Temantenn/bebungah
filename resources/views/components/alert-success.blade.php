@props(['message'])

<div x-data="{ show: true }" 
     x-init="setTimeout(() => show = false, 4000)"
     x-show="show" 
     x-transition:enter="transition ease-out duration-300" 
     x-transition:enter-start="opacity-0 transform translate-x-8" 
     x-transition:enter-end="opacity-100 transform translate-x-0" 
     x-transition:leave="transition ease-in duration-200" 
     x-transition:leave-start="opacity-100 transform translate-x-0" 
     x-transition:leave-end="opacity-0 transform translate-x-8" 
     class="fixed top-6 right-6 z-[9999] flex w-full max-w-sm overflow-hidden bg-white rounded-xl shadow-2xl dark:bg-gray-800 border-l-4 border-emerald-500" 
     style="display: none;">
    <div class="flex items-center justify-center w-12 bg-emerald-500/10 text-emerald-500">
        <svg class="w-6 h-6 fill-current" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg">
            <path d="M20 3.33331C10.8 3.33331 3.33337 10.8 3.33337 20C3.33337 29.2 10.8 36.6666 20 36.6666C29.2 36.6666 36.6667 29.2 36.6667 20C36.6667 10.8 29.2 3.33331 20 3.33331ZM16.6667 28.3333L8.33337 20L10.6834 17.65L16.6667 23.6166L29.3167 10.9666L31.6667 13.3333L16.6667 28.3333Z" />
        </svg>
    </div>

    <div class="px-4 py-3 -mx-3 flex-1">
        <div class="mx-3 flex justify-between items-start gap-4">
            <div>
                <span class="font-bold text-emerald-600 dark:text-emerald-400">Berhasil!</span>
                <p class="text-sm text-gray-600 dark:text-gray-300 mt-0.5 leading-tight">{{ $message }}</p>
            </div>
            <button @click="show = false" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 focus:outline-none transition-colors -mr-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
    </div>
</div>

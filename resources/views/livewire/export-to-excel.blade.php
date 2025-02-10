<div>
<button wire:click="export"
            class="bg-gradient-to-r from-green-600 to-green-500 text-white p-3 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 ease-in-out transform hover:scale-105 focus:outline-none focus:ring-4 focus:ring-blue-500 focus:ring-opacity-70 active:scale-95">
            <!-- Ícone de exportação do Heroicons -->
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
            </svg>
        </button>

    @if (session()->has('error'))
        <div class="mt-4 p-4 bg-red-100 text-red-700 rounded-lg border border-red-200">
            {{ session('error') }}
        </div>
    @endif
</div>

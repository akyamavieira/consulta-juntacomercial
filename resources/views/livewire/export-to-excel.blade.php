<div class="relative">
    <button wire:click="export" wire:loading.attr="disabled" class="bg-transparent hover:bg-gray-200 p-3 rounded-full relative group">
        <!-- Ícone de exportação do Heroicons -->
        <img src="{{ asset('img/file-export.svg') }}" alt="Pesquisa" class="h-5 w-5" />
        <!-- Tooltip -->
        <span class="absolute top-full left-1/2 transform -translate-x-1/2 mt-2 w-max px-2 py-1 bg-gray-700 text-white text-xs rounded opacity-0 group-hover:opacity-100 transition-opacity">
            Exporte para Excel
        </span>
    </button>

    <!-- Spinner de carregamento -->
    <div wire:loading class="absolute flex justify-center items-center">
        <div class="w-8 h-8 border-4 border-gray-300 border-t-blue-500 border-t-4 rounded-full animate-spin"></div>
    </div>

    @if (session()->has('error'))
        <div class="mt-4 p-4 bg-red-100 text-red-700 rounded-lg border border-red-200">
            {{ session('error') }}
        </div>
    @endif
</div>
<div>
    <div class="bg-white p-4 rounded shadow-md">
        <h3 class="text-xl font-semibold mb-4">PORTE</h3>
        <div>
            @foreach(['ME', 'EPP', 'Outros'] as $filter)
                <label class="flex items-center mb-2">
                    <input type="checkbox" wire:model.live="filter{{ $filter }}" class="mr-2">
                    {{ $filter }}
                </label>
            @endforeach
        </div>
    </div>

    <div class="bg-white p-4 rounded shadow-md">
        <h3 class="text-xl font-semibold mb-4">BAIRRO</h3>
        <input type="text" wire:model.live="search" placeholder="Pesquisar bairros..."
            class="form-input mt-1 block w-full">
        @if(!empty($bairrosDisponiveis))
            <select multiple wire:model.live="filterBairros" class="form-select mt-1 block w-full h-40">
                @foreach($bairrosDisponiveis as $bairro)
                    <option value="{{ $bairro }}">{{ $bairro }}</option>
                @endforeach
            </select>
            <p class="text-sm text-gray-600 mt-2">
                Segure a tecla <kbd>Ctrl</kbd> (ou <kbd>Cmd</kbd> no Mac) para selecionar múltiplos bairros.
            </p>
        @endif
        <button type="button" wire:click="clearAllFilters" class="mt-2 bg-red-500 text-white px-4 py-2 rounded">
            Limpar Todos os Filtros
        </button>
    </div>
</div>
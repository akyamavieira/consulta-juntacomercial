<div class="text-xs flex flex-col space-y-4">
    <button type="button" wire:click="clearAllFilters">
        Limpar Filtros
    </button>
    <div class="bg-white p-4 rounded shadow-md">
        <h3 class="text-xl font-semibold mb-4">SITUAÇÃO CADASTRAL</h3>
        <input type="text" wire:model.live="searchSituacaoCadastral" placeholder="Pesquisar situação cadastral..."
            class="form-input mt-1 block w-full">
        @if(!empty($situacoesCadastraisDisponiveis))
            <select multiple wire:model.live="filterSituacaoCadastral" class="form-select mt-1 block w-full h-40">
                @foreach($situacoesCadastraisDisponiveis as $situacao)
                    <option value="{{ $situacao }}">{{ $situacao }}</option>
                @endforeach
            </select>
            <p class="text-sm text-gray-600 mt-2">
                Segure a tecla <kbd>Ctrl</kbd> (ou <kbd>Cmd</kbd> no Mac) para selecionar múltiplos itens.
            </p>
        @endif
    </div>
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
        <input type="text" wire:model.live="searchBairro" placeholder="Pesquisar bairros..."
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
    </div>

    <div class="bg-white p-4 rounded shadow-md">
        <h3 class="text-xl font-semibold mb-4">MUNICÍPIO</h3>
        <input type="text" wire:model.live="searchMunicipio" placeholder="Pesquisar municípios..."
            class="form-input mt-1 block w-full">
        @if(!empty($municipiosDisponiveis))
            <select multiple wire:model.live="filterMunicipios" class="form-select mt-1 block w-full h-40">
                @foreach($municipiosDisponiveis as $municipio)
                    <option value="{{ $municipio }}">{{ $municipio }}</option>
                @endforeach
            </select>
            <p class="text-sm text-gray-600 mt-2">
                Segure a tecla <kbd>Ctrl</kbd> (ou <kbd>Cmd</kbd> no Mac) para selecionar múltiplos municípios.
            </p>
        @endif
    </div>

    <div class="bg-white p-4 rounded shadow-md">
        <h3 class="text-xl font-semibold mb-4">SETOR</h3>
        <input type="text" wire:model.live="searchSetor" placeholder="Pesquisar setores..."
            class="form-input mt-1 block w-full">
        @if(!empty($setoresDisponiveis))
            <select multiple wire:model.live="filterSetores" class="form-select mt-1 block w-full h-40">
                @foreach($setoresDisponiveis as $setor)
                    <option value="{{ $setor }}">{{ $setor }}</option>
                @endforeach
            </select>
            <p class="text-sm text-gray-600 mt-2">
                Segure a tecla <kbd>Ctrl</kbd> (ou <kbd>Cmd</kbd> no Mac) para selecionar múltiplos setores.
            </p>
        @endif
    </div>
</div>
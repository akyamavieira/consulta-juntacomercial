<div class="text-xs flex flex-col space-y-4">
    <button type="button" wire:click="clearAllFilters">
        Limpar Filtros
    </button>
    <!-- Filtro de Situação Cadastral -->
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

    <!-- Filtro de Porte -->
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
    <!-- Filtro de Capital Social -->
    <div class="bg-white p-4 rounded shadow-md">
        <h3 class="text-xl font-semibold mb-4">CAPITAL SOCIAL</h3>
        <label class="flex items-center mb-2">
            <input type="checkbox" wire:model.live="filterCapitalSocial" value="ate_100mil" class="mr-2"> Até 100 mil
        </label>
        <label class="flex items-center mb-2">
            <input type="checkbox" wire:model.live="filterCapitalSocial" value="ate_1milhao" class="mr-2"> Até 1 milhão
        </label>
        <label class="flex items-center mb-2">
            <input type="checkbox" wire:model.live="filterCapitalSocial" value="ate_100milhoes" class="mr-2"> Até 100 milhões
        </label>
        <label class="flex items-center mb-2">
            <input type="checkbox" wire:model.live="filterCapitalSocial" value="ate_1bilhao" class="mr-2"> Até 1 bilhão
        </label>
        <label class="flex items-center mb-2">
            <input type="checkbox" wire:model.live="filterCapitalSocial" value="acima_de_1bilhao" class="mr-2"> Acima de 1 bilhão
        </label>
    </div>
    <!-- Filtro de Bairro -->
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

    <!-- Filtro de Município -->
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

    <!-- Filtro de Setor -->
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
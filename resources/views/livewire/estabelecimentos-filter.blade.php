<div>
    <div class="bg-white p-4 rounded shadow-md">
        <h3 class="text-xl font-semibold mb-4">PORTE</h3>
        <div>
            <label class="flex items-center mb-2">
                <input type="checkbox" wire:model.live="filterME" class="mr-2">
                ME
            </label>
            <label class="flex items-center mb-2">
                <input type="checkbox" wire:model.live="filterEPP" class="mr-2">
                EPP
            </label>
            <label class="flex items-center mb-2">
                <input type="checkbox" wire:model.live="filterOutros" class="mr-2">
                Outros
            </label>
        </div>
    </div>
    <div class="bg-white p-4 rounded shadow-md">
        <h3 class="text-xl font-semibold mb-4">BAIRRO</h3>
        <select multiple wire:model.live="filterBairros" class="form-select mt-1 block w-full h-80">
            @foreach($bairrosDisponiveis as $bairro)
                <option value="{{ $bairro }}">{{ $bairro }}</option>
            @endforeach
        </select>
        <p class="text-sm text-gray-600 mt-2">
            Segure a tecla <kbd>Ctrl</kbd> (ou <kbd>Cmd</kbd> no Mac) para selecionar múltiplos bairros.
        </p>
    </div>
</div>
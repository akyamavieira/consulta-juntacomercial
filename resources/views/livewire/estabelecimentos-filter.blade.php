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
</div>
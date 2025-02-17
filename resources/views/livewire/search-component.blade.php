<div class="border border-1 rounded-full flex items-center pl-2">
    <input type="search" id="default-search" placeholder="Realize sua pesquisa" required wire:model.live.debounce.250ms="query" class="flex-grow p-2 rounded-full focus:outline-none focus:ring-0 focus:border-transparent focus:bg-transparent" />
    <div class="p-2 mr-1.5">
        <img src="{{ asset('img/search-icon.svg') }}" alt="Pesquisa" class="h-5 w-5" />
    </div>
</div>
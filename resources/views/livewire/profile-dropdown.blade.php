<div>
    <div x-data="{ open: @entangle('dropdownVisible') }" @click.away="open = false" class="relative">
        <!-- Avatar / Trigger -->
        <div id="avatar-toggle" @click="open = !open">
            <img src="{{ asset('img/avatar.svg') }}" alt="Avatar" class="h-10 w-10 rounded-full">
        </div>

        <!-- Dropdown -->
        <div x-show="open" x-transition
            class="fixed left-0 top-20 py-4 px-6 bg-white shadow-lg rounded-lg border border-[#D1D5DB] z-10 space-y-1"
            style="display: none;">
            @livewire('logout')
        </div>
    </div>
</div>

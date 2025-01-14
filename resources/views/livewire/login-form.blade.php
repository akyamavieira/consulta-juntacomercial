<form wire:submit.prevent="login">
    @csrf
   <!-- SVG rodeado por um círculo (link) -->
    <a class="flex justify-center cursor-pointer">
        <div class="flex items-center justify-center size-12 p-1 bg-gray-600 rounded-full">
            <img src="{{ asset('img/logo-sebrae-white.svg') }}" alt="">
        </div>
    </a>
</form>

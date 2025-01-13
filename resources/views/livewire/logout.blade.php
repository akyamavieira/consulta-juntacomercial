<!-- No arquivo da view -->
<a href="#" 
   wire:click.prevent="logout" 
   class="block text-lg hover:bg-gray-200 rounded-full p-2 transition duration-300 font-bold text-right">
    <span class="inline-block h-5 w-5">
        <img class="h-full w-full" src="{{ asset('img/exit.svg') }}" alt="exit">
    </span>
    Logout
</a>

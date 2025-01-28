<div x-data="{ isVisible: @entangle('isVisible') }">
    <div x-show="isVisible" class="fixed inset-0 flex items-center justify-center z-50">
        <div class="bg-gray-800 text-white p-4 rounded shadow-lg max-w-sm w-full">
            <p>{{ $message }}</p>
            <button @click="isVisible = false" class="mt-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Fechar
            </button>
        </div>
    </div>
</div>
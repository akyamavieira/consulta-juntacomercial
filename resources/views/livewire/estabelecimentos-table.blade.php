<div class="flex flex-col items-center justify-center">
    <table class="border border-gray-200 rounded-3xl overflow-visible relative">
        <thead>
            <tr class="bg-gray-100 text-left">
                <th class="px-3 py-3 text-sm font-medium text-gray-600">Empresa</th>
                <th class="px-3 py-3 text-sm font-medium text-gray-600">Responsável</th>
                <th class="px-3 py-3 text-sm font-medium text-gray-600 max-w-14">Status</th>
                <th class="px-3 py-3 text-sm font-medium text-gray-600 max-w-14">Ação</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($estabelecimentos as $index => $estabelecimento)
                <tr class="border-t @if ($estabelecimento->updated_at->diffInHours(now()) <= 1) bg-green-50 @endif">
                    <!-- Nome da Empresa -->
                    <td class="px-3 py-3 text-sm text-gray-800 max-w-36 md:max-w-full flex items-center">
                        {{ $estabelecimento->nomeEmpresarial }}
                        @if ($estabelecimento->updated_at->diffInHours(now()) <= 1)
                            <span class="ml-2 text-xs text-white bg-green-500 rounded-full px-2 py-1">
                                Novo
                            </span>
                        @endif
                    </td>
                    
                    <!-- Nome do Responsável -->
                    <td class="px-3 py-3 text-sm text-gray-800 max-w-28 md:max-w-full">
                        {{ $estabelecimento->nomeResponsavel }}
                    </td>
                    
                    <!-- Status -->
                    <td class="px-3 py-3 text-sm text-gray-800">
                        {{ $estabelecimento->codEvento }}
                    </td>
                    
                    <!-- Ação -->
                    <td class="px-3 py-3">
                        <button 
                            wire:click="mostrarDetalhes('{{ $estabelecimento->identificador }}')"
                            class="text-blue-500 hover:text-blue-700">
                            <img src="{{ asset('img/ver-detalhes.svg') }}" alt="Ver Detalhes"
                                class="h-5 w-5 text-blue-500" />
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="px-3 py-3 text-sm text-center text-gray-500">
                        Nenhum registro encontrado.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
    
    <!-- Paginação -->
    <div class="mt-4">
        {{ $estabelecimentos->links() }}
    </div>
</div>
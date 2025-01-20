<div class="flex flex-col items-center justify-center">
    <table class="border border-gray-200 rounded-3xl overflow-hidden">
        <thead>
            <tr class="bg-gray-100 text-left">
                <th class="px-3 py-3 text-sm font-medium text-gray-600">Empresa</th>
                <th class="px-3 py-3 text-sm font-medium text-gray-600">Responsável</th>
                <th class="px-3 py-3 text-sm font-medium text-gray-600 max-w-14">Status</th>
                <th class="px-3 py-3 text-sm font-medium text-gray-600 max-w-14">Ação</th>
            </tr>
        </thead>
        <tbody>
            @foreach($estabelecimentos as $estabelecimento)
                <tr class="border-t">
                    <td class="px-3 py-3 text-sm text-gray-800 max-w-36 md:max-w-full">
                        {{ $estabelecimento->nomeEmpresarial }}
                    </td>
                    <td class="px-3 py-3 text-sm text-gray-800 max-w-28 md:max-w-full">
                        {{ $estabelecimento->nomeResponsavel }}
                    </td>
                    <td class="px-3 py-3 text-sm text-gray-800 relative">
                        <span
                            wire:mouseover="mostrarTooltip('{{ $estabelecimento->identificador }}','{{ $estabelecimento->codEvento }}')"
                            wire:mouseout="esconderTooltip" class="cursor-pointer">
                            {{ $estabelecimento->codEvento }}
                        </span>
                        @if($tooltipIdentificador === $estabelecimento->identificador)
                            <div class="absolute z-10 mt-1 p-2 bg-gray-800 text-white text-sm rounded shadow-lg">
                                {{ $tooltipMessage }}
                            </div>
                        @endif
                    </td>
                    <td class="px-3 py-3">
                        <button wire:click="mostrarDetalhes('{{ $estabelecimento->identificador }}')"
                            class="text-blue-500 hover:text-blue-700"><img src="{{ asset('img/ver-detalhes.svg') }}"
                                alt="Ver Detalhes" class="h-5 w-5 text-blue-500" />
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <!-- Pagination Links -->
    <div class="mt-4">
        {{ $estabelecimentos->links() }}
    </div>

</div>
<div>
    <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow">
        <thead>
            <tr class="bg-gray-100 text-left">
                <th class="px-6 py-3 text-sm font-medium text-gray-600">Nome Empresarial</th>
                <th class="px-6 py-3 text-sm font-medium text-gray-600">Ação</th>
            </tr>
        </thead>
        <tbody>
            @foreach($estabelecimentos['registrosRedesim']['registroRedesim'] as $estabelecimento)
                <tr class="border-t">
                    <td class="px-6 py-4 text-sm text-gray-800">
                        {{ $estabelecimento['dadosRedesim']['nomeEmpresarial'] }}
                    </td>
                    <td class="px-6 py-4">
                        <button wire:click="mostrarDetalhes('{{ $estabelecimento['dadosRedesim']['nomeEmpresarial'] }}')"
                            class="text-blue-500 hover:text-blue-700">Ver Detalhes</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Modal -->
    @if($mostrarModal)
    <div class="fixed inset-0 flex items-center justify-center z-50 bg-gray-800 bg-opacity-50">
        <div class="bg-white p-6 rounded-lg shadow-lg w-1/3">
            <h2 class="text-xl font-bold mb-4">Detalhes do Estabelecimento</h2>

            <ul class="space-y-2">
                <li><strong>CNPJ:</strong> {{ substr($detalhesEstabelecimento['cnpj'], 0, 2) . '.' . substr($detalhesEstabelecimento['cnpj'], 2, 3) . '.' . substr($detalhesEstabelecimento['cnpj'], 5, 3) . '/' . substr($detalhesEstabelecimento['cnpj'], 8, 4) . '-' . substr($detalhesEstabelecimento['cnpj'], 12, 2) }}</li>
                <li><strong>Nome Fantasia:</strong> {{ $detalhesEstabelecimento['nomeFantasia'] ?? 'Não Possui' }}</li>
                <li><strong>Data Abertura Estabelecimento:</strong> {{ \Carbon\Carbon::parse($detalhesEstabelecimento['dataAberturaEstabelecimento'])->format('d/m/Y') }}</li>
                <li><strong>Porte:</strong> {{ $detalhesEstabelecimento['porte'] }}</li>
                <li><strong>Capital Social:</strong> R$ {{ number_format($detalhesEstabelecimento['capitalSocial'], 2, ',', '.') }}</li>
                <!-- Adicione os outros detalhes conforme necessário -->
            </ul>

            <button wire:click="fecharModal" class="mt-4 px-4 py-2 bg-red-500 text-white rounded">Fechar</button>
        </div>
    </div>
    @endif
</div>

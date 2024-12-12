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
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

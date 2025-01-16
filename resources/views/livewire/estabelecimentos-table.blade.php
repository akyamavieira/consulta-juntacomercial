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
                        {{$estabelecimento['dadosRedesim']['nomeEmpresarial'] }}
                    </td>
                    <td class="px-3 py-3 text-sm text-gray-800 max-w-28 md:max-w-full">
                        {{ $estabelecimento['dadosRedesim']['responsavelPeranteCnpj']['nomeResponsavel'] }}
                    </td>
                    <td class="px-3 py-3 text-sm text-gray-800 relative">
                        <span
                            wire:mouseover="mostrarTooltip('{{ $estabelecimento['identificador'] }}','{{ $estabelecimento["eventos"]["evento"]["0"]["codEvento"] }}')"
                            wire:mouseout="esconderTooltip" class="cursor-pointer">
                            {{ $estabelecimento["eventos"]["evento"]["0"]["codEvento"] }}
                        </span>
                        @if($tooltipIdentificador === $estabelecimento['identificador'])
                            <div class="absolute z-10 mt-1 p-2 bg-gray-800 text-white text-sm rounded shadow-lg">
                                {{ $tooltipMessage }}
                            </div>
                        @endif
                    </td>
                    <td class="px-3 py-3">
                        <button wire:click="mostrarDetalhes('{{ $estabelecimento['identificador'] }}')"
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
    <!-- Modal -->
    @if($mostrarModal)
        <div class="fixed inset-0 flex items-center justify-center z-50 bg-gray-800 bg-opacity-50">
            <div class="bg-white p-6 rounded-lg shadow-lg w-full sm:w-2/3 md:w-1/2 lg:w-1/3 max-h-[90vh] overflow-y-auto">
                <h2 class="text-xl font-bold mb-4">Detalhes do Estabelecimento</h2>

                <ul class="space-y-2">
                    <li><strong>CNPJ:</strong> {{ formatCNPJ($detalhesEstabelecimento['cnpj']) }}</li>
                    <li><strong>Nome Empresarial:</strong> {{ $detalhesEstabelecimento['nomeEmpresarial'] }}</li>
                    <li><strong>Nome Fantasia:</strong> {{ $detalhesEstabelecimento['nomeFantasia'] }}</li>
                    <li><strong>Data Início Atividade:</strong>
                        {{ formatData($detalhesEstabelecimento['dataInicioAtividade']) }}</li>
                    <li><strong>Número do Processo Órgão Registro:</strong>
                        {{ $detalhesEstabelecimento['nuProcessoOrgaoRegistro'] }}</li>
                    <li><strong>Situação Cadastral RFB (Descrição):</strong>
                        {{ $detalhesEstabelecimento['situacaoCadastralRFB_descricao'] }}</li>
                    <li><strong>Opção Simples Nacional:</strong> {{ $detalhesEstabelecimento['opcaoSimplesNacional'] }}</li>
                    <li><strong>Porte:</strong> {{ $detalhesEstabelecimento['porte'] }}</li>
                    <li><strong>Número Inscrição Municipal:</strong> {{ $detalhesEstabelecimento['nuInscricaoMunicipal'] }}
                    </li>
                    <li><strong>Capital Social:</strong> {{ formatDinheiro($detalhesEstabelecimento['capitalSocial']) }}
                    </li>
                    <li><strong>Possui Estabelecimento:</strong> {{ $detalhesEstabelecimento['possuiEstabelecimento'] }}
                    </li>
                    <li><strong>Última Viabilidade Vinculada:</strong>
                        {{ $detalhesEstabelecimento['ultimaViabilidadeVinculada'] }}</li>
                    <li><strong>Última Viabilidade Análise Endereço:</strong>
                        {{ $detalhesEstabelecimento['ultimaViabilidadeAnaliseEndereco'] }}</li>
                    <li><strong>Data Última Análise Endereço:</strong>
                        {{ formatData($detalhesEstabelecimento['dataUltimaAnaliseEndereco']) }}</li>
                    <li><strong>Último Coletor Estadual Web Vinculado:</strong>
                        {{ $detalhesEstabelecimento['ultimoColetorEstadualWebVinculado'] }}</li>
                    <li>
                    <li>
                        <p><strong class="text-sm font-semibold">Endereço Completo:</strong></p>
                        <p>
                            <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($detalhesEstabelecimento['endereco_logradouro'] . ' ' . $detalhesEstabelecimento['endereco_numLogradouro'] . ' ' . ($detalhesEstabelecimento['endereco_complemento'] ? ' - ' . $detalhesEstabelecimento['endereco_complemento'] : '') . ', ' . $detalhesEstabelecimento['endereco_bairro'] . ', ' . $detalhesEstabelecimento['endereco_codMunicipio'] . ', ' . $detalhesEstabelecimento['endereco_uf'] . ', ' . $detalhesEstabelecimento['endereco_cep']) }}"
                                target="_blank" rel="noopener noreferrer" class="text-blue-500 underline">
                                {{ $detalhesEstabelecimento['endereco_logradouro'] }}
                                {{ $detalhesEstabelecimento['endereco_numLogradouro'] }}
                                {{ $detalhesEstabelecimento['endereco_complemento'] ? ' - ' . $detalhesEstabelecimento['endereco_complemento'] : '' }},
                                {{ $detalhesEstabelecimento['endereco_bairro'] }} -
                                {{ $detalhesEstabelecimento['endereco_codMunicipio'] }} /
                                {{ $detalhesEstabelecimento['endereco_uf'] }} -
                                {{ $detalhesEstabelecimento['endereco_cep'] }}
                            </a>
                        </p>
                    </li>
                    <li>
                        <p><strong class="text-sm font-semibold">Contato:</strong></p>
                        <p>
                            <span class="font-medium">Telefone:</span>
                            <a href="tel:{{ $detalhesEstabelecimento['contato_ddd'] . $detalhesEstabelecimento['contato_telefone1'] }}"
                                class="text-blue-500 underline">
                                {{ formatPhone($detalhesEstabelecimento['contato_telefone1'], $detalhesEstabelecimento['contato_ddd']) }}
                            </a> |
                            <span class="font-medium">Email:</span>
                            <a href="mailto:{{ $detalhesEstabelecimento['contato_email'] }}"
                                class="text-blue-500 underline">
                                {{ $detalhesEstabelecimento['contato_email'] }}
                            </a>
                        </p>
                    </li>
                </ul>

                <button wire:click="fecharModal" class="mt-4 px-4 py-2 bg-red-500 text-white rounded">Fechar</button>
            </div>
        </div>
    @endif
</div>
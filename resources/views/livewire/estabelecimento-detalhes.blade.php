<div>
    @if($mostrarModal)
        <div class="fixed inset-0 flex items-center justify-center z-50 bg-gray-800 bg-opacity-50">
            <div class="bg-white p-6 rounded-lg shadow-lg w-full sm:w-2/3 md:w-1/2 lg:w-1/3 max-h-[90vh] overflow-y-auto">
                <h2 class="text-xl font-bold mb-4">Detalhes do Estabelecimento</h2>

                <ul class="space-y-2">
                    <li><strong>CNPJ:</strong> {{ formatCNPJ($detalhesEstabelecimento->cnpj) }}</li>
                    <li><strong>Nome Empresarial:</strong> {{ $detalhesEstabelecimento->nomeEmpresarial }}</li>
                    <li><strong>Nome Fantasia:</strong> {{ $detalhesEstabelecimento->nomeFantasia }}</li>
                    <li><strong>Data Abertura Estabelecimento:</strong> {{ formatData($detalhesEstabelecimento->dataAberturaEstabelecimento) }}</li>
                    <li><strong>Data Abertura Empresa:</strong> {{ formatData($detalhesEstabelecimento->dataAberturaEmpresa) }}</li>
                    <li><strong>Data Início Atividade:</strong> {{ formatData($detalhesEstabelecimento->dataInicioAtividade) }}</li>
                    <li><strong>Número do Processo Órgão Registro:</strong> {{ $detalhesEstabelecimento->nuProcessoOrgaoRegistro }}</li>
                    <li><strong>Situação Cadastral RFB (Descrição):</strong> {{ $detalhesEstabelecimento->situacaoCadastralRFB_descricao }}</li>
                    <li><strong>Opção Simples Nacional:</strong> {{ $detalhesEstabelecimento->opcaoSimplesNacional }}</li>
                    <li><strong>Porte:</strong> {{ $detalhesEstabelecimento->porte }}</li>
                    <li><strong>Número Inscrição Municipal:</strong> {{ $detalhesEstabelecimento->nuInscricaoMunicipal }}</li>
                    <li><strong>Capital Social:</strong> {{ formatDinheiro($detalhesEstabelecimento->capitalSocial) }}</li>
                    <li><strong>Possui Estabelecimento:</strong> {{ $detalhesEstabelecimento->possuiEstabelecimento }}</li>
                    <li><strong>Última Viabilidade Vinculada:</strong> {{ $detalhesEstabelecimento->ultimaViabilidadeVinculada }}</li>
                    <li><strong>Última Viabilidade Análise Endereço:</strong> {{ $detalhesEstabelecimento->ultimaViabilidadeAnaliseEndereco }}</li>
                    <li><strong>Data Última Análise Endereço:</strong> {{ formatData($detalhesEstabelecimento->dataUltimaAnaliseEndereco) }}</li>
                    <li><strong>Último Coletor Estadual Web Vinculado:</strong> {{ $detalhesEstabelecimento->ultimoColetorEstadualWebVinculado }}</li>
                    <li>
                        <p><strong class="text-sm font-semibold">Endereço Completo:</strong></p>
                        <p>
                            <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($detalhesEstabelecimento->endereco_logradouro . ' ' . $detalhesEstabelecimento->endereco_numLogradouro . ' ' . ($detalhesEstabelecimento->endereco_complemento ? ' - ' . $detalhesEstabelecimento->endereco_complemento : '') . ', ' . $detalhesEstabelecimento->endereco_bairro . ', ' . $detalhesEstabelecimento->endereco_codMunicipio . ', ' . $detalhesEstabelecimento->endereco_uf . ', ' . $detalhesEstabelecimento->endereco_cep) }}"
                                target="_blank" rel="noopener noreferrer" class="text-blue-500 underline">
                                {{ $detalhesEstabelecimento->endereco_logradouro }}
                                {{ $detalhesEstabelecimento->endereco_numLogradouro }}
                                {{ $detalhesEstabelecimento->endereco_complemento ? ' - ' . $detalhesEstabelecimento->endereco_complemento : '' }},
                                {{ $detalhesEstabelecimento->endereco_bairro }} -
                                {{ $detalhesEstabelecimento->endereco_codMunicipio }} /
                                {{ $detalhesEstabelecimento->endereco_uf }} -
                                {{ $detalhesEstabelecimento->endereco_cep }}
                            </a>
                        </p>
                    </li>
                </ul>

                <button wire:click="fecharModal" class="mt-4 px-4 py-2 bg-red-500 text-white rounded">Fechar</button>
            </div>
        </div>
    @endif
</div>
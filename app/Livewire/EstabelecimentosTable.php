<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\EstabelecimentoService;
use App\DTO\DetalhesEstabelecimentoDTO;
use Carbon\Carbon;

class EstabelecimentosTable extends Component
{
    public $estabelecimentos;
    public $detalhesEstabelecimento;
    public $mostrarModal = false;
    protected $estabelecimentoService;

    public function boot(EstabelecimentoService $estabelecimentoService)
    {
        $this->estabelecimentoService = $estabelecimentoService;
    }

    public function mount()
    {
        $this->estabelecimentos = $this->estabelecimentoService->getEstabelecimentos();
    }

    public function mostrarDetalhes($cnpj)
    {
        // Busca os detalhes do estabelecimento pelo CNPJ
        $dados = $this->estabelecimentoService->getEstabelecimentoPorCnpj($cnpj)['registrosRedesim']['registroRedesim'][0]['dadosRedesim'];
        $this->detalhesEstabelecimento = [
            'cnpj' => $dados['cnpj'] ?? 'Campo não informado',
            'nomeEmpresarial' => $dados['nomeEmpresarial'] ?? 'Campo não informado',
            'nomeFantasia' => $dados['nomeFantasia'] ?? 'Campo não informado',
            'dataInicioAtividade' => $dados['dataInicioAtividade'] ?? 'Campo não informado',
            'nuProcessoOrgaoRegistro' => $dados['nuProcessoOrgaoRegistro'] ?? 'Campo não informado',
            'situacaoCadastralRFB_descricao' => $dados['situacaoCadastralRFB']['descricao'] ?? 'Campo não informado',
            'opcaoSimplesNacional' => $dados['opcaoSimplesNacional'] ?? 'Campo não informado',
            'porte' => $dados['porte'] ?? 'Campo não informado',
            'nuInscricaoMunicipal' => $dados['nuInscricaoMunicipal'] ?? 'Campo não informado',
            'capitalSocial' => $dados['capitalSocial'] ?? 'Campo não informado',
            'possuiEstabelecimento' => $dados['possuiEstabelecimento'] ?? 'Campo não informado',
            'ultimaViabilidadeVinculada' => $dados['ultimaViabilidadeVinculada'] ?? 'Campo não informado',
            'ultimaViabilidadeAnaliseEndereco' => $dados['ultimaViabilidadeAnaliseEndereco'] ?? 'Campo não informado',
            'dataUltimaAnaliseEndereco' => $dados['dataUltimaAnaliseEndereco'] ?? 'Campo não informado',
            'ultimoColetorEstadualWebVinculado' => $dados['ultimoColetorEstadualWebVinculado'] ?? 'Campo não informado',
            'endereco_cep' => $dados['endereco']['cep'] ?? 'Campo não informado',
            'endereco_logradouro' => $dados['endereco']['logradouro'] ?? 'Campo não informado',
            'endereco_codTipoLogradouro' => $dados['endereco']['codTipoLogradouro'] ?? 'Campo não informado',
            'endereco_numLogradouro' => $dados['endereco']['numLogradouro'] ?? 'Campo não informado',
            'endereco_complemento' => $dados['endereco']['complemento'] ?? 'Campo não informado',
            'endereco_bairro' => $dados['endereco']['bairro'] ?? 'Campo não informado',
            'endereco_codMunicipio' => $dados['endereco']['codMunicipio'] ?? 'Campo não informado',
            'endereco_uf' => $dados['endereco']['uf'] ?? 'Campo não informado',
            'contato_ddd' => $dados['contato']['dddTelefone1'] ?? 'Campo não informado',
            'contato_telefone1' => $dados['contato']['telefone1'] ?? 'Campo não informado',
            'contato_email' => $dados['contato']['correioEletronico'] ?? 'Campo não informado'
        ];

        $this->mostrarModal = true;
    }
    public function fecharModal()
    {
        $this->mostrarModal = false; // Fecha o modal
    }

    public function render()
    {
        return view('livewire.estabelecimentos-table');
    }
}

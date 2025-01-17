<?php

namespace App\Livewire;

use App\Services\EstabelecimentoService;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Estabelecimento;

class EstabelecimentosTable extends Component
{
    use WithPagination;

    public $detalhesEstabelecimento;
    public $mostrarModal = false;
    public $tooltipIdentificador = null;
    public $tooltipMessage = null;
    protected $paginationTheme = 'tailwind';

    protected $listeners = ['refreshTable' => '$refresh'];

    private $estabelecimentoService;

    public function boot(EstabelecimentoService $estabelecimentoService)
    {
        \Log::info('Boot do componente EstabelecimentosTable iniciado.');
        $this->estabelecimentoService = $estabelecimentoService;
    }

    public function getEstabelecimentosProperty()
    {
        $allItems = $this->estabelecimentoService->getEstabelecimentos();

        // Converta a coleção para um modelo Eloquent
        $eloquentCollection = Estabelecimento::hydrate($allItems->toArray());

        // Retorna a paginação dos registros
        return $eloquentCollection->paginate(10); // Use 10 itens por página
    }

    public function mostrarTooltip($identificador, $codEvento)
    {
        //dd($codEvento);
        $this->tooltipIdentificador = $identificador;
        // Mapeamento de códigos de evento para mensagens
        $eventos = [
            '001' => 'ENTRADA DE SÓCIO/ADMINISTRADOR',
            '002' => 'ALTERAÇÃO DA DATA DE INCLUSÃO',
            '003' => 'ALTERAÇÃO DE DADOS DO SÓCIO/ADMINISTRADOR',
            '005' => 'SAÍDA DE SÓCIO/ADMINISTRADOR',
            '006' => 'ALTERAÇÃO DA DATA DE EXCLUSÃO',
            '007' => 'ALTERAÇÃO DA DATA DE INCLUSÃO DE SÓCIO/ADMINISTRADOR EXCLUÍDO',
            '008' => 'EXCLUSÃO DE REGISTRO DE SÓCIO/ADMINISTRADOR',
            '010' => 'INFORMAÇÃO DE SÓCIO PARA CONFERÊNCIA COM A BASE CNPJ',
            '011' => 'ENTRADA DO BENEFICIÁRIO FINAL',
            '012' => 'ALTERAÇÃO DE DADOS DO BENEFICIÁRIO FINAL',
            '013' => 'SAÍDA DO BENEFICIÁRIO FINAL',
            '052' => 'REATIVAÇÃO - ARTIGO 60 LEI 8.934/94',
            '101' => 'INSCRIÇÃO DE PRIMEIRO ESTABELECIMENTO',
            '102' => 'INSCRIÇÃO DOS DEMAIS ESTABELECIMENTOS',
            '103' => 'INSCRIÇÃO DE ESTABELECIMENTO FILIAL DE EMPRESA BRASILEIRA NO EXTERIOR',
            '105' => 'INSCRIÇÃO DE EMBAIXADA/CONSULADO/REPRESENTAÇÕES DO GOVERNO NO EXTERIOR',
            '106' => 'INSCRIÇÃO DE MISSÕES DIPL./REPART. CONSUL./REPRES. DE ÓRGÃOS INTERNACIONAIS',
            '107' => 'INSCRIÇÃO DE PESSOA JURÍDICA DOMICILIADA NO EXTERIOR',
            '109' => 'INSCRIÇÃO DE INCORPORAÇÃO IMOBILIÁRIA (PATRIMÔNIO DE AFETAÇÃO)',
            '110' => 'INSCRIÇÃO DE PRODUTOR RURAL (PRIMEIRO ESTABELECIMENTO)',
            '204' => 'CISÃO PARCIAL (ESPECÍFICO PARA A SUCEDIDA)',
            '206' => "DESCLASSIFICAÇÃO COMO ESTABELECIMENTO UNIFICADOR",
            '209' => "ALTERAÇÃO DE ENDEREÇO ENTRE MUNICÍPIOS DENTRO DO MESMO ESTADO",
            '210' => "ALTERAÇÃO DE ENDEREÇO ENTRE ESTADOS",
            '211' => "ALTERAÇÃO DE ENDEREÇO DENTRO DO MESMO MUNICÍPIO",
            '214' => "ALTERAÇÃO DE TELEFONE (DDD/TELEFONE)",
            '215' => "EXCLUSÃO DE TELEFONE (DDD/TELEFONE)",
            '216' => "ALTERAÇÃO DE FAX (DDD/FAX)",
            '217' => "EXCLUSÃO DE FAX (DDD/FAX)",
            '218' => "ALTERAÇÃO DE CORREIO ELETRÔNICO",
            '219' => "EXCLUSÃO DE CORREIO ELETRÔNICO",
            '220' => "ALTERAÇÃO DO NOME EMPRESARIAL (FIRMA OU DENOMINAÇÃO)",
            '221' => "ALTERAÇÃO DO TÍTULO DO ESTABELECIMENTO (NOME DE FANTASIA)",
            '222' => "ENQUADRAMENTO / REENQUADRAMENTO / DESENQUADRAMENTO DE ME/EPP",
            '224' => "ALTERAÇÃO DO CONTABILISTA RESPONSÁVEL PELA ORGANIZAÇÃO CONTÁBIL PERANTE O CRC",
            '225' => "ALTERAÇÃO DA NATUREZA JURÍDICA",
            '230' => "ALTERAÇÃO DA QUALIFICAÇÃO DA PESSOA FÍSICA RESPONSÁVEL PERANTE O CNPJ",
            '232' => "ALTERAÇÃO DO CONTABILISTA OU DA EMPRESA DE CONTABILIDADE",
            '233' => "EXCLUSÃO DO CONTABILISTA OU DA EMPRESA DE CONTABILIDADE",
            '235' => "ALTERAÇÃO DO ADMINISTRADOR DE EMPRESAS (FUNDOS/CLUBES E EQUIPARADAS)",
            '237' => "INDICAÇÃO DE PREPOSTO",
            '238' => "SUBSTITUIÇÃO DE PREPOSTO",
            '239' => "EXCLUSÃO DO PREPOSTO",
            '240' => "RENÚNCIA DO PREPOSTO",
            '241' => "EQUIPARAÇÃO, POR OPÇÃO, A ESTABELECIMENTO INDUSTRIAL",
            '242' => "DESISTÊNCIA DA EQUIPARAÇÃO, POR OPÇÃO, A ESTABELECIMENTO INDUSTRIAL",
            '243' => "ALTERAÇÃO DE ENDEREÇO DE PESSOA JURÍDICA DOMICILIADA NO EXTERIOR",
            '244' => "ALTERAÇÃO DE ATIVIDADES ECONOMICAS (PRINCIPAL E SECUNDÁRIAS)",
            '246' => "INDICAÇÃO DE ESTABELECIMENTO MATRIZ",
            '247' => "ALTERAÇÃO DE CAPITAL SOCIAL",
            '248' => "ALTERAÇÃO DO TIPO DE UNIDADE",
            '249' => "ALTERAÇÃO DA FORMA DE ATUAÇÃO",
            '250' => "ALTERAÇÃO DO VÍNCULO COM O IMÓVEL",
            '251' => "ALTERAÇÃO DA DATA DE VALIDADE DA INSCRIÇÃO",
            '252' => "ALTERAÇÃO DO NIRF",
            '253' => "ALTERAÇÃO DO PROPRIETÁRIO",
            '254' => "ALTERAÇÃO DO NOME EMPRESARIAL (ESPECÍFICO PARA PRODUTOR RURAL)",
            '255' => "EXCLUSÃO DE NIRE",
            '256' => "ALTERAÇÃO DA INSCRIÇÃO ESTADUAL ANTERIOR",
            '257' => "ALTERAÇÃO DO NÚMERO DE REGISTRO NO ÓRGÃO COMPETENTE",
            '260' => "ALTERAÇÃO/INCLUSÃO DE ENTE FEDERATIVO RESPONSÁVEL",
            '261' => "EXCLUSÃO DO NÚMERO DE REGISTRO NO ÓRGÃO COMPETENTE",
            '262' => "ALTERAÇÃO DA DEPENDÊNCIA ORÇAMENTÁRIA",
            '263' => "ALTERAÇÃO DO RESPONSÁVEL - PRODUTOR RURAL",
            '264' => "ALTERAÇÃO DE TIPO DE PRODUTOR RURAL (INDIVIDUAL OU SOCIEDADE)",
            '265' => "RENÚNCIA/ EXCLUSÃO DO REPRESENTANTE",
            '266' => "ATUALIZAÇÃO DE CEP DA PESSOA JURÍDICA",
            '267' => "INFORMAÇÕES DE BENEFICIÁRIO FINAL",
            '268' => "ALTERAÇÃO DO ENDEREÇO DE CORRESPONDÊNCIA",
            '299' => "ALTERAÇÃO DE DADOS ESPECÍFICOS",
            '303' => "EXCLUSÃO SIMPLES FEDERAL POR DÉBITO P/ COM FAZENDA NACIONAL OU PREVIDÊNCIA SOCIAL",
            '304' => "EXCLUSÃO DO SIMPLES FEDERAL POR ULTRAPASSAR OS LIMITES DE RECEITA BRUTA",
            '305' => "EXCLUSÃO DO SIMPLES FEDERAL POR TRANSFORMAÇÃO PARA A FORMA DE SOCIEDADE POR AÇÕES",
            '306' => "EXCLUSÃO DO SIMPLES FEDERAL POR EXERCÍCIO DE ATIVIDADE ECONÔMICA VEDADA",
            '307' => "EXCLUSÃO DO SIMPLES FEDERAL POR INGRESSO DE SÓCIO ESTRANGEIRO RESIDENTE NO EXTERIOR",
            '308' => "EXCLUSÃO SIMPLES FEDERAL POR TRANSF. FILIAL,SUC.,AG. OU REPRES. DE PJ COM SEDE NO EXTERIOR",
            '309' => "EXCLUSÃO DO SIMPLES FEDERAL POR PARTICIPAÇÃO NO CAPITAL DE OUTRA PESSOA JURÍDICA",
            '310' => "EXCLUSÃO SIMPLES FEDERAL POR EXIST. TITULAR/SÓCIO REALIZE GASTOS INCOMP. COM RENDIMENTOS DECLARADOS",
            '311' => "EXCLUSÃO SIMPLES FEDERAL POR PARTICIPAÇÃO DO TITULAR OU SÓCIO NO CAPITAL DE OUTRA EMPRESA",
            '312' => "EXCLUSÃO SIMPLES FEDERAL POR PARTICIPAÇÃO DE OUTRA PESSOA JURÍDICA NO CAPITAL DA EMPRESA",
            '313' => "EXCLUSÃO DO SIMPLES FEDERAL POR RECEITA DE VENDA DE BENS IMPORTADOS SUPERIOR AO LIMITE",
            '314' => "EXCLUSÃO DO SIMPLES FEDERAL POR PRÁTICA DE EMBARAÇO OU RESISTÊNCIA À FISCALIZAÇÃO",
            '315' => "EXCLUSÃO DO SIMPLES FEDERAL RETROATIVA À DATA DA OPÇÃO / ABERTURA",
            '316' => "ALTERAÇÃO DE TRIBUTOS DO SIMPLES FEDERAL",
            '317' => "DESFAZ EXCLUSÃO INDEVIDA",
            '318' => "DESFAZ INCLUSÃO INDEVIDA",
            '319' => "INCLUSÃO NO SIMPLES FEDERAL POR DECISÃO ADMINISTRATIVA",
            '320' => "INCLUSÃO NO SIMPLES FEDERAL POR MANDADO JUDICIAL",
            '321' => "EXCLUSÃO DO SIMPLES FEDERAL POR DECISÃO ADMINISTRATIVA",
            '322' => "EXCLUSÃO SIMPLES FEDERAL EMPRESA RESULTANTE CISÃO OU QUALQUER FORMA DE DESMEMBRAMENTO",
            '325' => "EXCLUSÃO DO SIMPLES FEDERAL POR INDUSTRIALIZAR BEBIDAS OU CIGARROS",
            '327' => "EVENTO DE ALTERAÇÃO DE PERÍODO DO SIMPLES NACIONAL",
            '405' => "DECRETAÇÃO DE FALÊNCIA",
            '406' => "REABILITAÇÃO DE FALÊNCIA",
            '407' => "ESPÓLIO DE EMPRESÁRIO, EMPRESA INDIVIDUAL IMOBILIÁRIA, EIRELI OU TITULAR DE EMPRESA UNIPESSOAL DE ADVOCACIA",
            '408' => "TÉRMINO DE LIQUIDAÇÃO",
            '410' => "INÍCIO DA INTERVENÇÃO",
            '411' => "ENCERRAMENTO DA INTERVENÇÃO",
            '412' => "INTERRUPÇÃO TEMPORÁRIA DE ATIVIDADES",
            '413' => "REINÍCIO DAS ATIVIDADES INTERROMPIDAS TEMPORARIAMENTE",
            '414' => "RESTABELECIMENTO DE INSCRIÇÃO DA ENTIDADE",
            '415' => "RESTABELECIMENTO DE INSCRIÇÃO DE FILIAL",
            '416' => "INÍCIO DE LIQUIDAÇÃO JUDICIAL",
            '417' => "INÍCIO DE LIQUIDAÇÃO EXTRAJUDICIAL",
            '418' => "RECUPERAÇÃO JUDICIAL",
            '419' => "ENCERRAMENTO DE RECUPERAÇÃO JUDICIAL",
            '510' => "EXTINÇÃO POR DETERMINAÇÃO JUDICIAL",
            '514' => "ANULAÇÃO DE INSCRIÇÃO INDEVIDA",
            '516' => "ANULAÇÃO POR VÍCIO",
            '517' => "PEDIDO DE BAIXA",
            '518' => "BAIXA - OMISSÃO CONTUMAZ",
            '519' => "BAIXA - INEXISTÊNCIA DE FATO",
            '522' => "BAIXA - INAPTIDÃO",
            '523' => "BAIXA - REGISTRO CANCELADO",
            '601' => "INSCRIÇÃO NO ESTADO",
            '602' => "INSCRIÇÃO DE SUBSTITUTO TRIBUTÁRIO NO ESTADO",
            '603' => "REATIVAÇÃO DA INSCRIÇÃO NO ESTADO",
            '604' => "PEDIDO DE BAIXA EXCLUSIVAMENTE NO ESTADO",
            '605' => "ALTERAÇÃO DO ENDEREÇO DE CORRESPONDÊNCIA",
            '606' => "INSCRIÇÃO NO ESTADO PARA ESTABELECIMENTO QUE ESTÁ LOCALIZADO EM OUTRO ESTADO, EXCETO SUBST. TRIB.",
            '607' => "PEDIDO DE BAIXA DE SUBSTITUTO TRIBUTÁRIO",
            '608' => "REATIVAÇÃO DE SUBSTITUTO TRIBUTÁRIO NO ESTADO",
            '611' => "ALTERAÇÃO DO REGIME DE APURAÇÃO NO ESTADO",
            '612' => "ALTERAÇÃO DE DADOS DA LICENÇA AMBIENTAL",
            '613' => "ALTERAÇÃO DA CONDIÇÃO DE SUBSTITUTO TRIBUTÁRIO",
            '621' => "ALTERAÇÃO DE CONDIÇÃO / REGIME DE APURAÇÃO",
            '624' => "ALTERAÇÃO DA LOCALIZAÇÃO",
            '625' => "OPÇÃO OU EXCLUSÃO DA INSCRIÇÃO ÚNICA",
            '626' => "INCLUSÃO DE ESTABELECIMENTO DA INSCRIÇÃO ÚNICA",
            '627' => "EXCLUSÃO DE ESTABELECIMENTO DA INSCRIÇÃO ÚNICA",
            '628' => "ALTERAÇÃO DO TIPO DE CONTRIBUINTE",
            '629' => "ALTERAÇÃO DA OPÇÃO POR LIVROS/DOCUMENTOS ELETRÔNICOS",
            '630' => "ALTERAÇÃO DA PERMANÊNCIA DE LIVROS FISCAIS",
            '632' => "ALTERAÇÃO DO TIPO DE CONVÊNIO / PROTOCOLO DE SUBSTITUIÇÃO TRIBUTÁRIA",
            '633' => "ALTERAÇÃO DO PROCURADOR NO ESTADO",
            '701' => "ALTERAÇÃO DO ENDEREÇO RESIDENCIAL (EVENTO EXCLUSIVO DO MEI)",
            '702' => "ALTERAÇÃO DO REGISTRO DE IDENTIDADE (EVENTO EXCLUSIVO DO MEI)",
            '703' => "ALTERAÇÃO DO CÓDIGO DE OCUPAÇÃO (PRINCIPAL E SECUNDÁRIO) (EVENTO EXCLUSIVO DO MEI)",
            '801' => "INSCRIÇÃO NO MUNICÍPIO",
            '802' => "INSCRIÇÃO MUNICIPAL VINCULADA A CNPJ JÁ CADASTRADO PARA OUTRO ESTABELECIMENTO",
            '803' => "INSCRIÇÃO PARA ESTABELECIMENTO SEDIADO EM OUTRO MUNICÍPIO",
            '804' => "PEDIDO DE BAIXA EXCLUSIVAMENTE NO MUNICÍPIO",
            '805' => "CORREÇÃO DO NÚMERO DE INSCRIÇÃO IMOBILIÁRIA",
            '806' => "ALTERAÇÃO DE ÁREA",
            '808' => "RENOVAÇÃO DO TVL (ALVARÁ)",
            '809' => "INFORMAÇÃO DE CÓDIGO DE ANÚNCIO",
            '810' => "INSCRIÇÃO NO MUNICÍPIO DE SÃO PAULO PARA ESTABELECIMENTO SEDIADO EM OUTRO MUNICÍPIO",
            '811' => "INFORMAÇÃO DO NÚMERO CCM CENTRALIZADOR",
            '812' => "ALTERAÇÃO DO ENDEREÇO DO ESTABELECIMENTO VINCULADO",
            '813' => "ALTERAÇÃO DO TELEFONE DO ESTABELECIMENTO VINCULADO",
            '814' => "ALTERAÇÃO DO REGIME DE TRIBUTAÇÃO",
            '850' => "ALVARÁ MUNICIPAL",
            '851' => "ALVARÁ SANITÁRIO MUNICIPAL",
            '852' => "ALVARÁ DO MEIO AMBIENTE MUNICIPAL",
            '853' => "LICENCIAMENTO DE TRANSPORTES",
            '854' => "ALVARÁ AGRÍCULA MUNICIPAL",
            '855' => "ALVARÁ DE EDUCAÇÃO MUNICIPAL",
            '856' => "ALVARÁ DE BRIGADA MUNICIPAL",
            '901' => "INCLUSÃO DE CNPJ - MATRIZ OU FILIAL",
            '902' => "INSCRIÇÃO DE ESTABELECIMENTO POR DETERMINAÇÃO JUDICIAL",
            '906' => "ANULAÇÃO POR MULTIPLICIDADE DE INSCRIÇÃO",
            '909' => "RESTAURAÇÃO DA SITUAÇÃO CADASTRAL ANTERIOR",
            '910' => "ALTERAÇÃO DE DATA DE ABERTURA",
            '912' => "SUSPENSÃO - BAIXA RECEPCIONADA (EM ANÁLISE)",
            '913' => "SUSPENSÃO - BAIXA INDEFERIDA",
            '915' => "SUSPENSÃO - INEXISTÊNCIA DE FATO",
            '916' => "INAPTIDÃO - INEXISTÊNCIA DE FATO",
            '922' => "DESFAZ INAPTIDÃO POR DETERMINAÇÃO JUDICIAL",
            '923' => "ALTERAÇÃO DE DATA DE PUBLICAÇÃO / DATA DE EFEITO",
            '924' => "CORREÇÃO DA DATA DE BAIXA",
            '926' => "DESFAZ CISÃO PARCIAL",
            '927' => "SUSPENSÃO - INDÍCIO DE INTERPOSIÇÃO FRAUDULENTA",
            '928' => "SUSPENSÃO - FALTA DE PLURALIDADE DE SÓCIOS",
            '929' => "CORREÇÃO DA DATA DE RESPONSABILIDADE",
            '938' => "SUSPENSÃO - DETERMINAÇÃO JUDICIAL",
            '939' => "INAPTIDÃO - OMISSÃO DE DECLARAÇÕES",
            '940' => "INAPTIDÃO - LOCALIZAÇÃO DESCONHECIDA",
            '941' => "SUBSTITUIÇÃO/ELIMINAÇÃO DO REGISTRO DE RESPONSABILIDADE",
            '942' => "SUSPENSÃO – INCONSISTÊNCIA CADASTRAL",
            '990' => "CORREÇÃO DE DADOS CADASTRAIS NO ÓRGÃO DE REGISTRO",
            '9001' => "ALTERAÇÃO DO NOME EMPRESARIAL",
            '9002' => "ALTERAÇÃO DA NATUREZA JURÍDICA",
            '9003' => "ALTERAÇÃO DO NOME FANTASIA",
            '9004' => "ALTERAÇÃO DO CAPITAL SOCIAL",
            '9005' => "ALTERAÇÃO DO CAPITAL INTEGRALIZADO",
            '9006' => "ALTERAÇÃO DO OBJETO SOCIAL",
            '9007' => "ALTERAÇÃO DOS DADOS DO CONTATO",
            '9008' => "ALTERAÇÃO DE EMAIL",
            '9009' => "ALTERAÇÃO DA SITUAÇÃO DO ESTABELECIMENTO",
            '9010' => "ALTERAÇÃO DE ENDEREÇO",
            '9011' => "ALTERAÇÃO DE ATIVIDADES ECONÔMICAS",
            '9012' => "ALTERAÇÃO DE DADOS DO SÓCIO/REPRESENTANTE",
            '9013' => "ALTERAÇÃO DE PORTE EMPRESARIAL",
            '994' => "INSCRIÇÃO IAGRO",
            '995' => "INSCRIÇÃO SUFRAMA",
            '996' => "INSCRIÇÃO MEIO AMBIENTE",
            '997' => "INSCRIÇÃO BOMBEIROS",
            '998' => "INSCRIÇÃO VIGILÂNCIA SANITÁRIA",
            '999' => "LICENCIAMENTO DE ESTABELECIMENTO ANTERIORMENTE REGISTRADO (LEGADO)",
        ];
        // Verificar se o código do evento existe no array
        $this->tooltipMessage = $eventos[$codEvento] ?? 'Código de evento desconhecido';
    }

    public function esconderTooltip()
    {
        $this->tooltipIdentificador = null;
        $this->tooltipMessage = null;
    }
    public function mostrarDetalhes($identificador)
    {
        // Busca os detalhes do estabelecimento pelo CNPJ
        $dados = $this->estabelecimentoService->getEstabelecimentoPorIdentificador($identificador);
        $this->detalhesEstabelecimento = [
            'cnpj' => $dados->cnpj,
            'nomeEmpresarial' => $dados->nomeEmpresarial,
            'nomeFantasia' => $dados->nomeFantasia,
            'dataAberturaEstabelecimento'=> $dados->dataAberturaEstabelecimento,
            'dataAberturaEmpresa'=> $dados->dataAberturaEmpresa,
            'dataInicioAtividade' => $dados->dataInicioAtividade,
            'nuProcessoOrgaoRegistro' => $dados->nuProcessoOrgaoRegistro,
            'situacaoCadastralRFB_descricao' => $dados->situacaoCadastralRFB_descricao,
            'opcaoSimplesNacional' => $dados->opcaoSimplesNacional,
            'porte' => $dados->porte,
            'nuInscricaoMunicipal' => $dados->nuInscricaoMunicipal,
            'capitalSocial' => $dados->capitalSocial,
            'possuiEstabelecimento' => $dados->possuiEstabelecimento,
            'ultimaViabilidadeVinculada' => $dados->ultimaViabilidadeVinculada,
            'ultimaViabilidadeAnaliseEndereco' => $dados->ultimaViabilidadeAnaliseEndereco,
            'dataUltimaAnaliseEndereco' => $dados->dataUltimaAnaliseEndereco,
            'ultimoColetorEstadualWebVinculado' => $dados->ultimoColetorEstadualWebVinculado,
            'endereco_cep' => $dados->endereco_cep,
            'endereco_logradouro' => $dados->endereco_logradouro,
            'endereco_codTipoLogradouro' => $dados->endereco_codTipoLogradouro,
            'endereco_numLogradouro' => $dados->endereco_numLogradouro,
            'endereco_complemento' => $dados->endereco_complemento,
            'endereco_bairro' => $dados->endereco_bairro,
            'endereco_codMunicipio' => $dados->endereco_codMunicipio,
            'endereco_uf' => $dados->endereco_uf,
        ];

        $this->mostrarModal = true;
    }
    public function fecharModal()
    {
        $this->mostrarModal = false; // Fecha o modal
    }

    // Método de renderização do componente
    public function render()
    {
        $estabelecimentos = $this->getEstabelecimentosProperty();

        return view('livewire.estabelecimentos-table', [
            'estabelecimentos' => $estabelecimentos,
        ]);
    }
}
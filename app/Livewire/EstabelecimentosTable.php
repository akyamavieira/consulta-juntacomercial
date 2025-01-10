<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\EstabelecimentoService;

class EstabelecimentosTable extends Component
{
    public $estabelecimentos;
    public $detalhesEstabelecimento;
    public $mostrarModal = false;
    public $tooltipIdentificador = null;
    public $tooltipMessage = null;
    protected $estabelecimentoService;

    public function boot(EstabelecimentoService $estabelecimentoService)
    {
        $this->estabelecimentoService = $estabelecimentoService;
    }

    public function mount()
    {
        //dd($this->atualizarEstabelecimentos());
        $this->atualizarEstabelecimentos();
    }

    public function atualizarEstabelecimentos()
    {
        // Busca estabelecimentos do serviço com cache já configurado
        $this->estabelecimentos = $this->estabelecimentoService->getEstabelecimentos();
    }

    public function mostrarTooltip($identificador, $codEvento)
    {
        //dd($codEvento);
        $this->tooltipIdentificador = $identificador;
        // Switch para associar o código do evento ao texto
        switch ($codEvento) {
            case '001':
                $this->tooltipMessage = 'ENTRADA DE SÓCIO/ADMINISTRADOR';
                break;
            case '002':
                $this->tooltipMessage = 'ALTERAÇÃO DA DATA DE INCLUSÃO';
                break;
            case '003':
                $this->tooltipMessage = 'ALTERAÇÃO DE DADOS DO SÓCIO/ADMINISTRADOR';
                break;
            case '005':
                $this->tooltipMessage = 'SAÍDA DE SÓCIO/ADMINISTRADOR';
                break;
            case '006':
                $this->tooltipMessage = 'ALTERAÇÃO DA DATA DE EXCLUSÃO';
                break;
            case '007':
                $this->tooltipMessage = 'ALTERAÇÃO DA DATA DE INCLUSÃO DE SÓCIO/ADMINISTRADOR EXCLUÍDO';
                break;
            case '008':
                $this->tooltipMessage = 'EXCLUSÃO DE REGISTRO DE SÓCIO/ADMINISTRADOR';
                break;
            case '010':
                $this->tooltipMessage = 'INFORMAÇÃO DE SÓCIO PARA CONFERÊNCIA COM A BASE CNPJ';
                break;
            case '011':
                $this->tooltipMessage = 'ENTRADA DO BENEFICIÁRIO FINAL';
                break;
            case '012':
                $this->tooltipMessage = 'ALTERAÇÃO DE DADOS DO BENEFICIÁRIO FINAL';
                break;
            case '013':
                $this->tooltipMessage = 'SAÍDA DO BENEFICIÁRIO FINAL';
                break;
            case '052':
                $this->tooltipMessage = 'REATIVAÇÃO - ARTIGO 60 LEI 8.934/94';
                break;
            case '101':
                $this->tooltipMessage = 'INSCRIÇÃO DE PRIMEIRO ESTABELECIMENTO';
                break;
            case '102':
                $this->tooltipMessage = 'INSCRIÇÃO DOS DEMAIS ESTABELECIMENTOS';
                break;
            case '103':
                $this->tooltipMessage = 'INSCRIÇÃO DE ESTABELECIMENTO FILIAL DE EMPRESA BRASILEIRA NO EXTERIOR';
                break;
            case '105':
                $this->tooltipMessage = 'INSCRIÇÃO DE EMBAIXADA/CONSULADO/REPRESENTAÇÕES DO GOVERNO NO EXTERIOR';
                break;
            case '106':
                $this->tooltipMessage = 'INSCRIÇÃO DE MISSÕES DIPL./REPART. CONSUL./REPRES. DE ÓRGÃOS INTERNACIONAIS';
                break;
            case '107':
                $this->tooltipMessage = 'INSCRIÇÃO DE PESSOA JURÍDICA DOMICILIADA NO EXTERIOR';
                break;
            case '109':
                $this->tooltipMessage = 'INSCRIÇÃO DE INCORPORAÇÃO IMOBILIÁRIA (PATRIMÔNIO DE AFETAÇÃO)';
                break;
            case '110':
                $this->tooltipMessage = 'INSCRIÇÃO DE PRODUTOR RURAL (PRIMEIRO ESTABELECIMENTO)';
                break;
                break;
            case 204:
                $this->tooltipMessage = "CISÃO PARCIAL (ESPECÍFICO PARA A SUCEDIDA)";
                break;
            case 206:
                $this->tooltipMessage = "DESCLASSIFICAÇÃO COMO ESTABELECIMENTO UNIFICADOR";
                break;
            case 209:
                $this->tooltipMessage = "ALTERAÇÃO DE ENDEREÇO ENTRE MUNICÍPIOS DENTRO DO MESMO ESTADO";
                break;
            case 210:
                $this->tooltipMessage = "ALTERAÇÃO DE ENDEREÇO ENTRE ESTADOS";
                break;
            case 211:
                $this->tooltipMessage = "ALTERAÇÃO DE ENDEREÇO DENTRO DO MESMO MUNICÍPIO";
                break;
            case 214:
                $this->tooltipMessage = "ALTERAÇÃO DE TELEFONE (DDD/TELEFONE)";
                break;
            case 215:
                $this->tooltipMessage = "EXCLUSÃO DE TELEFONE (DDD/TELEFONE)";
                break;
            case 216:
                $this->tooltipMessage = "ALTERAÇÃO DE FAX (DDD/FAX)";
                break;
            case 217:
                $this->tooltipMessage = "EXCLUSÃO DE FAX (DDD/FAX)";
                break;
            case 218:
                $this->tooltipMessage = "ALTERAÇÃO DE CORREIO ELETRÔNICO";
                break;
            case 219:
                $this->tooltipMessage = "EXCLUSÃO DE CORREIO ELETRÔNICO";
                break;
            case 220:
                $this->tooltipMessage = "ALTERAÇÃO DO NOME EMPRESARIAL (FIRMA OU DENOMINAÇÃO)";
                break;
            case 221:
                $this->tooltipMessage = "ALTERAÇÃO DO TÍTULO DO ESTABELECIMENTO (NOME DE FANTASIA)";
                break;
            case 222:
                $this->tooltipMessage = "ENQUADRAMENTO / REENQUADRAMENTO / DESENQUADRAMENTO DE ME/EPP";
                break;
            case 224:
                $this->tooltipMessage = "ALTERAÇÃO DO CONTABILISTA RESPONSÁVEL PELA ORGANIZAÇÃO CONTÁBIL PERANTE O CRC";
                break;
            case 225:
                $this->tooltipMessage = "ALTERAÇÃO DA NATUREZA JURÍDICA";
                break;
            case 230:
                $this->tooltipMessage = "ALTERAÇÃO DA QUALIFICAÇÃO DA PESSOA FÍSICA RESPONSÁVEL PERANTE O CNPJ";
                break;
            case 232:
                $this->tooltipMessage = "ALTERAÇÃO DO CONTABILISTA OU DA EMPRESA DE CONTABILIDADE";
                break;
            case 233:
                $this->tooltipMessage = "EXCLUSÃO DO CONTABILISTA OU DA EMPRESA DE CONTABILIDADE";
                break;
            case 235:
                $this->tooltipMessage = "ALTERAÇÃO DO ADMINISTRADOR DE EMPRESAS (FUNDOS/CLUBES E EQUIPARADAS)";
                break;
            case 237:
                $this->tooltipMessage = "INDICAÇÃO DE PREPOSTO";
                break;
            case 238:
                $this->tooltipMessage = "SUBSTITUIÇÃO DE PREPOSTO";
                break;
            case 239:
                $this->tooltipMessage = "EXCLUSÃO DO PREPOSTO";
                break;
            case 240:
                $this->tooltipMessage = "RENÚNCIA DO PREPOSTO";
                break;
            case 241:
                $this->tooltipMessage = "EQUIPARAÇÃO, POR OPÇÃO, A ESTABELECIMENTO INDUSTRIAL";
                break;
            case 242:
                $this->tooltipMessage = "DESISTÊNCIA DA EQUIPARAÇÃO, POR OPÇÃO, A ESTABELECIMENTO INDUSTRIAL";
                break;
            case 243:
                $this->tooltipMessage = "ALTERAÇÃO DE ENDEREÇO DE PESSOA JURÍDICA DOMICILIADA NO EXTERIOR";
                break;
            case 244:
                $this->tooltipMessage = "ALTERAÇÃO DE ATIVIDADES ECONOMICAS (PRINCIPAL E SECUNDÁRIAS)";
                break;
            case 246:
                $this->tooltipMessage = "INDICAÇÃO DE ESTABELECIMENTO MATRIZ";
                break;
            case 247:
                $this->tooltipMessage = "ALTERAÇÃO DE CAPITAL SOCIAL";
                break;
            case 248:
                $this->tooltipMessage = "ALTERAÇÃO DO TIPO DE UNIDADE";
                break;
            case 249:
                $this->tooltipMessage = "ALTERAÇÃO DA FORMA DE ATUAÇÃO";
                break;
            case 250:
                $this->tooltipMessage = "ALTERAÇÃO DO VÍNCULO COM O IMÓVEL";
                break;
            case 251:
                $this->tooltipMessage = "ALTERAÇÃO DA DATA DE VALIDADE DA INSCRIÇÃO";
                break;
            case 252:
                $this->tooltipMessage = "ALTERAÇÃO DO NIRF";
                break;
            case 253:
                $this->tooltipMessage = "ALTERAÇÃO DO PROPRIETÁRIO";
                break;
            case 254:
                $this->tooltipMessage = "ALTERAÇÃO DO NOME EMPRESARIAL (ESPECÍFICO PARA PRODUTOR RURAL)";
                break;
            case 255:
                $this->tooltipMessage = "EXCLUSÃO DE NIRE";
                break;
            case 256:
                $this->tooltipMessage = "ALTERAÇÃO DA INSCRIÇÃO ESTADUAL ANTERIOR";
                break;
            case 257:
                $this->tooltipMessage = "ALTERAÇÃO DO NÚMERO DE REGISTRO NO ÓRGÃO COMPETENTE";
                break;
            case 260:
                $this->tooltipMessage = "ALTERAÇÃO/INCLUSÃO DE ENTE FEDERATIVO RESPONSÁVEL";
                break;
            case 261:
                $this->tooltipMessage = "EXCLUSÃO DO NÚMERO DE REGISTRO NO ÓRGÃO COMPETENTE";
                break;
            case 262:
                $this->tooltipMessage = "ALTERAÇÃO DA DEPENDÊNCIA ORÇAMENTÁRIA";
                break;
            case 263:
                $this->tooltipMessage = "ALTERAÇÃO DO RESPONSÁVEL - PRODUTOR RURAL";
                break;
            case 264:
                $this->tooltipMessage = "ALTERAÇÃO DE TIPO DE PRODUTOR RURAL (INDIVIDUAL OU SOCIEDADE)";
                break;
            case 265:
                $this->tooltipMessage = "RENÚNCIA/ EXCLUSÃO DO REPRESENTANTE";
                break;
            case 266:
                $this->tooltipMessage = "ATUALIZAÇÃO DE CEP DA PESSOA JURÍDICA";
                break;
            case 267:
                $this->tooltipMessage = "INFORMAÇÕES DE BENEFICIÁRIO FINAL";
                break;
            case 268:
                $this->tooltipMessage = "ALTERAÇÃO DO ENDEREÇO DE CORRESPONDÊNCIA";
                break;
            case 299:
                $this->tooltipMessage = "ALTERAÇÃO DE DADOS ESPECÍFICOS";
                break;
            case 303:
                $this->tooltipMessage = "EXCLUSÃO SIMPLES FEDERAL POR DÉBITO P/ COM FAZENDA NACIONAL OU PREVIDÊNCIA SOCIAL";
                break;
            case 304:
                $this->tooltipMessage = "EXCLUSÃO DO SIMPLES FEDERAL POR ULTRAPASSAR OS LIMITES DE RECEITA BRUTA";
                break;
            case 305:
                $this->tooltipMessage = "EXCLUSÃO DO SIMPLES FEDERAL POR TRANSFORMAÇÃO PARA A FORMA DE SOCIEDADE POR AÇÕES";
                break;
            case 306:
                $this->tooltipMessage = "EXCLUSÃO DO SIMPLES FEDERAL POR EXERCÍCIO DE ATIVIDADE ECONÔMICA VEDADA";
                break;
            case 307:
                $this->tooltipMessage = "EXCLUSÃO DO SIMPLES FEDERAL POR INGRESSO DE SÓCIO ESTRANGEIRO RESIDENTE NO EXTERIOR";
                break;
            case 308:
                $this->tooltipMessage = "EXCLUSÃO SIMPLES FEDERAL POR TRANSF. FILIAL,SUC.,AG. OU REPRES. DE PJ COM SEDE NO EXTERIOR";
                break;
            case 309:
                $this->tooltipMessage = "EXCLUSÃO DO SIMPLES FEDERAL POR PARTICIPAÇÃO NO CAPITAL DE OUTRA PESSOA JURÍDICA";
                break;
            case 310:
                $this->tooltipMessage = "EXCLUSÃO SIMPLES FEDERAL POR EXIST. TITULAR/SÓCIO REALIZE GASTOS INCOMP. COM RENDIMENTOS DECLARADOS";
                break;
            case 311:
                $this->tooltipMessage = "EXCLUSÃO SIMPLES FEDERAL POR PARTICIPAÇÃO DO TITULAR OU SÓCIO NO CAPITAL DE OUTRA EMPRESA";
                break;
            case 312:
                $this->tooltipMessage = "EXCLUSÃO SIMPLES FEDERAL POR PARTICIPAÇÃO DE OUTRA PESSOA JURÍDICA NO CAPITAL DA EMPRESA";
                break;
            case 313:
                $this->tooltipMessage = "EXCLUSÃO DO SIMPLES FEDERAL POR RECEITA DE VENDA DE BENS IMPORTADOS SUPERIOR AO LIMITE";
                break;
            case 314:
                $this->tooltipMessage = "EXCLUSÃO DO SIMPLES FEDERAL POR PRÁTICA DE EMBARAÇO OU RESISTÊNCIA À FISCALIZAÇÃO";
                break;
            case 315:
                $this->tooltipMessage = "EXCLUSÃO DO SIMPLES FEDERAL RETROATIVA À DATA DA OPÇÃO / ABERTURA";
                break;
            case 316:
                $this->tooltipMessage = "ALTERAÇÃO DE TRIBUTOS DO SIMPLES FEDERAL";
                break;
            case 317:
                $this->tooltipMessage = "DESFAZ EXCLUSÃO INDEVIDA";
                break;
            case 318:
                $this->tooltipMessage = "DESFAZ INCLUSÃO INDEVIDA";
                break;
            case 319:
                $this->tooltipMessage = "INCLUSÃO NO SIMPLES FEDERAL POR DECISÃO ADMINISTRATIVA";
                break;
            case 320:
                $this->tooltipMessage = "INCLUSÃO NO SIMPLES FEDERAL POR MANDADO JUDICIAL";
                break;
            case 321:
                $this->tooltipMessage = "EXCLUSÃO DO SIMPLES FEDERAL POR DECISÃO ADMINISTRATIVA";
                break;
            case 322:
                $this->tooltipMessage = "EXCLUSÃO SIMPLES FEDERAL EMPRESA RESULTANTE CISÃO OU QUALQUER FORMA DE DESMEMBRAMENTO";
                break;
            case 325:
                $this->tooltipMessage = "EXCLUSÃO DO SIMPLES FEDERAL POR INDUSTRIALIZAR BEBIDAS OU CIGARROS";
                break;
            case 327:
                $this->tooltipMessage = "EVENTO DE ALTERAÇÃO DE PERÍODO DO SIMPLES NACIONAL";
                break;
            case 405:
                $this->tooltipMessage = "DECRETAÇÃO DE FALÊNCIA";
                break;
            case 406:
                $this->tooltipMessage = "REABILITAÇÃO DE FALÊNCIA";
                break;
            case 407:
                $this->tooltipMessage = "ESPÓLIO DE EMPRESÁRIO, EMPRESA INDIVIDUAL IMOBILIÁRIA, EIRELI OU TITULAR DE EMPRESA UNIPESSOAL DE ADVOCACIA";
                break;
            case 408:
                $this->tooltipMessage = "TÉRMINO DE LIQUIDAÇÃO";
                break;
            case 410:
                $this->tooltipMessage = "INÍCIO DA INTERVENÇÃO";
                break;
            case 411:
                $this->tooltipMessage = "ENCERRAMENTO DA INTERVENÇÃO";
                break;
            case 412:
                $this->tooltipMessage = "INTERRUPÇÃO TEMPORÁRIA DE ATIVIDADES";
                break;
            case 413:
                $this->tooltipMessage = "REINÍCIO DAS ATIVIDADES INTERROMPIDAS TEMPORARIAMENTE";
                break;
            case 414:
                $this->tooltipMessage = "RESTABELECIMENTO DE INSCRIÇÃO DA ENTIDADE";
                break;
            case 415:
                $this->tooltipMessage = "RESTABELECIMENTO DE INSCRIÇÃO DE FILIAL";
                break;
            case 416:
                $this->tooltipMessage = "INÍCIO DE LIQUIDAÇÃO JUDICIAL";
                break;
            case 417:
                $this->tooltipMessage = "INÍCIO DE LIQUIDAÇÃO EXTRAJUDICIAL";
                break;
            case 418:
                $this->tooltipMessage = "RECUPERAÇÃO JUDICIAL";
                break;
            case 419:
                $this->tooltipMessage = "ENCERRAMENTO DE RECUPERAÇÃO JUDICIAL";
                break;
            case 510:
                $this->tooltipMessage = "EXTINÇÃO POR DETERMINAÇÃO JUDICIAL";
                break;
            case 514:
                $this->tooltipMessage = "ANULAÇÃO DE INSCRIÇÃO INDEVIDA";
                break;
            case 516:
                $this->tooltipMessage = "ANULAÇÃO POR VÍCIO";
                break;
            case 517:
                $this->tooltipMessage = "PEDIDO DE BAIXA";
                break;
            case 518:
                $this->tooltipMessage = "BAIXA - OMISSÃO CONTUMAZ";
                break;
            case 519:
                $this->tooltipMessage = "BAIXA - INEXISTÊNCIA DE FATO";
                break;
            case 522:
                $this->tooltipMessage = "BAIXA - INAPTIDÃO";
                break;
            case 523:
                $this->tooltipMessage = "BAIXA - REGISTRO CANCELADO";
                break;
            case 601:
                $this->tooltipMessage = "INSCRIÇÃO NO ESTADO";
                break;
            case 602:
                $this->tooltipMessage = "INSCRIÇÃO DE SUBSTITUTO TRIBUTÁRIO NO ESTADO";
                break;
            case 603:
                $this->tooltipMessage = "REATIVAÇÃO DA INSCRIÇÃO NO ESTADO";
                break;
            case 604:
                $this->tooltipMessage = "PEDIDO DE BAIXA EXCLUSIVAMENTE NO ESTADO";
                break;
            case 605:
                $this->tooltipMessage = "ALTERAÇÃO DO ENDEREÇO DE CORRESPONDÊNCIA";
                break;
            case 606:
                $this->tooltipMessage = "INSCRIÇÃO NO ESTADO PARA ESTABELECIMENTO QUE ESTÁ LOCALIZADO EM OUTRO ESTADO, EXCETO SUBST. TRIB.";
                break;
            case 607:
                $this->tooltipMessage = "PEDIDO DE BAIXA DE SUBSTITUTO TRIBUTÁRIO";
                break;
            case 608:
                $this->tooltipMessage = "REATIVAÇÃO DE SUBSTITUTO TRIBUTÁRIO NO ESTADO";
                break;
            case 611:
                $this->tooltipMessage = "ALTERAÇÃO DO REGIME DE APURAÇÃO NO ESTADO";
                break;
            case 612:
                $this->tooltipMessage = "ALTERAÇÃO DE DADOS DA LICENÇA AMBIENTAL";
                break;
            case 613:
                $this->tooltipMessage = "ALTERAÇÃO DA CONDIÇÃO DE SUBSTITUTO TRIBUTÁRIO";
                break;
            case 621:
                $this->tooltipMessage = "ALTERAÇÃO DE CONDIÇÃO / REGIME DE APURAÇÃO";
                break;
            case 624:
                $this->tooltipMessage = "ALTERAÇÃO DA LOCALIZAÇÃO";
                break;
            case 625:
                $this->tooltipMessage = "OPÇÃO OU EXCLUSÃO DA INSCRIÇÃO ÚNICA";
                break;
            case 626:
                $this->tooltipMessage = "INCLUSÃO DE ESTABELECIMENTO DA INSCRIÇÃO ÚNICA";
                break;
            case 627:
                $this->tooltipMessage = "EXCLUSÃO DE ESTABELECIMENTO DA INSCRIÇÃO ÚNICA";
                break;
            case 628:
                $this->tooltipMessage = "ALTERAÇÃO DO TIPO DE CONTRIBUINTE";
                break;
            case 629:
                $this->tooltipMessage = "ALTERAÇÃO DA OPÇÃO POR LIVROS/DOCUMENTOS ELETRÔNICOS";
                break;
            case 630:
                $this->tooltipMessage = "ALTERAÇÃO DA PERMANÊNCIA DE LIVROS FISCAIS";
                break;
            case 632:
                $this->tooltipMessage = "ALTERAÇÃO DO TIPO DE CONVÊNIO / PROTOCOLO DE SUBSTITUIÇÃO TRIBUTÁRIA";
                break;
            case 633:
                $this->tooltipMessage = "ALTERAÇÃO DO PROCURADOR NO ESTADO";
                break;
            case 701:
                $this->tooltipMessage = "ALTERAÇÃO DO ENDEREÇO RESIDENCIAL (EVENTO EXCLUSIVO DO MEI)";
                break;
            case 702:
                $this->tooltipMessage = "ALTERAÇÃO DO REGISTRO DE IDENTIDADE (EVENTO EXCLUSIVO DO MEI)";
                break;
            case 703:
                $this->tooltipMessage = "ALTERAÇÃO DO CÓDIGO DE OCUPAÇÃO (PRINCIPAL E SECUNDÁRIO) (EVENTO EXCLUSIVO DO MEI)";
                break;
            case 801:
                $this->tooltipMessage = "INSCRIÇÃO NO MUNICÍPIO";
                break;
            case 802:
                $this->tooltipMessage = "INSCRIÇÃO MUNICIPAL VINCULADA A CNPJ JÁ CADASTRADO PARA OUTRO ESTABELECIMENTO";
                break;
            case 803:
                $this->tooltipMessage = "INSCRIÇÃO PARA ESTABELECIMENTO SEDIADO EM OUTRO MUNICÍPIO";
                break;
            case 804:
                $this->tooltipMessage = "PEDIDO DE BAIXA EXCLUSIVAMENTE NO MUNICÍPIO";
                break;
            case 805:
                $this->tooltipMessage = "CORREÇÃO DO NÚMERO DE INSCRIÇÃO IMOBILIÁRIA";
                break;
            case 806:
                $this->tooltipMessage = "ALTERAÇÃO DE ÁREA";
                break;
            case 808:
                $this->tooltipMessage = "RENOVAÇÃO DO TVL (ALVARÁ)";
                break;
            case 809:
                $this->tooltipMessage = "INFORMAÇÃO DE CÓDIGO DE ANÚNCIO";
                break;
            case 810:
                $this->tooltipMessage = "INSCRIÇÃO NO MUNICÍPIO DE SÃO PAULO PARA ESTABELECIMENTO SEDIADO EM OUTRO MUNICÍPIO";
                break;
            case 811:
                $this->tooltipMessage = "INFORMAÇÃO DO NÚMERO CCM CENTRALIZADOR";
                break;
            case 812:
                $this->tooltipMessage = "ALTERAÇÃO DO ENDEREÇO DO ESTABELECIMENTO VINCULADO";
                break;
            case 813:
                $this->tooltipMessage = "ALTERAÇÃO DO TELEFONE DO ESTABELECIMENTO VINCULADO";
                break;
            case 814:
                $this->tooltipMessage = "ALTERAÇÃO DO REGIME DE TRIBUTAÇÃO";
                break;
            case 850:
                $this->tooltipMessage = "ALVARÁ MUNICIPAL";
                break;
            case 851:
                $this->tooltipMessage = "ALVARÁ SANITÁRIO MUNICIPAL";
                break;
            case 852:
                $this->tooltipMessage = "ALVARÁ DO MEIO AMBIENTE MUNICIPAL";
                break;
            case 853:
                $this->tooltipMessage = "LICENCIAMENTO DE TRANSPORTES";
                break;
            case 854:
                $this->tooltipMessage = "ALVARÁ AGRÍCULA MUNICIPAL";
                break;
            case 855:
                $this->tooltipMessage = "ALVARÁ DE EDUCAÇÃO MUNICIPAL";
                break;
            case 856:
                $this->tooltipMessage = "ALVARÁ DE BRIGADA MUNICIPAL";
                break;
            case 901:
                $this->tooltipMessage = "INCLUSÃO DE CNPJ - MATRIZ OU FILIAL";
                break;
            case 902:
                $this->tooltipMessage = "INSCRIÇÃO DE ESTABELECIMENTO POR DETERMINAÇÃO JUDICIAL";
                break;
            case 906:
                $this->tooltipMessage = "ANULAÇÃO POR MULTIPLICIDADE DE INSCRIÇÃO";
                break;
            case 909:
                $this->tooltipMessage = "RESTAURAÇÃO DA SITUAÇÃO CADASTRAL ANTERIOR";
                break;
            case 910:
                $this->tooltipMessage = "ALTERAÇÃO DE DATA DE ABERTURA";
                break;
            case 912:
                $this->tooltipMessage = "SUSPENSÃO - BAIXA RECEPCIONADA (EM ANÁLISE)";
                break;
            case 913:
                $this->tooltipMessage = "SUSPENSÃO - BAIXA INDEFERIDA";
                break;
            case 915:
                $this->tooltipMessage = "SUSPENSÃO - INEXISTÊNCIA DE FATO";
                break;
            case 916:
                $this->tooltipMessage = "INAPTIDÃO - INEXISTÊNCIA DE FATO";
                break;
            case 922:
                $this->tooltipMessage = "DESFAZ INAPTIDÃO POR DETERMINAÇÃO JUDICIAL";
                break;
            case 923:
                $this->tooltipMessage = "ALTERAÇÃO DE DATA DE PUBLICAÇÃO / DATA DE EFEITO";
                break;
            case 924:
                $this->tooltipMessage = "CORREÇÃO DA DATA DE BAIXA";
                break;
            case 926:
                $this->tooltipMessage = "DESFAZ CISÃO PARCIAL";
                break;
            case 927:
                $this->tooltipMessage = "SUSPENSÃO - INDÍCIO DE INTERPOSIÇÃO FRAUDULENTA";
                break;
            case 928:
                $this->tooltipMessage = "SUSPENSÃO - FALTA DE PLURALIDADE DE SÓCIOS";
                break;
            case 929:
                $this->tooltipMessage = "CORREÇÃO DA DATA DE RESPONSABILIDADE";
                break;
            case 938:
                $this->tooltipMessage = "SUSPENSÃO - DETERMINAÇÃO JUDICIAL";
                break;
            case 939:
                $this->tooltipMessage = "INAPTIDÃO - OMISSÃO DE DECLARAÇÕES";
                break;
            case 940:
                $this->tooltipMessage = "INAPTIDÃO - LOCALIZAÇÃO DESCONHECIDA";
                break;
            case 941:
                $this->tooltipMessage = "SUBSTITUIÇÃO/ELIMINAÇÃO DO REGISTRO DE RESPONSABILIDADE";
                break;
            case 942:
                $this->tooltipMessage = "SUSPENSÃO – INCONSISTÊNCIA CADASTRAL";
                break;
            case 990:
                $this->tooltipMessage = "CORREÇÃO DE DADOS CADASTRAIS NO ÓRGÃO DE REGISTRO";
                break;
            case 9001:
                $this->tooltipMessage = "ALTERAÇÃO DO NOME EMPRESARIAL";
                break;
            case 9002:
                $this->tooltipMessage = "ALTERAÇÃO DA NATUREZA JURÍDICA";
                break;
            case 9003:
                $this->tooltipMessage = "ALTERAÇÃO DO NOME FANTASIA";
                break;
            case 9004:
                $this->tooltipMessage = "ALTERAÇÃO DO CAPITAL SOCIAL";
                break;
            case 9005:
                $this->tooltipMessage = "ALTERAÇÃO DO CAPITAL INTEGRALIZADO";
                break;
            case 9006:
                $this->tooltipMessage = "ALTERAÇÃO DO OBJETO SOCIAL";
                break;
            case 9007:
                $this->tooltipMessage = "ALTERAÇÃO DOS DADOS DO CONTATO";
                break;
            case 9008:
                $this->tooltipMessage = "ALTERAÇÃO DE EMAIL";
                break;
            case 9009:
                $this->tooltipMessage = "ALTERAÇÃO DA SITUAÇÃO DO ESTABELECIMENTO";
                break;
            case 9010:
                $this->tooltipMessage = "ALTERAÇÃO DE ENDEREÇO";
                break;
            case 9011:
                $this->tooltipMessage = "ALTERAÇÃO DE ATIVIDADES ECONÔMICAS";
                break;
            case 9012:
                $this->tooltipMessage = "ALTERAÇÃO DE DADOS DO SÓCIO/REPRESENTANTE";
                break;
            case 9013:
                $this->tooltipMessage = "ALTERAÇÃO DE PORTE EMPRESARIAL";
                break;
            case 994:
                $this->tooltipMessage = "INSCRIÇÃO IAGRO";
                break;
            case 995:
                $this->tooltipMessage = "INSCRIÇÃO SUFRAMA";
                break;
            case 996:
                $this->tooltipMessage = "INSCRIÇÃO MEIO AMBIENTE";
                break;
            case 997:
                $this->tooltipMessage = "INSCRIÇÃO BOMBEIROS";
                break;
            case 998:
                $this->tooltipMessage = "INSCRIÇÃO VIGILÂNCIA SANITÁRIA";
                break;
            case 999:
                $this->tooltipMessage = "LICENCIAMENTO DE ESTABELECIMENTO ANTERIORMENTE REGISTRADO (LEGADO)";
                break;
            default:
                $this->tooltipMessage = "Código de evento não encontrado.";
                break;
        }
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

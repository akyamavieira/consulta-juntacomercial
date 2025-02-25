<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Estabelecimento;
use App\Services\EstabelecimentoService;

class EstabelecimentosTable extends Component
{
    use WithPagination;

    public $mostrarModal = false;
    public $query = '';
    public $filterME = false;
    public $filterEPP = false;
    public $filterOutros = false;
    public $filterBairros = [];
    public $filterMunicipios = []; // Nova propriedade para municípios
    public $filterSetores = []; // Nova propriedade para setores
    public $filterSituacaoCadastral = []; // Nova propriedade para situação cadastral
    public $filterCapitalSocial = [];

    protected $listeners = [
        'refreshTable' => '$refresh',
        'searchUpdated' => 'handleSearchUpdated',
        'filterUpdated' => 'handleFilterUpdated',
    ];

    public function boot(EstabelecimentoService $estabelecimentoService)
    {
        $this->estabelecimentoService = $estabelecimentoService;
    }

    public function search()
    {
        $this->resetPage();
    }

    public function mostrarDetalhes($identificador)
    {
        \Log::info('mostrarDetalhes chamado com identificador: ' . $identificador);
        $this->dispatch('mostrarDetalhes', ['identificador' => $identificador]);
    }

    public function handleSearchUpdated($query)
    {
        $this->query = $query;
        $this->resetPage();
    }

    public function handleFilterUpdated($filter, $value)
    {
        if ($filter === 'filterME') {
            $this->filterME = $value;
        } elseif ($filter === 'filterEPP') {
            $this->filterEPP = $value;
        } elseif ($filter === 'filterOutros') {
            $this->filterOutros = $value;
        } elseif ($filter === 'filterBairros') {
            $this->filterBairros = is_array($value) ? $value : [];
        } elseif ($filter === 'filterMunicipios') {
            $this->filterMunicipios = is_array($value) ? $value : [];
        } elseif ($filter === 'filterSetores') {
            $this->filterSetores = is_array($value) ? $value : [];
        } elseif ($filter === 'filterSituacaoCadastral') {
            $this->filterSituacaoCadastral = is_array($value) ? $value : [];
        } elseif ($filter === 'filterCapitalSocial') {
            $this->filterCapitalSocial = is_array($value) ? $value : [];
        }
        $this->resetPage();
    }

    public function render()
    {
        $estabelecimentos = Estabelecimento::where(function ($query) {
            $query->where('cnpj', 'ILIKE', '%' . $this->query . '%')
                  ->orWhere('nuInscricaoMunicipal', 'ILIKE', '%' . $this->query . '%')
                  ->orWhere('nomeEmpresarial', 'ILIKE', '%' . $this->query . '%')
                  ->orWhere('nomeFantasia', 'ILIKE', '%' . $this->query . '%');
        })
        ->when($this->filterME || $this->filterEPP || $this->filterOutros, function ($query) {
            $query->where(function ($subQuery) {
                if ($this->filterME) {
                    $subQuery->orWhere('porte', 'ME');
                }
                if ($this->filterEPP) {
                    $subQuery->orWhere('porte', 'EPP');
                }
                if ($this->filterOutros) {
                    $subQuery->orWhereNotIn('porte', ['ME', 'EPP']);
                }
            });
        })
        ->when(!empty($this->filterBairros), function ($query) {
            $query->whereIn('endereco_bairro', $this->filterBairros);
        })
        ->when(!empty($this->filterMunicipios), function ($query) {
            $query->whereHas('municipio', function ($subQuery) {
                $subQuery->whereIn('city', $this->filterMunicipios);
            });
        })
        ->when(!empty($this->filterSetores), function ($query) {
            $query->whereIn('setor', $this->filterSetores);
        })
        ->when(!empty($this->filterSituacaoCadastral), function ($query) {
            $query->whereIn('situacaoCadastralRFB_descricao', $this->filterSituacaoCadastral);
        })
        ->when(!empty($this->filterCapitalSocial), function ($query) {
            $query->where(function ($subQuery) {
                foreach ($this->filterCapitalSocial as $filtro) {
                    if ($filtro === 'ate_100mil') {
                        $subQuery->orWhere('capitalSocial', '<=', 100000);
                    } elseif ($filtro === 'ate_1milhao') {
                        $subQuery->orWhereBetween('capitalSocial', [100000, 1000000]);
                    } elseif ($filtro === 'ate_100milhoes') {
                        $subQuery->orWhereBetween('capitalSocial', [1000000, 100000000]);
                    } elseif ($filtro === 'ate_1bilhao') {
                        $subQuery->orWhereBetween('capitalSocial', [100000000, 1000000000]);
                    } elseif ($filtro === 'acima_de_1bilhao') {
                        $subQuery->orWhere('capitalSocial', '>', 1000000000);
                    }
                }
            });
        })
        ->orderByRaw('CASE WHEN updated_at >= ? THEN 0 ELSE 1 END', [now()->subHour()])
        ->orderBy('updated_at', 'desc')
        ->paginate(10);

        return view('livewire.estabelecimentos-table', [
            'estabelecimentos' => $estabelecimentos,
        ]);
    }
}
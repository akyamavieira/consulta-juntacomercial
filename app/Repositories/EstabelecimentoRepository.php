<?php

namespace App\Repositories;

use App\Models\Estabelecimento;
use Illuminate\Support\Facades\Log;

class EstabelecimentoRepository
{
    public function updateOrCreate(array $data)
    {
        $cnpj = $data['cnpj'];
        $existingEstabelecimento = Estabelecimento::where('cnpj', $cnpj)->first();

        if ($existingEstabelecimento) {
            $existingEstabelecimento->update($data);
            \Log::info("Estabelecimento com CNPJ {$cnpj} atualizado.");
        } else {
            Estabelecimento::create($data);
            \Log::info("Novo Estabelecimento criado com CNPJ {$cnpj}.");
        }
    }

    public function getByIdentificador(string $identificador)
    {
        return Estabelecimento::where('identificador', $identificador)->first();
    }

    public function buscarEstabelecimentos(array $filters)
    {
        return Estabelecimento::where(function ($query) use ($filters) {
            $query->where('cnpj', 'ILIKE', '%' . $filters['query'] . '%')
                ->orWhere('nuInscricaoMunicipal', 'ILIKE', '%' . $filters['query'] . '%')
                ->orWhere('nomeEmpresarial', 'ILIKE', '%' . $filters['query'] . '%')
                ->orWhere('nomeFantasia', 'ILIKE', '%' . $filters['query'] . '%');
        })
            ->when($filters['filterME'] || $filters['filterEPP'] || $filters['filterOutros'], function ($query) use ($filters) {
                $query->where(function ($subQuery) use ($filters) {
                    if ($filters['filterME']) {
                        $subQuery->orWhere('porte', 'ME');
                    }
                    if ($filters['filterEPP']) {
                        $subQuery->orWhere('porte', 'EPP');
                    }
                    if ($filters['filterOutros']) {
                        $subQuery->orWhereNotIn('porte', ['ME', 'EPP']);
                    }
                });
            })
            ->when(!empty($filters['filterBairros']), function ($query) use ($filters) {
                $query->whereIn('endereco_bairro', $filters['filterBairros']);
            })
            ->when(!empty($filters['filterMunicipios']), function ($query) use ($filters) {
                $query->whereHas('municipio', function ($subQuery) use ($filters) {
                    $subQuery->whereIn('city', $filters['filterMunicipios']);
                });
            })
            ->when(!empty($filters['filterSetores']), function ($query) use ($filters) {
                $query->whereIn('setor', $filters['filterSetores']);
            })
            ->when(!empty($filters['filterSituacaoCadastral']), function ($query) use ($filters) {
                $query->whereIn('situacaoCadastralRFB_descricao', $filters['filterSituacaoCadastral']);
            })
            ->when(!empty($filters['filterCapitalSocial']), function ($query) use ($filters) {
                $query->where(function ($subQuery) use ($filters) {
                    foreach ($filters['filterCapitalSocial'] as $filtro) {
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
    }
    public function listarBairrosDisponiveis()
    {
        return Estabelecimento::distinct()->pluck('endereco_bairro')->toArray();
    }

    public function listarSetoresDisponiveis()
    {
        return Estabelecimento::distinct()->pluck('setor')->toArray();
    }

    public function listarSituacoesCadastraisDisponiveis()
    {
        return Estabelecimento::distinct()->pluck('situacaoCadastralRFB_descricao')->toArray();
    }

    public function buscarBairrosPorNome(string $search)
    {
        return Estabelecimento::whereRaw('LOWER(endereco_bairro) LIKE ?', ['%' . strtolower($search) . '%'])
            ->distinct()
            ->pluck('endereco_bairro')
            ->toArray();
    }

    public function buscarSetoresPorNome(string $search)
    {
        return Estabelecimento::whereRaw('LOWER(setor) LIKE ?', ['%' . strtolower($search) . '%'])
            ->distinct()
            ->pluck('setor')
            ->toArray();
    }

    public function buscarSituacoesCadastraisPorNome(string $search)
    {
        return Estabelecimento::whereRaw('LOWER("situacaoCadastralRFB_descricao") LIKE ?', ['%' . strtolower($search) . '%'])
            ->distinct()
            ->pluck('situacaoCadastralRFB_descricao')
            ->toArray();
    }
}
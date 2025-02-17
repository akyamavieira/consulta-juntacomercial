<?php

namespace App\Livewire;

use Livewire\Component;

class SearchComponent extends Component
{
    public $query = '';

    protected $listeners = ['resetSearch' => 'resetQuery'];

    /**
     * Normaliza o termo de pesquisa.
     *
     * @param string $term
     * @return string
     */
    protected function normalizeSearchTerm($term)
    {
        if (isCnpj($term)) {
            return unFormatCnpj($term); // Remove formatação do CNPJ
        }

        return cleanSpaceExterns($term); // Remove espaços externos e normaliza
    }

    /**
     * Emite o termo de pesquisa normalizado.
     */
    public function updatedQuery()
    {
        $normalizedQuery = $this->normalizeSearchTerm($this->query);
        $this->dispatch('searchUpdated', $normalizedQuery); // Emite o evento com o termo normalizado
    }

    /**
     * Reseta o termo de pesquisa.
     */
    public function resetQuery()
    {
        $this->query = '';
        $this->dispatch('searchUpdated', ''); // Emite o evento com um termo vazio
    }

    public function render()
    {
        return view('livewire.search-component');
    }
}
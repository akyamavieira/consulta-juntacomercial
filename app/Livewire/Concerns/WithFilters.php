<?php

namespace App\Livewire\Concerns;

trait WithFilters
{
    public $filterME = false;
    public $filterEPP = false;
    public $filterOutros = false;
    public $filterBairros = [];
    public $filterMunicipios = [];
    public $filterSetores = [];
    public $filterSituacaoCadastral = [];
    public $filterCapitalSocial = [];

    public function handleFilterUpdated($filter, $value)
    {
        if (property_exists($this, $filter)) {
            $this->$filter = is_array($value) ? $value : $value;
            $this->resetPage(); // Reset pagination if applicable
        }
    }

    public function clearAllFilters()
    {
        $this->filterME = false;
        $this->filterEPP = false;
        $this->filterOutros = false;
        $this->filterBairros = [];
        $this->filterMunicipios = [];
        $this->filterSetores = [];
        $this->filterSituacaoCadastral = [];
        $this->filterCapitalSocial = [];

        // Dispatch events for each filter
        foreach (['filterME', 'filterEPP', 'filterOutros', 'filterBairros', 'filterMunicipios', 'filterSetores', 'filterSituacaoCadastral', 'filterCapitalSocial'] as $filter) {
            $this->dispatch('filterUpdated', filter: $filter, value: $this->$filter);
        }
    }
}
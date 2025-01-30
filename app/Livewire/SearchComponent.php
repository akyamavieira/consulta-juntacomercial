<?php

namespace App\Livewire;

use Livewire\Component;

class SearchComponent extends Component
{
    public $search = '';

    public function searchByTerm(){
        if (isCnpj($this->search)) {
            $normalizeTherme = unFormatCnpj($this->search);
        } else {
            $normalizeTherme = cleanSpaceExterns($this->search);
        }
        $this->dispatch('searchByTerm', therme: $normalizeTherme);
    }

    public function render(){
        return view('livewire.search-component');
    }
}

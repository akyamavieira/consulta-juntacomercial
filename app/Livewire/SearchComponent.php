<?php

namespace App\Livewire;

use Livewire\Component;

class SearchComponent extends Component
{
    public $search = '';

    public function searchByCnpj(){
        $this->dispatch('searchByCnpj', therme: $this->search);
    }

    public function render(){
        return view('livewire.search-component');
    }
}

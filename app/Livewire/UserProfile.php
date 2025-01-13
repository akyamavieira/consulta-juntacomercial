<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Session; // Para usar `session()`
use Livewire\Component;

class UserProfile extends Component
{
    public $user;

    public function mount()
    {
        $this->user = session('loggedUser'); // Obtém os dados unificados da sessão
         // Extrai o primeiro nome do nome completo
        if (isset($this->user['name'])) {
            $this->user['name'] = explode(' ', $this->user['name'])[0]; // Pega o primeiro nome
    }
    }

    public function render()
    {
        return view('livewire.user-profile');
    }
}
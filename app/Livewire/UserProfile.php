<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Session; // Para usar `session()`
use Livewire\Component;

class UserProfile extends Component
{
    public $firstName;

    public function mount()
    {
        $user = session('user'); // Obtém os dados unificados da sessão
        // Extrai o primeiro nome do nome completo
        // Verifica se o nome existe e extrai o primeiro nome
        if (isset($user['name'])) {
            $this->firstName = explode(' ', $user['name'])[0]; // Pega o primeiro nome
        } else {
            $this->firstName = null;
        }
    }

    public function render()
    {
        return view('livewire.user-profile');
    }
}
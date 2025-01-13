<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Auth;
use App\Traits\HandlesLogout;

class Logout extends Component
{
    use HandlesLogout;
    
    public function logout()
    {
        // Limpa a sessão e cookies usando a trait
        $this->clearAuthSession();
        // Redirecionar para a página de login (ou outra página desejada)
        return redirect()->route('login');
    }

    public function render()
    {
        return view('livewire.logout');
    }
}

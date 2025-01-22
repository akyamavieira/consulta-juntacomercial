<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Session;

class Logout extends Component
{
    
    public function logout()
    {
        // Remover o usuário da sessão
        Session::forget('user');
        Session::invalidate();
        return redirect('/');
    }

    public function render()
    {
        return view('livewire.logout');
    }
}

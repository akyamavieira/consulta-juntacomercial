<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class Logout extends Component
{
    
    public function logout(Request $request)
    {
        // Remove o usuário da sessão
        Session::forget('user');
        Session::invalidate();
    
        // URL de logout do Keycloak
        $keycloakLogoutUrl = sprintf(
            'https://lus-homolog.rr.sebrae.com.br/realms/sebrae-corporate-homolog/protocol/openid-connect/logout?redirect_uri=%s',
            urlencode(route('index')) // Redireciona para a página inicial após o logout
        );
    
        return redirect($keycloakLogoutUrl);
    }
    public function render()
    {
        return view('livewire.logout');
    }
}

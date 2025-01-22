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

        // URL absoluta para redirecionar após o logout
        $redirectUri = 'https://consulta-jucerr-homolog.rr.sebrae.com.br';

        // URL de logout do Keycloak
        $keycloakLogoutUrl = sprintf(
            'https://lus-homolog.rr.sebrae.com.br/realms/sebrae-corporate-homolog/protocol/openid-connect/logout?redirect_uri=%s',
            urlencode($redirectUri) // Substitua pela URL absoluta
        );

        return redirect($keycloakLogoutUrl);
    }
    public function render()
    {
        return view('livewire.logout');
    }
}

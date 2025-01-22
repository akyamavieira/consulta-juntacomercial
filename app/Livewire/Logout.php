<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class Logout extends Component
{

    public function logout(Request $request)
    {
        $idToken = Session::get('id_token');
        // Remove o usuário da sessão
        Session::forget('user');
        Session::forget('id_token');
        Session::invalidate();

        // URL absoluta para redirecionar após o logout
        $redirectUri = 'https://consulta-jucerr-homolog.rr.sebrae.com.br';

        // URL de logout do Keycloak com id_token_hint
        $keycloakLogoutUrl = sprintf(
            'https://lus-homolog.rr.sebrae.com.br/realms/sebrae-corporate-homolog/protocol/openid-connect/logout?id_token_hint=%s&post_logout_redirect_uri=%s',
            urlencode($idToken), // Inclui o ID Token
            urlencode($redirectUri) // Codifica a URL de redirecionamento
        );


        return redirect()->away($keycloakLogoutUrl);
    }
    public function render()
    {
        return view('livewire.logout');
    }
}

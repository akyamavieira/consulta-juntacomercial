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

        // Defina o redirecionamento conforme o padrão aceito pelo Keycloak
        $postLogoutRedirectUri = 'https://consulta-jucerr-homolog.rr.sebrae.com.br';

        // Construa a URL de logout do Keycloak com o parâmetro correto
        $keycloakLogoutUrl = sprintf(
            'https://lus-homolog.rr.sebrae.com.br/realms/sebrae-corporate-homolog/protocol/openid-connect/logout?post_logout_redirect_uri=%s&client_id=%s',
            urlencode($postLogoutRedirectUri), // Deve corresponder ao padrão configurado no Keycloak
            'consulta-jucerr' // Substitua pelo Client ID correto
        );

        // Redireciona para o logout do Keycloak
        return redirect($keycloakLogoutUrl);
    }
    public function render()
    {
        return view('livewire.logout');
    }
}

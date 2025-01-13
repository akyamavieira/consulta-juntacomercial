<?php

namespace App\Traits;

use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Auth;

trait HandlesLogout
{
    /**
     * Remove os cookies de autenticação e realiza logout.
     *
     * @return void
     */
    public function clearAuthSession()
    {
        // Remove os cookies de autenticação
        Cookie::queue(Cookie::forget('CID')); // Remove o token LDAP
        Cookie::queue(Cookie::forget('AMCID')); // Remove o token Keycloak

        // Realiza o logout do usuário (se estiver usando autenticação Laravel)
        Auth::logout();
    }
}

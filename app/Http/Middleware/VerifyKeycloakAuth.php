<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class VerifyKeycloakAuth
{
    /**
     * Rotas que devem ser ignoradas pelo middleware.
     *
     * @var array
     */
    protected $except = [
        'login',
        'callback',
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Verifica se a rota atual está na lista de exceções
        if ($this->shouldPassThrough($request)) {
            return $next($request);
        }
        // dd(Session::get('user'));
        // Lógica de autenticação
        if (!Session::has('user')) {
            // Redireciona para a rota de login
            return redirect()->route('login');
        }
        return $next($request);
    }

    /**
     * Verifica se a rota deve passar pelo middleware.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function shouldPassThrough(Request $request): bool
    {
        // Verifica se a rota está presente antes de tentar acessar o nome
        $routeName = $request->route() ? $request->route()->getName() : null;

        return in_array($routeName, $this->except);
    }
}
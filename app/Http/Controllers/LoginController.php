<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login()
    {
        // Exibe a página de login
        return view('pages.login');
    }
}

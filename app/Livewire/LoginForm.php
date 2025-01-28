<?php

namespace App\Livewire;

use Livewire\Component;


class LoginForm extends Component
{

    public function login()
    {
        return redirect()->route('index');
    }

    public function render()
    {
        return view('livewire.login-form');
    }
}
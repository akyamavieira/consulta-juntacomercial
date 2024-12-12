<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EstabelecimentosController;
use App\Livewire\Counter;
 


Route::get('/', [EstabelecimentosController::class, 'index']);

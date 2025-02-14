<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\EstabelecimentosController;

Route::get('/estabelecimentos/all', [EstabelecimentosController::class, 'getAll']);

Route::get('/estabelecimentos/byYear', [EstabelecimentosController::class, 'aggregateByYear']);
Route::get('/estabelecimentos/bySemester', [EstabelecimentosController::class, 'aggregateBySemester']);
Route::get('/estabelecimentos/byMonth', [EstabelecimentosController::class, 'aggregateByMonth']);
Route::get('/estabelecimentos/byWeek', [EstabelecimentosController::class, 'aggregateByWeek']);
Route::get('/estabelecimentos/byDay', [EstabelecimentosController::class, 'aggregateByDay']);

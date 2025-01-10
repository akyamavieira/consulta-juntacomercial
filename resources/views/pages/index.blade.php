@extends('layouts.app')

@section('head')
@include('sections.head')
@endsection

@section('navbar')

@endsection

@section('content')
<h1 class="text-2xl font-semibold flex items-center justify-center">Empresas Recentemente Cadastradas
ou Atualizadas</h1>
<div>
    @livewire('estabelecimentos-table')
</div>
@endsection
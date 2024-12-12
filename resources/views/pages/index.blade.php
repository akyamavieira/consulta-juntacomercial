@extends('layouts.app')

@section('head')
@include('sections.head')
@endsection

@section('navbar')

@endsection

@section('content')
<div>
    <h1>Lista de Estabelecimentos</h1>
    @livewire('estabelecimentos-table')
</div>
@endsection
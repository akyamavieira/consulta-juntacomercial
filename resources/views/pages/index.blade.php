@extends('layouts.app')

@section('head')
@include('sections.head')
@endsection

@section('navbar')

@endsection

@section('content')
<div>
    @livewire('estabelecimentos-table')
</div>
@endsection
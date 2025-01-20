@extends('layouts.app')

@section('head')
@include('sections.head')
@endsection

@section('navbar')
<header>
    <!-- Navbar -->
    <nav
        class="bg-white fixed w-full top-0 left-0 flex items-center justify-between h-20 border-l-12 border-r-12 border-transparent px-12 shadow-md z-10">
        <!-- Avatar e nome do usuário (lado esquerdo) -->
        <div class="flex items-center gap-4 relative cursor-pointer">
            @livewire('profile-dropdown')
            <div class="font-medium">
                @livewire('user-profile')
            </div>
        </div>
        <!-- Logo (lado direito) em md e acima -->
        <div class="flex-shrink-0 flex items-center mr-2 hidden lg:block">
            @livewire('logo')
        </div>
    </nav>
</header>
@endsection

@section('content')
<h1 class="text-2xl font-semibold flex items-center justify-center text-center pt-24 pb-4">Empresas Recentemente Cadastradas
    ou Atualizadas</h1>
<div>
    @livewire('estabelecimentos-table')
    @livewire('estabelecimento-detalhes')
</div>
@endsection
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
            <!-- Search Component (tamanho original) -->
            <div class="absolute left-1/2 transform -translate-x-1/2">
                <div class="flex items-center gap-2">
                    @livewire('search-component')
                    @livewire('export-to-excel')
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

    <body class="flex bg-[#F5F7FB]">
        <!-- <div class="w-64 h-screen bg-gray-200 p-4 shadow-md mt-20">
                <h2 class="text-xl font-semibold mb-4">Filtros</h2>
            </div> -->
        <div class="flex-1 p-6">
            <h1 class="text-2xl font-semibold flex items-center justify-center text-center pt-24 pb-4">Empresas Recentemente
                Cadastradas ou Atualizadas</h1>
            <div>
                @livewire('estabelecimentos-table')
                @livewire('estabelecimento-detalhes')
            </div>
            <!-- Gráfico -->
            <h1 class="text-2xl font-semibold flex items-center justify-center text-center mt-4 pb-4">Estatíticas sobre
                Empresas 2025</h1>
            <div class="flex flex-wrap justify-center space-x-4">
                <div class="w-[400px] h-[250px] rounded-[15px] shadow-gray-500 shadow-md p-2.5">
                    <h1 class="text-center">Estabelecimentos Criados Por Ano</h1>
                    <canvas id="chartByYear" class="w-full h-full"></canvas>
                </div>
                <div class="w-[400px] h-[430px] rounded-[15px] shadow-gray-500 shadow-md p-2.5">
                    <h1 class="text-center">Estabelecimentos Criados Por Mês</h1>
                    <canvas id="chartByMonth" class="w-full h-full"></canvas>
                </div>
            </div>
            <div class="w-[820px] h-[440px] mx-auto rounded-[15px] shadow-gray-500 shadow-md p-2.5 mt-4">
                <h1 class="text-center">Estabelecimentos Criados Por Dias</h1>
                <canvas id="chartByDay" class="w-full h-full"></canvas>
            </div>
        </div>
    </body>
@endsection
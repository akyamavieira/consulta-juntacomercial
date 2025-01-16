@extends('layouts.app')

@section('head')
@include('sections.head')
@endsection

@section('content')
<main class="bg-gray-50 flex flex-col items-center justify-center min-h-screen">
  <!-- Logo centralizada -->
  <div class="mt-5 flex justify-center mb-2">
    @livewire('logo')
  </div>

  <div
    class="relative mx-auto w-full max-w-md bg-white px-6 pt-10 pb-8 shadow-xl ring-1 ring-gray-900/5 sm:rounded-xl sm:px-10">
    <div class="w-full">
      <div class="text-center">
        <h1 class="text-3xl font-semibold text-gray-900">Login</h1>
        <p class="mt-2 text-gray-500">Insira seus dados para acessar sua Conta Local</p>
      </div>
      <div class="mt-5">
        @livewire('login-form')
      </div>
    </div>
  </div>
</main>
@endsection
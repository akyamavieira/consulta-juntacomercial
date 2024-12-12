<!DOCTYPE html>
<html lang="pt-BR">

@yield('head')
@livewireStyles
<body>
    @yield('navbar')

    @yield('content')

    @yield('footer')
    @vite('resources/js/app.js')
    @livewireScripts
</body>
</html>

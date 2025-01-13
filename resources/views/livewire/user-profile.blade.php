<div>
    @if ($user && isset($user['name']))
        <div>{{ $user['name'] }}</div>
    @else
        <p>Usuário não encontrado.</p>
    @endif
</div>

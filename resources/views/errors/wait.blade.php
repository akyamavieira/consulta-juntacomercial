<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aguarde</title>
    <script>
        // Inicializar contador com o tempo restante (em segundos)
        let waitTime = {{ request()->get('waitTime') }};
        // Definindo a URL da rota para redirecionamento
        const redirectUrl = "{{ route('index') }}"; // Ajuste para o nome da sua rota

        function startCountdown() {
            const countdownElement = document.getElementById('countdown');
            const interval = setInterval(() => {
                if (waitTime <= 0) {
                    clearInterval(interval);
                    countdownElement.innerHTML = "Você já pode realizar uma nova requisição.";

                    // Redirecionar automaticamente para a tela principal após o countdown
                    setTimeout(() => {
                        window.location.href = redirectUrl; // Redireciona para a rota da tela principal
                    }, 1000); // Espera 1 segundo antes de redirecionar
                } else {
                    const minutes = Math.floor(waitTime / 60);
                    const seconds = waitTime % 60;
                    countdownElement.innerHTML = `Aguarde ${minutes} minuto(s) e ${seconds} segundo(s).`;
                    waitTime--;
                }
            }, 1000);
        }
        window.onload = startCountdown;
    </script>
</head>
<body>
    <div style="text-align: center; margin-top: 20px;">
        <h1>Você atingiu o limite de requisições.</h1>
        <p id="countdown"></p>
        <p>Próxima tentativa permitida às {{ request()->get('nextRequestTime') }}.</p>
    </div>
</body>
</html>

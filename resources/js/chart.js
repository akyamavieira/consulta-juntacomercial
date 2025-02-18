import Chart from 'chart.js/auto';

document.addEventListener("DOMContentLoaded", async function () {
    const canvas = document.getElementById('estabelecimentosChart');
    const ctx = canvas.getContext('2d');

    // Definir a largura e a altura do canvas em pixels
    canvas.width = 400;
    canvas.height = 400;

    try {
        const response = await fetch('/api/estabelecimentos/byYear');
        const data = await response.json();

        // Filtrar os dados para incluir apenas os anos a partir de 2010
        const filteredData = data.filter(item => item.ano >= 2010);

        // Ordenar os dados por ano
        filteredData.sort((a, b) => a.ano - b.ano);

        const anos = filteredData.map(item => item.ano);
        const totais = filteredData.map(item => item.total);

        // Encontrar o índice do maior valor
        const maxIndex = totais.indexOf(Math.max(...totais));

        // Definir as cores, destacando a barra com o maior número
        const backgroundColors = totais.map((total, index) => index === maxIndex ? 'rgba(255, 99, 132, 1)' : 'rgba(54, 162, 235, 1)');
        const borderColors = totais.map((total, index) => index === maxIndex ? 'rgba(255, 99, 132, 1)' : 'rgba(54, 162, 235, 1)');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: anos,
                datasets: [{
                    label: 'Total de Estabelecimentos',
                    data: totais,
                    backgroundColor: backgroundColors,
                    borderColor: borderColors,
                    borderWidth: 0, // Remover o stroke das barras
                    borderRadius: 10, // Adicionar border radius de 10px
                }]
            },
            options: {
                responsive: true,
                indexAxis: 'y', // Define o gráfico como horizontal
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            font: {
                                family: 'Poppins', // Definir a fonte para 'Poppins'
                                weight: 'bold' // Definir a fonte como negrito
                            }
                        }
                    }
                },
                plugins: {
                    legend: {
                        labels: {
                            font: {
                                family: 'Poppins', // Definir a fonte para 'Poppins'
                                weight: 'bold' // Definir a fonte como negrito
                            }
                        }
                    }
                },
                devicePixelRatio: 4 // Adicionar devicePixelRatio para melhorar a resolução
            }
        });
    } catch (error) {
        console.error("Erro ao carregar os dados do gráfico:", error);
    }
});
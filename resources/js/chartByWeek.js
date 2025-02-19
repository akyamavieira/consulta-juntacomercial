import Chart from 'chart.js/auto';


document.addEventListener("DOMContentLoaded", async function () {
    const canvas = document.getElementById('chartByDay');
    const ctx = canvas.getContext('2d');

    try {
        const response = await fetch('/api/estabelecimentos/byDay');
        const result = await response.json();
        const data = result.data; // Acessar a chave 'data' do resultado

        // Função para formatar a data no formato ddMMYYYY
        const formatDate = (dateString) => {
            const date = new Date(dateString);
            const day = String(date.getDate()).padStart(2, '0');
            const month = String(date.getMonth() + 1).padStart(2, '0'); // Janeiro é 0
            const year = date.getFullYear();
            return `${day}/${month}/${year}`;
        };

        // Mapear os dados para os últimos 7 dias
        const dias = data.map(item => formatDate(item.data.dia));
        const totais = data.map(item => item.data.total);

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: dias,
                datasets: [{
                    label: 'Total de Empresas Abertas',
                    data: totais,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1,
                    fill: true, // Preencher a área abaixo da linha
                    pointBackgroundColor: 'rgba(54, 162, 235, 1)',
                    pointBorderColor: 'rgba(54, 162, 235, 1)',
                    pointRadius: 3
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            font: {
                                family: 'Poppins', // Definir a fonte para 'Poppins'
                                weight: 'bold' // Definir a fonte como negrito
                            }
                        }
                    },
                    x: {
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
                }
            }
        });
    } catch (error) {
        console.error("Erro ao carregar os dados do gráfico:", error);
    }
});
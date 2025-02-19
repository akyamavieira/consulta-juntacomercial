import Chart from 'chart.js/auto';
import annotationPlugin from 'chartjs-plugin-annotation';

Chart.register(annotationPlugin);

async function fetchEstabelecimentos() {
    try {
        const response = await fetch('/api/estabelecimentos/byMonthRange');
        const data = await response.json();

        // Criar um objeto para somar os valores por mês
        const meses = {
            1: 0, 2: 0, 3: 0, 4: 0, 5: 0, 6: 0,
            7: 0, 8: 0, 9: 0, 10: 0, 11: 0, 12: 0
        };

        // Somar todos os valores de cada mês
        data.forEach(item => {
            meses[item.mes] += item.total;
        });

        // Labels dos meses
        const labels = [
            'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 
            'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'
        ];

        // Valores correspondentes a cada mês
        const valores = Object.values(meses);

        // Identificar o índice da maior fatia
        const maxIndex = valores.indexOf(Math.max(...valores));

        // Cores definidas com base na psicologia das cores
        const cores = [
            "#1E3A5F", "#C2185B", "#2E7D32", "#F4A236", "#A41D34", "#FFEB3B",
            "#0D47A1", "#9C27B0", "#4CAF50", "#F57C00", "#795548", "#D50000"
        ];

        // Criar um array de offsets, aplicando 10% de deslocamento para a maior fatia
        const offsets = valores.map((_, index) => (index === maxIndex ? 30 : 0));

        // Total geral
        const totalGeral = valores.reduce((acc, val) => acc + val, 0);
        console.log(totalGeral.toString());

        // Criar o gráfico
        const ctx = document.getElementById('chartByMonth').getContext('2d');
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: labels,
                datasets: [
                    {
                        data: valores,
                        backgroundColor: cores,
                        offset: offsets, // Aplica o deslocamento na maior fatia
                    },
                ],   
            },
            options: {
                plugins: {
                    annotation: {
                        annotations: {
                            dLabel: {
                                type: 'doughnutLabel',
                                content: ({chart}) => [`${totalGeral.toString()}`, 'Total'],
                                font: [
                                    {size: 40, family: 'Poppins', weight: '700', lineHeight: 1}, 
                                    {size: 20, family: 'Poppins', lineHeight: 0.9}
                                ],
                                color: ['black', 'grey']
                            }
                        }
                    }
                }
            }
        });

    } catch (error) {
        console.error('Erro ao buscar os dados:', error);
    }
}

fetchEstabelecimentos();

import Chart from 'chart.js/auto';
import annotationPlugin from 'chartjs-plugin-annotation';

Chart.register(annotationPlugin);

async function fetchEstabelecimentos() {
    try {
        const response = await fetch('/api/estabelecimentos/byMonthRange');
        if (!response.ok) {
            throw new Error('Erro ao buscar os dados');
        }
        const data = await response.json();

        const meses = {
            1: 0, 2: 0, 3: 0, 4: 0, 5: 0, 6: 0,
            7: 0, 8: 0, 9: 0, 10: 0, 11: 0, 12: 0
        };

        data.forEach(item => {
            meses[item.mes] += item.total;
        });

        const labels = [
            'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 
            'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'
        ];

        const valores = Object.values(meses);
        const maxIndex = valores.indexOf(Math.max(...valores));

        const cores = [
            "#1E3A5F", "#C2185B", "#2E7D32", "#F4A236", "#A41D34", "#FFEB3B",
            "#0D47A1", "#9C27B0", "#4CAF50", "#F57C00", "#795548", "#D50000"
        ];

        const offsets = valores.map((_, index) => (index === maxIndex ? 30 : 0));
        const totalGeral = valores.reduce((acc, val) => acc + val, 0);
        console.log(totalGeral.toString());

        const ctx = document.getElementById('chartByMonth');
        if (ctx) {
            new Chart(ctx.getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            data: valores,
                            backgroundColor: cores,
                            offset: offsets,
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
                    },
                    // Adicione a configuração global da fonte aqui
                    font: {
                        family: 'Poppins',
                        size: 12,
                        weight: 'normal',
                        lineHeight: 1.2
                    }
                }
            });
        } else {
            console.error('Elemento chartByMonth não encontrado');
        }

    } catch (error) {
        console.error('Erro ao buscar os dados:', error);
    }
}

fetchEstabelecimentos();
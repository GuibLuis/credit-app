function processOffersData(offers, chart) {
    // agrupa os dados por instituição
    const groupedData = {};
    const modalities = new Set();

    // coleta todas as modalidades únicas e agrupa os dados por instituição
    $.each(offers, function (instituicao, value) {
        if (!groupedData[instituicao]) {
            groupedData[instituicao] = {};
        }

        $.each(value, function (modalidade, data) {
            modalities.add(modalidade);
            groupedData[instituicao][modalidade] =
                chart === "jurosMes" ? data[chart] * 100 : data[chart];
        });
    });

    // converte o set para um array para ser usado como labels
    const modalityLabels = Array.from(modalities);

    // processamento de dados
    const datasets = modalityLabels.map((modalidade) => ({
        label: modalidade,
        data: Object.keys(groupedData).map(
            (instituicao) => groupedData[instituicao][modalidade] || 0
        ),
        borderWidth: 1,
    }));

    return { groupedData, datasets };
}

// função para renderizar um novo gráfico padronizado
function newChart(chart, groupedData, datasets, xlabel, title) {
    const existingChart = Chart.getChart(chart);
    if (existingChart) {
        existingChart.destroy();
    }

    new Chart(chart, {
        type: "bar",
        data: {
            labels: Object.keys(groupedData),
            datasets: datasets,
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: "Instituições",
                    },
                },
                x: {
                    title: {
                        display: true,
                        text: xlabel,
                    },
                },
            },
            indexAxis: "y",
            plugins: {
                title: {
                    display: true,
                    text: title,
                },
            },
        },
    });
}

window.renderOffersChartJuros = function (offers) {
    const offersChartJuros = $("#offers_chart-juros");
    const { groupedData, datasets } = processOffersData(offers, "jurosMes");

    newChart(
        offersChartJuros,
        groupedData,
        datasets,
        "% de Juros por mês",
        "Comparativo de Juros por mês"
    );
};

window.renderOffersChartValor = function (offers) {
    const offersChartValor = $("#offers_chart-valor");
    const { groupedData, datasets } = processOffersData(offers, "valorMin");

    newChart(
        offersChartValor,
        groupedData,
        datasets,
        "Valor mínimo",
        "Comparativo de Valor mínimo"
    );
};

var bestOffersEx = [
    {
        instituicaoFinanceira: "Banco do Brasil",
        modalidadeCredito: "Crédito Consignado",
        valorAPagar: 1000,
        valorSolicitado: 1000,
        valorParcela: 100,
        taxaJuros: 0.01,
        qntParcelas: 12,
    },
    {
        instituicaoFinanceira: "Banco do BB",
        modalidadeCredito: "Crédito Consignado",
        valorAPagar: 1500,
        valorSolicitado: 1500,
        valorParcela: 150,
        taxaJuros: 0.015,
        qntParcelas: 16,
    },
];

window.renderBestOffersChart = function (offers) {
    const bestOffersChart = $("#best_offers-chart");
    const existingChart = Chart.getChart(bestOffersChart);
    if (existingChart) {
        existingChart.destroy();
    }

    const data = [];
    const labels = [];
    // processar os dados
    $.each(offers, function (count, value) {
        labels.push(value.instituicaoFinanceira + " - " + value.modalidadeCredito);
        data.push(value.valorAPagar);
    });

    new Chart(bestOffersChart, {
        type: "pie",
        data: {
            labels: labels,
            datasets: [{
                data: data,
            }]
        },
        options: {
            plugins: {
                title: {
                    display: true,
                    text: "Comparativo de Valor a Pagar",
                },
            },
        },
    });
};
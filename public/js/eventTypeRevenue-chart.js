// REVENUE BY EVENT TYPE CHART 
if (typeof eventTypeLabels !== 'undefined' && typeof eventTypeData !== 'undefined') {
    
    const ctx = document.getElementById('eventTypeChart');
    if (ctx) {
        const chart = new Chart(ctx.getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: eventTypeLabels,
                datasets: [{
                    data: eventTypeData,
                    backgroundColor: [
                        'rgba(59, 130, 246, 1)',
                        'rgba(99, 179, 237, 1)',
                        'rgba(147, 197, 253, 1)',
                        'rgba(191, 219, 254, 1)',
                        'rgba(224, 242, 254, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right',
                        labels: {
                            usePointStyle: true,
                            generateLabels: function(chart) {
                                const data = chart.data;
                                if (data.labels.length && data.datasets.length) {
                                    const currencyFormatter = new Intl.NumberFormat('en-PH', {
                                        style: 'currency',
                                        currency: 'PHP',
                                        minimumFractionDigits: 2
                                    });

                                    return data.labels.map(function(label, i) {
                                        const meta = chart.getDatasetMeta(0);
                                        const style = meta.controller.getStyle(i);
                                        return {
                                            text: label + ' — ' + currencyFormatter.format(data.datasets[0].data[i]),
                                            fillStyle: style.backgroundColor,
                                            strokeStyle: style.borderColor,
                                            lineWidth: style.borderWidth,
                                            pointStyle: 'circle',
                                            hidden: !chart.getDataVisibility(i),
                                            index: i
                                        };
                                    });
                                }
                                return [];
                            }
                        }
                    }
                }
            }
        });
    }
}

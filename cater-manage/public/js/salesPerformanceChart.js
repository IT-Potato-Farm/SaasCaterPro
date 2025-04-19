document.addEventListener('DOMContentLoaded', function () {
    const chartData = window.salesPerformanceData || [];

    const labels = ['4 weeks ago', '3 weeks ago', '2 weeks ago', '1 week ago', 'This week'];

    const ctx = document.getElementById('salesPerformanceChart');
    if (!ctx) return;

    new Chart(ctx.getContext('2d'), {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Sales',
                data: chartData,
                backgroundColor: 'rgba(59, 130, 246, 0.8)',
                borderRadius: 8,
                barThickness: 40
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            },
            plugins: {
                legend: { display: false }
            }
        }
    });
});

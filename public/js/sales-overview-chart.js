const chartColors = {
    thisYear: "#3B82F6",
    lastYear: "#E5E7EB",
    gridY: "#F3F4F6",
    tickText: "#6B7280",
    tooltipBg: "#1F2937",
    tooltipBorder: "#374151",
    tooltipText: "#F9FAFB",
};
document.addEventListener("DOMContentLoaded", function() {
const ctx = document.getElementById("salesOverviewChart").getContext("2d");

// Initialize chart with default data (Year)
window.salesOverviewChart = new Chart(ctx, {
    type: "line",
    data: {
        labels: [
            "Jan",
            "Feb",
            "Mar",
            "Apr",
            "May",
            "Jun",
            "Jul",
            "Aug",
            "Sep",
            "Oct",
            "Nov",
            "Dec",
        ],
        datasets: [
            {
                label: "This Year",
                data: chartDataSets.year,
                borderColor: chartColors.thisYear,
                borderWidth: 2,
                tension: 0.4,
                fill: true,
                backgroundColor: "rgba(59, 130, 246, 0.05)",
                pointRadius: 4,
                pointHoverRadius: 6,
                pointBackgroundColor: "#fff",
                pointBorderColor: chartColors.thisYear,
            },
        ],
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true,
                grid: { color: chartColors.gridY },
                ticks: {
                    callback: function (value) {
                        return new Intl.NumberFormat("en-PH", {
                            style: "currency",
                            currency: "PHP",
                            minimumFractionDigits: 0,
                        }).format(value);
                    },
                    color: chartColors.tickText,
                },
            },
            x: {
                grid: { display: false },
                ticks: { color: chartColors.tickText },
            },
        },
        plugins: {
            legend: { display: false },
            tooltip: {
                backgroundColor: chartColors.tooltipBg,
                titleColor: chartColors.tooltipText,
                bodyColor: chartColors.tooltipText,
                borderColor: chartColors.tooltipBorder,
                borderWidth: 1,
                padding: 12,
                usePointStyle: true,
                callbacks: {
                    label: function (context) {
                        let value = context.raw || 0;
                        return (
                            context.dataset.label +
                            ": " +
                            new Intl.NumberFormat("en-PH", {
                                style: "currency",
                                currency: "PHP",
                                minimumFractionDigits: 0,
                            }).format(value)
                        );
                    },
                },
            },
        },
    },
});

// Filter Function
window.filterChartSales = function(range) {
    const newData = chartDataSets[range];

    if (!newData) {
        alert("No data for this range.");
        return;
    }

    // Update data and label
    window.salesOverviewChart.data.datasets[0].data = newData;
    window.salesOverviewChart.data.datasets[0].label =
        range === "today"
            ? "Today"
            : range === "month"
            ? "This Month"
            : range === "year"
            ? "This Year"
            : "Last Year";
    window.salesOverviewChart.update();
}
});
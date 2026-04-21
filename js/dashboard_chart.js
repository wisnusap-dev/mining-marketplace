document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('canvasChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: chartLabels,
            datasets: [{
                label: 'Pesanan',
                data: chartData,
                borderColor: '#d4aa61',
                backgroundColor: 'rgba(212, 170, 97, 0.1)',
                fill: true,
                tension: 0.4,
                borderWidth: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1 } }
            }
        }
    });
});document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('canvasChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: chartLabels,
            datasets: [{
                label: 'Pesanan',
                data: chartData,
                borderColor: '#d4aa61',
                backgroundColor: 'rgba(212, 170, 97, 0.1)',
                fill: true,
                tension: 0.4,
                borderWidth: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1 } }
            }
        }
    });
});
document.addEventListener('DOMContentLoaded', function () {
  const canvas = document.getElementById('canvasChart');
  if (!canvas) return;

  const ctx = canvas.getContext('2d');

  new Chart(ctx, {
    type: 'line',
    data: {
      labels: chartLabels,
      datasets: [{
        label: 'Pesanan',
        data: chartData,
        borderColor: '#d4aa61',
        backgroundColor: 'rgba(212, 170, 97, 0.08)',
        fill: true,
        tension: 0.45,
        borderWidth: 3,
        pointBackgroundColor: '#d4aa61',
        pointBorderColor: '#fff',
        pointBorderWidth: 2,
        pointRadius: 5,
        pointHoverRadius: 7,
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      animation: {
        duration: 1000,
        easing: 'easeInOutQuart',
      },
      plugins: {
        legend: { display: false },
        tooltip: {
          backgroundColor: '#2c1a0e',
          titleColor: '#d4aa61',
          bodyColor: '#fff',
          padding: 12,
          borderColor: '#d4aa61',
          borderWidth: 1,
          callbacks: {
            label: ctx => ' ' + ctx.parsed.y + ' pesanan',
          }
        }
      },
      scales: {
        x: {
          grid: { display: false },
          ticks: { color: '#999', font: { size: 12 } }
        },
        y: {
          beginAtZero: true,
          grid: { color: 'rgba(0,0,0,0.04)' },
          ticks: { stepSize: 1, color: '#999', font: { size: 12 } }
        }
      }
    }
  });
});

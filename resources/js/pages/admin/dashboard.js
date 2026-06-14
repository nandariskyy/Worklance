document.addEventListener('DOMContentLoaded', function() {
    // Chart Distribusi Kategori
    const ctxKategoriEl = document.getElementById('kategoriChart');
    if (ctxKategoriEl) {
        const ctxKategori = ctxKategoriEl.getContext('2d');
        let chartData = [];
        try {
            chartData = JSON.parse(ctxKategoriEl.dataset.chart || '[]');
        } catch (e) {
            console.error(e);
        }
        
        const labels = chartData.map(item => item.nama_kategori);
        const data = chartData.map(item => item.total);
        
        new Chart(ctxKategori, {
            type: 'doughnut',
            data: {
                labels: labels,
                datasets: [{
                    data: data,
                    backgroundColor: [
                        '#FF6B00', '#F9A826', '#4CAF50', '#2196F3', '#9C27B0'
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            color: '#ffffff',
                            font: {
                                family: "'Inter', sans-serif",
                                size: 12
                            },
                            usePointStyle: true,
                            padding: 20
                        }
                    }
                },
                cutout: '70%'
            }
        });
    }

    // Chart Booking Per Bulan
    const ctxBookingEl = document.getElementById('bookingBulanChart');
    if (ctxBookingEl) {
        let bookingBulanData = [];
        try {
            bookingBulanData = JSON.parse(ctxBookingEl.dataset.chart || '[]');
        } catch (e) {
            console.error(e);
        }
        
        new Chart(ctxBookingEl.getContext('2d'), {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                datasets: [{
                    label: 'Jumlah Booking',
                    data: bookingBulanData,
                    borderColor: '#2196F3',
                    backgroundColor: 'rgba(33, 150, 243, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#2196F3',
                    pointRadius: 4,
                    pointHoverRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: { beginAtZero: true, ticks: { stepSize: 1 } },
                    x: { grid: { display: false } }
                }
            }
        });
    }
});

window.openDetailModal = function(fl) {
    document.getElementById('detail_avatar').innerText = (fl.nama_pengguna || 'F').substring(0, 1).toUpperCase();
    document.getElementById('detail_nama_pengguna').innerText = fl.nama_pengguna;
    document.getElementById('detail_email').innerText = fl.email;
    document.getElementById('detail_id').innerText = fl.id_layanan;
    document.getElementById('detail_kategori').innerText = fl.kategori || '-';
    document.getElementById('detail_no_telp').innerText = fl.no_telp || '-';
    document.getElementById('detail_status').innerText = fl.status || 'Aktif';
    
    if (typeof window.openModal === 'function') {
        window.openModal('modalDetail');
    }
};

document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('kategoriFreelancerChart');
    if (!ctx) return;
    
    let rawData = [];
    try {
        rawData = JSON.parse(ctx.dataset.chart || '[]');
    } catch (e) {
        console.error(e);
    }
    
    const labels = rawData.map(item => item.nama_kategori);
    const data = rawData.map(item => item.total);
    
    new Chart(ctx.getContext('2d'), {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Jumlah Freelancer',
                data: data,
                backgroundColor: '#FF6B00',
                borderRadius: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1 } },
                x: { grid: { display: false } }
            }
        }
    });
});

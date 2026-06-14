window.openEditJasaModal = function(js) {
    document.getElementById('edit_id_kategori_jasa').value = js.id_kategori;
    document.getElementById('edit_nama_jasa').value = js.nama_jasa;
    document.getElementById('formEditJasa').action = "/admin/kelola/jasa/" + js.id_jasa;
    if (typeof window.openModal === 'function') {
        window.openModal('modalEditJasa');
    }
};

window.openEditSatuanModal = function(st) {
    document.getElementById('edit_nama_satuan').value = st.nama_satuan;
    document.getElementById('formEditSatuan').action = "/admin/kelola/satuan/" + st.id_satuan;
    if (typeof window.openModal === 'function') {
        window.openModal('modalEditSatuan');
    }
};

document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('kelolaChart');
    if (!ctx) return;
    
    let kategoriData = [];
    try {
        kategoriData = JSON.parse(ctx.dataset.chart || '[]');
    } catch (e) {
        console.error(e);
    }
    
    const labels = kategoriData.map(item => item.nama_kategori);
    const data = kategoriData.map(item => item.jumlah_jasa);
    
    new Chart(ctx.getContext('2d'), {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Jumlah Jasa',
                data: data,
                backgroundColor: '#2196F3',
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

window.openDetailModal = function(bk) {
    const elId = document.getElementById('detail_id');
    if (!elId) return;

    elId.innerText = bk.id_booking;
    document.getElementById('detail_client').innerText = bk.nama_client;
    document.getElementById('detail_client_contact').innerText = (bk.client_email || '-') + ' / ' + (bk.client_phone || '-');
    document.getElementById('detail_freelancer').innerText = bk.nama_freelancer;
    document.getElementById('detail_jasa').innerText = bk.nama_jasa;
    
    const dateObj = new Date(bk.tanggal_booking);
    const day = String(dateObj.getDate()).padStart(2, '0');
    const month = String(dateObj.getMonth() + 1).padStart(2, '0');
    const year = dateObj.getFullYear();
    document.getElementById('detail_tanggal').innerText = `${day}-${month}-${year}`;
    
    document.getElementById('detail_alamat').innerText = bk.alamat_booking || '-';
    document.getElementById('detail_catatan').innerText = bk.catatan_booking || '-';
    
    const statusSpan = document.getElementById('detail_status');
    statusSpan.innerText = bk.status_booking;
    
    // reset classes
    statusSpan.className = "px-3 py-1 rounded-full text-[11px] font-bold border inline-block ";
    if (bk.status_booking === 'MENUNGGU') statusSpan.className += "bg-gray-100 text-gray-600 border-gray-200";
    if (bk.status_booking === 'DIPROSES') statusSpan.className += "bg-yellow-50 text-yellow-600 border-yellow-200";
    if (bk.status_booking === 'SELESAI') statusSpan.className += "bg-green-50 text-green-600 border-green-200";
    if (bk.status_booking === 'DIBATALKAN') statusSpan.className += "bg-red-50 text-red-600 border-red-200";
    
    if (typeof window.openModal === 'function') {
        window.openModal('modalDetail');
    }
};

document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('bookingChart');
    if (!ctx) return;
    
    let stats = {};
    try {
        stats = JSON.parse(ctx.dataset.stats || '{}');
    } catch(e) {
        console.error(e);
    }
    
    new Chart(ctx.getContext('2d'), {
        type: 'doughnut',
        data: {
            labels: ['Menunggu', 'Diproses', 'Selesai', 'Dibatalkan'],
            datasets: [{
                data: [stats.Menunggu || 0, stats.Diproses || 0, stats.Selesai || 0, stats.Dibatalkan || 0],
                backgroundColor: ['#9CA3AF', '#FBBF24', '#34D399', '#F87171'],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom', labels: { font: { family: "'Inter', sans-serif" }, usePointStyle: true } }
            }
        }
    });
});

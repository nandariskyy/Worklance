window.openDetailModal = function(pj) {
    document.getElementById('detail_nama').innerText = pj.nama_pengguna;
    document.getElementById('detail_nik').innerText = pj.nik || '-';
    document.getElementById('detail_telp').innerText = pj.no_telp || '-';
    document.getElementById('detail_email').innerText = pj.email || '-';
    
    // Formatting date loosely for display
    const dateObj = new Date(pj.tanggal_pengajuan);
    const day = String(dateObj.getDate()).padStart(2, '0');
    const month = String(dateObj.getMonth() + 1).padStart(2, '0');
    const year = dateObj.getFullYear();
    document.getElementById('detail_waktu').innerText = `${day}-${month}-${year}`;
    
    document.getElementById('detail_deskripsi').innerText = pj.deskripsi_keahlian || pj.surat_lamaran || '';
    
    const statusSpan = document.getElementById('detail_status');
    statusSpan.innerText = pj.status;
    
    statusSpan.className = "px-2 py-0.5 rounded text-[11px] font-bold tracking-wide border inline-block uppercase mt-0.5 ";
    if (pj.status === 'MENUNGGU') statusSpan.className += "bg-yellow-50 text-yellow-600 border-yellow-200";
    if (pj.status === 'DITERIMA') statusSpan.className += "bg-green-50 text-green-600 border-green-200";
    if (pj.status === 'DITOLAK') statusSpan.className += "bg-red-50 text-red-600 border-red-200";
    
    if (pj.status === 'MENUNGGU') {
        document.getElementById('action_container').classList.remove('hidden');
        document.getElementById('form_id_pengajuan').value = pj.id_pengajuan;
    } else {
        document.getElementById('action_container').classList.add('hidden');
    }
    
    if (typeof window.openModal === 'function') {
        window.openModal('modalDetail');
    }
};

window.submitVerifikasi = function(action) {
    document.getElementById('form_action').value = action;
    const actionText = action === 'approve' ? 'menerima' : 'menolak';
    
    // Check if custom confirm UI is available
    if (typeof window.openCustomConfirm === 'function') {
        window.openCustomConfirm('Yakin ' + actionText + ' pengajuan ini?', document.getElementById('verifikasiForm'));
    } else {
        if(confirm('Yakin ' + actionText + ' pengajuan ini?')) {
            document.getElementById('verifikasiForm').submit();
        }
    }
};

document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('pengajuanChart');
    if (!ctx) return;
    
    let rawData = [];
    try {
        rawData = JSON.parse(ctx.dataset.chart || '[]');
    } catch (e) {
        console.error(e);
    }
    
    const labels = rawData.map(item => item.status);
    const data = rawData.map(item => item.total);
    
    new Chart(ctx.getContext('2d'), {
        type: 'doughnut',
        data: {
            labels: labels,
            datasets: [{
                data: data,
                backgroundColor: ['#9CA3AF', '#34D399', '#F87171'],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom', labels: { font: { family: "'Inter', sans-serif" }, usePointStyle: true } }
            },
            cutout: '65%'
        }
    });
});

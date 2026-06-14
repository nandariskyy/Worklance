window.openEditModal = function(user) {
    const editUsername = document.getElementById('edit_username');
    if (!editUsername) return;

    editUsername.value = user.username;
    document.getElementById('edit_id_role').value = user.id_role;
    document.getElementById('edit_nama_pengguna').value = user.nama_pengguna;
    document.getElementById('edit_email').value = user.email;
    document.getElementById('edit_no_telp').value = user.no_telp || '';
    
    document.getElementById('editForm').action = "/admin/pengguna/" + user.id_pengguna;
    if (typeof window.openModal === 'function') {
        window.openModal('modalEdit');
    }
};

window.openDetailModal = function(user) {
    const detailTitle = document.getElementById('detail_title');
    if (!detailTitle) return;

    detailTitle.innerText = 'Detail Pengguna #' + user.id_pengguna;
    document.getElementById('detail_avatar').innerText = user.nama_pengguna.substring(0, 1).toUpperCase();
    document.getElementById('detail_nama_pengguna').innerText = user.nama_pengguna;
    document.getElementById('detail_username').innerText = '@' + (user.username || '');
    document.getElementById('detail_role').innerText = user.role || '-';
    document.getElementById('detail_email').innerText = user.email;
    document.getElementById('detail_no_telp').innerText = user.no_telp || '-';
    document.getElementById('detail_tanggal_lahir').innerText = user.tanggal_lahir || '-';
    
    document.getElementById('detail_provinsi').innerText = user.provinsi || '-';
    document.getElementById('detail_kabupaten').innerText = user.kabupaten || '-';
    document.getElementById('detail_kecamatan').innerText = user.kecamatan || '-';
    document.getElementById('detail_desa').innerText = user.desa || '-';
    document.getElementById('detail_alamat').innerText = user.alamat_lengkap || '-';
    
    if (typeof window.openModal === 'function') {
        window.openModal('modalDetail');
    }
};

document.addEventListener('DOMContentLoaded', function() {
    // Role Chart
    const ctxRoleEl = document.getElementById('roleChart');
    if (ctxRoleEl) {
        let rawData = [];
        try {
            rawData = JSON.parse(ctxRoleEl.dataset.chart || '[]');
        } catch (e) {
            console.error(e);
        }
        
        const labels = rawData.map(item => item.nama_role);
        const data = rawData.map(item => item.total);
        
        new Chart(ctxRoleEl.getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: labels,
                datasets: [{
                    data: data,
                    backgroundColor: ['#2196F3', '#4CAF50', '#FF6B00'],
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
    }

    // Kota Chart
    const ctxKotaEl = document.getElementById('kotaChart');
    if (ctxKotaEl) {
        let kotaData = [];
        try {
            kotaData = JSON.parse(ctxKotaEl.dataset.chart || '[]');
        } catch (e) {
            console.error(e);
        }

        new Chart(ctxKotaEl.getContext('2d'), {
            type: 'bar',
            data: {
                labels: kotaData.map(i => i.kabupaten),
                datasets: [{
                    label: 'Pengguna',
                    data: kotaData.map(i => i.total),
                    backgroundColor: '#9C27B0',
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
    }
});

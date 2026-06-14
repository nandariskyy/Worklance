document.addEventListener('DOMContentLoaded', function() {
    const data = JSON.parse(localStorage.getItem('worklance_booking') || 'null');
    const container = document.getElementById('ringkasanContainer');
    
    if(!container) return;
    const hasSuccess = container.getAttribute('data-has-success') === 'true';

    function buildWaUrl(d) {
        const telp = (d.freelancerTelp || '').replace(/^0/, '62');
        const msg = `Halo ${d.freelancerNama}, saya ingin memesan layanan *${d.namaJasa || d.freelancerJasa}*.\n\n📅 Tanggal: ${d.tanggal}\n📍 Alamat: ${d.alamat}\n📝 Catatan: ${d.catatan || '-'}\n\nTerima kasih!`;
        return `https://wa.me/${telp}?text=${encodeURIComponent(msg)}`;
    }

    if (!hasSuccess) {
        if (data) {
            const sumNama = document.getElementById('sumNama');
            if(sumNama) sumNama.textContent = data.freelancerNama;
            
            const sumJasa = document.getElementById('sumJasa');
            if(sumJasa) sumJasa.textContent = data.namaJasa || data.freelancerJasa;
            
            const sumTarif = document.getElementById('sumTarif');
            if(sumTarif) sumTarif.textContent = 'Rp ' + parseInt(data.freelancerTarif).toLocaleString('id-ID');
            
            const sumSatuan = document.getElementById('sumSatuan');
            if(sumSatuan) sumSatuan.textContent = data.freelancerSatuan;
            
            const sumTanggal = document.getElementById('sumTanggal');
            if(sumTanggal) sumTanggal.textContent = data.tanggal;
            
            const sumAlamat = document.getElementById('sumAlamat');
            if(sumAlamat) sumAlamat.textContent = data.alamat;
            
            const sumCatatan = document.getElementById('sumCatatan');
            if(sumCatatan) sumCatatan.textContent = data.catatan || '-';

            // Fill hidden form
            const fIdLayanan = document.getElementById('formIdLayanan');
            if (fIdLayanan) fIdLayanan.value = data.idLayanan;
            const fTanggal = document.getElementById('formTanggal');
            if (fTanggal) fTanggal.value = data.tanggal;
            const fAlamat = document.getElementById('formAlamat');
            if (fAlamat) fAlamat.value = data.alamat;
            const fCatatan = document.getElementById('formCatatan');
            if (fCatatan) fCatatan.value = data.catatan;

            // Direct WA button (not logged in)
            const btnDirect = document.getElementById('btnWaDirect');
            if (btnDirect) btnDirect.addEventListener('click', () => window.open(buildWaUrl(data), '_blank'));
        } else {
            const orderSummary = document.getElementById('orderSummary');
            if(orderSummary) orderSummary.classList.add('hidden');
            const noData = document.getElementById('noData');
            if(noData) noData.classList.remove('hidden');
        }
    } else {
        // After booking saved, WhatsApp button
        const btnWa = document.getElementById('btnWhatsApp');
        if (btnWa && data) {
            btnWa.addEventListener('click', () => {
                window.open(buildWaUrl(data), '_blank');
                localStorage.removeItem('worklance_booking');
            });
        }
    }
});

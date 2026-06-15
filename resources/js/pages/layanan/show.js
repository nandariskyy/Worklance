window.switchTab = function(tabId) {
    if (tabId === 'deskripsi') {
        document.getElementById('tabDeskripsi').classList.remove('hidden');
        document.getElementById('tabDeskripsi').classList.add('block');
        document.getElementById('tabUlasan').classList.add('hidden');
        document.getElementById('tabUlasan').classList.remove('block');
        
        document.getElementById('btnDeskripsi').classList.add('text-accent', 'border-accent');
        document.getElementById('btnDeskripsi').classList.remove('text-gray-400', 'border-transparent');
        document.getElementById('btnUlasan').classList.remove('text-accent', 'border-accent');
        document.getElementById('btnUlasan').classList.add('text-gray-400', 'border-transparent');
    } else {
        document.getElementById('tabUlasan').classList.remove('hidden');
        document.getElementById('tabUlasan').classList.add('block');
        document.getElementById('tabDeskripsi').classList.add('hidden');
        document.getElementById('tabDeskripsi').classList.remove('block');
        
        document.getElementById('btnUlasan').classList.add('text-accent', 'border-accent');
        document.getElementById('btnUlasan').classList.remove('text-gray-400', 'border-transparent');
        document.getElementById('btnDeskripsi').classList.remove('text-accent', 'border-accent');
        document.getElementById('btnDeskripsi').classList.add('text-gray-400', 'border-transparent');
    }
};

document.addEventListener('DOMContentLoaded', function() {
    const bookingForm = document.getElementById('bookingForm');
    if (bookingForm) {
        bookingForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const ds = bookingForm.dataset;
            const catatan = document.getElementById('inpCatatan').value;
            const alamat = document.getElementById('inpAlamat').value;
            const tanggal = document.getElementById('inpTanggal').value;
            
            const bookingData = {
                idLayanan: ds.id,
                namaJasa: ds.namaJasa,
                freelancerNama: ds.freelancerNama,
                freelancerTelp: ds.freelancerTelp,
                freelancerTarif: ds.freelancerTarif,
                freelancerSatuan: ds.freelancerSatuan,
                catatan: catatan,
                alamat: alamat,
                tanggal: tanggal
            };
            
            localStorage.setItem('worklance_booking', JSON.stringify(bookingData));
            window.location.href = '/ringkasan-pesanan';
        });
    }
});

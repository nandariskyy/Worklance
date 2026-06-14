document.addEventListener('DOMContentLoaded', function() {
    // JS Filtering Cascade
    function cascadeFilter(parentSel, childSel, dataAttr) {
        const parentEl = document.getElementById(parentSel);
        if (!parentEl) return;
        parentEl.addEventListener('change', function() {
            const val = this.value;
            const child = document.getElementById(childSel);
            if (!child) return;
            child.value = '';
            child.querySelectorAll('option[' + dataAttr + ']').forEach(opt => {
                opt.style.display = (!val || opt.getAttribute(dataAttr) === val) ? '' : 'none';
            });
            child.dispatchEvent(new Event('change'));
        });
    }

    // Initialize display states correctly without overwriting values
    function initCascadeFilters() {
        const selProvinsi = document.getElementById('selProvinsi');
        const selKabupaten = document.getElementById('selKabupaten');
        const selKecamatan = document.getElementById('selKecamatan');
        
        const sels = [
            { c: 'selKabupaten', pId: selProvinsi ? selProvinsi.value : '', attr: 'data-prov' },
            { c: 'selKecamatan', pId: selKabupaten ? selKabupaten.value : '', attr: 'data-kab' },
            { c: 'selDesa', pId: selKecamatan ? selKecamatan.value : '', attr: 'data-kec' }
        ];
        
        sels.forEach(combo => {
            const child = document.getElementById(combo.c);
            if(!child) return;
            child.querySelectorAll('option[' + combo.attr + ']').forEach(opt => {
               opt.style.display = (!combo.pId || opt.getAttribute(combo.attr) === combo.pId) ? '' : 'none';
            });
        });
    }

    cascadeFilter('selProvinsi', 'selKabupaten', 'data-prov');
    cascadeFilter('selKabupaten', 'selKecamatan', 'data-kab');
    cascadeFilter('selKecamatan', 'selDesa', 'data-kec');
    initCascadeFilters();
});

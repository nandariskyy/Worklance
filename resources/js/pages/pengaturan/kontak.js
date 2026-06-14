document.addEventListener('DOMContentLoaded', function() {
    function cascadeFilter(parentSel, childSel, dataAttr) {
        const parent = document.getElementById(parentSel);
        const child = document.getElementById(childSel);
        
        if (!parent || !child) return;

        // Trigger change logic
        function updateChild() {
            const val = parent.value;
            let hasValidOption = false;
            
            Array.from(child.options).forEach(opt => {
                if (opt.value === "") return; // Skip placeholder
                const match = (!val || opt.getAttribute(dataAttr) === val);
                opt.style.display = match ? '' : 'none';
                if (match && opt.selected) hasValidOption = true;
            });
            
            if (!hasValidOption && child.value !== "") {
                child.value = "";
            }
            
            // Dispatch event so the next child updates too
            child.dispatchEvent(new Event('change'));
        }

        parent.addEventListener('change', updateChild);
        
        // Run on load
        updateChild();
    }
    
    cascadeFilter('selProvinsi', 'selKabupaten', 'data-prov');
    cascadeFilter('selKabupaten', 'selKecamatan', 'data-kab');
    cascadeFilter('selKecamatan', 'selDesa', 'data-kec');
});

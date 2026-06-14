document.addEventListener('DOMContentLoaded', function() {
    window.addEventListener('click', function(e) {
        if (document.getElementById('userMenuWrap')) {
            if (!document.getElementById('userMenuWrap').contains(e.target)) {
                const dropdown = document.getElementById('userDropdown');
                if (dropdown && !dropdown.classList.contains('hidden')) {
                    dropdown.classList.add('hidden');
                }
            }
        }
    });
});

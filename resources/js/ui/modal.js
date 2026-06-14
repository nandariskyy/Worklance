// resources/js/ui/modal.js

function openModal(id) {
    const modal = document.getElementById(id);
    const content = document.getElementById(id + 'Content');
    if (modal && content) {
        modal.classList.remove('hidden');
        setTimeout(() => {
            content.classList.remove('scale-95', 'opacity-0');
            content.classList.add('scale-100', 'opacity-100');
        }, 10);
    }
}

function closeModal(id) {
    const modal = document.getElementById(id);
    const content = document.getElementById(id + 'Content');
    if (modal && content) {
        content.classList.remove('scale-100', 'opacity-100');
        content.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }
}

// Expose to window for inline event listeners like onclick="openModal('modalID')"
window.openModal = openModal;
window.closeModal = closeModal;

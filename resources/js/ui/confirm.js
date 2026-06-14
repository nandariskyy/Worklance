// resources/js/ui/confirm.js

let currentFormToSubmit = null;

function openCustomConfirm(message, formElement) {
    document.getElementById('customConfirmMessage').innerText = message;
    currentFormToSubmit = formElement;
    
    const modal = document.getElementById('customConfirmModal');
    const content = document.getElementById('customConfirmModalContent');
    
    if (modal && content) {
        modal.classList.remove('hidden');
        // trigger animation
        setTimeout(() => {
            content.classList.remove('scale-95', 'opacity-0');
            content.classList.add('scale-100', 'opacity-100');
        }, 10);
    }
}

function closeCustomConfirm() {
    const modal = document.getElementById('customConfirmModal');
    const content = document.getElementById('customConfirmModalContent');
    
    if (modal && content) {
        content.classList.remove('scale-100', 'opacity-100');
        content.classList.add('scale-95', 'opacity-0');
        
        setTimeout(() => {
            modal.classList.add('hidden');
            currentFormToSubmit = null;
        }, 200);
    }
}

document.addEventListener('DOMContentLoaded', () => {
    const confirmBtn = document.getElementById('customConfirmBtn');
    if (confirmBtn) {
        confirmBtn.addEventListener('click', function() {
            if (currentFormToSubmit) {
                currentFormToSubmit.submit();
            }
        });
    }
});

// Expose to global window object so inline event handlers (like onsubmit="return confirmAction(...)") can access it
window.confirmAction = function(event, message) {
    event.preventDefault();
    openCustomConfirm(message, event.target);
    return false;
};

window.closeCustomConfirm = closeCustomConfirm;
window.openCustomConfirm = openCustomConfirm;

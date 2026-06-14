document.addEventListener('DOMContentLoaded', function() {
    const fotoInput = document.getElementById('foto_profil_input');
    if (fotoInput) {
        fotoInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    let img = document.getElementById('foto_preview_img');
                    let initial = document.getElementById('foto_preview_initial');
                    if(img) {
                        img.src = event.target.result;
                        img.classList.remove('hidden');
                    }
                    if(initial) {
                        initial.classList.add('hidden');
                    }
                }
                reader.readAsDataURL(file);
            }
        });
    }
});

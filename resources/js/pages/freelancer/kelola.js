let deletedImages = [];

document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('serviceModal');
    if (!modal) return;
    
    const modalTitle = document.getElementById('modalTitle');
    const selKategori = document.getElementById('selectKategori');
    const inputTarif = document.getElementById('inputTarif');
    const selectSatuan = document.getElementById('selectSatuan');
    const inputNamaJasa = document.getElementById('inputNamaJasa');
    const inputDeskripsi = document.getElementById('inputDeskripsi');
    const containerWrapper = document.getElementById('jasaContainerWrapper');
    const items = document.querySelectorAll('.jasa-item');
    const checkboxes = document.querySelectorAll('.jasa-radio');
    const noJasaMsg = document.getElementById('noJasaMsg');
    
    const coverInput = document.getElementById('inputGambarCover');
    const coverPreviewContainer = document.getElementById('coverPreviewContainer');
    const coverPreview = document.getElementById('coverPreview');
    const removeCoverBtn = document.getElementById('removeCoverBtn');
    const inputRemoveCover = document.getElementById('inputRemoveCover');
    
    const portofolioInput = document.getElementById('portofolioInput');
    const previewContainer = document.getElementById('previewContainer');
    const imageCountMsg = document.getElementById('imageCountMsg');
    const imageErrorMsg = document.getElementById('imageErrorMsg');
    const MAX_IMAGES = 5;
    const MIN_IMAGES = 1;
    let selectedFiles = [];

    if (coverInput) {
        coverInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    if(coverPreview) coverPreview.src = e.target.result;
                    if(coverPreviewContainer) coverPreviewContainer.classList.remove('hidden');
                    if(inputRemoveCover) inputRemoveCover.value = '0';
                }
                reader.readAsDataURL(file);
            } else {
                if(coverPreviewContainer) coverPreviewContainer.classList.add('hidden');
                if(coverPreview) coverPreview.src = '';
            }
        });
    }

    if (removeCoverBtn) {
        removeCoverBtn.addEventListener('click', function() {
            if (coverInput) coverInput.value = '';
            if (coverPreviewContainer) coverPreviewContainer.classList.add('hidden');
            if (coverPreview) coverPreview.src = '';
            if (inputRemoveCover) inputRemoveCover.value = '1';
        });
    }

    function resetForm() {
        if(modalTitle) modalTitle.innerText = "Tambah Layanan Baru";
        if(selKategori) {
            selKategori.value = '';
            selKategori.disabled = false;
        }
        if(inputTarif) inputTarif.value = '';
        if(selectSatuan) selectSatuan.value = '';
        if(inputNamaJasa) inputNamaJasa.value = '';
        if(inputDeskripsi) inputDeskripsi.value = '';
        
        if (coverInput) coverInput.value = '';
        if (coverPreviewContainer) coverPreviewContainer.classList.add('hidden');
        if (coverPreview) coverPreview.src = '';
        if (inputRemoveCover) inputRemoveCover.value = '0';

        updateCheckboxesVis();
        checkboxes.forEach(chk => { chk.checked = false; triggerCheckboxStyling(chk); });

        if(previewContainer) previewContainer.innerHTML = '';
        if(imageCountMsg) imageCountMsg.textContent = '0/5 gambar dipilih';

        deletedImages = [];
        const deletedInput = document.getElementById('deletedImages');
        if (deletedInput) {deletedInput.value = '';}

        const layananInput = document.getElementById('inputIdLayanan');
        if (layananInput) {layananInput.value = '';}
        
        selectedFiles = [];
        updateInputFile();
    }

    function triggerCheckboxStyling(input) {
        const label = input.closest('.jasa-item');
        if(!label) return;
        if (input.checked) {
          label.classList.add('border-accent', 'shadow-sm', 'ring-1', 'ring-accent/30');
          label.classList.remove('border-gray-200');
        } else {
          label.classList.remove('border-accent', 'shadow-sm', 'ring-1', 'ring-accent/30');
          label.classList.add('border-gray-200');
        }
    }

    function updateCheckboxesVis() {
      if(!selKategori || !containerWrapper || !noJasaMsg) return;
      const katId = selKategori.value;
      let count = 0;
      
      if (!katId) {
        containerWrapper.classList.add('hidden');
        items.forEach(el => {
          const input = el.querySelector('input');
          if(input) {
              input.checked = false;
              triggerCheckboxStyling(input);
          }
        });
        return;
      }
      
      containerWrapper.classList.remove('hidden');

      items.forEach(el => {
        if (el.dataset.kategori === katId) {
          el.style.display = 'flex';
          count++;
        } else {
          el.style.display = 'none';
          const input = el.querySelector('input');
          if(input) {
              input.checked = false;
              triggerCheckboxStyling(input);
          }
        }
      });

      noJasaMsg.style.display = (count === 0) ? 'block' : 'none';
    }

    if(selKategori) selKategori.addEventListener('change', updateCheckboxesVis);

    checkboxes.forEach(input => {
      input.addEventListener('change', () => { triggerCheckboxStyling(input); });
    });

    window.openModal = function() {
        resetForm();
        modal.classList.remove('hidden');
        document.body.classList.add('modal-open');
    };

    window.openModalEdit = function(data) {
        resetForm();
        if(modalTitle) modalTitle.innerText = "Edit Kategori Layanan";
        if(selKategori) {
            selKategori.value = data.id_kategori;
            Array.from(selKategori.options).forEach(opt => { 
                if (opt.value && opt.value != data.id_kategori) opt.disabled = true; 
            });
        }

        const inputIdLayanan = document.getElementById('inputIdLayanan');
        if(inputIdLayanan) inputIdLayanan.value = data.id_layanan;

        if(inputTarif) inputTarif.value = data.tarif;
        if(selectSatuan) selectSatuan.value = data.id_satuan;
        if(inputNamaJasa) inputNamaJasa.value = data.namajasa;
        if(inputDeskripsi) inputDeskripsi.value = data.deskripsi;
        
        if (data.gambar_cover) {
            if (coverPreview) {
                coverPreview.src = data.gambar_cover;
                if(coverPreviewContainer) coverPreviewContainer.classList.remove('hidden');
            }
        }
        
        updateCheckboxesVis();
        
        if(data.id_jasa) {
            checkboxes.forEach(chk => {
                if (parseInt(chk.value) === parseInt(data.id_jasa)) {
                    chk.checked = true;
                    triggerCheckboxStyling(chk);
                }
            });
        }
        
        if(previewContainer) previewContainer.innerHTML = '';

        if(data.gambar && data.gambar.length > 0){
            data.gambar.forEach((img) => {
                const div = document.createElement('div');
                div.className = 'relative group';
                div.innerHTML = `
                  <img
                      src="/storage/${img.file_gambar}"
                      class="w-full h-24 object-cover rounded-lg border border-gray-200"
                  >
                  <button
                      type="button"
                      class="absolute top-1 right-1 bg-red-500 text-white rounded-full w-6 h-6"
                      onclick="removeOldImage(${img.id_gambar}, this)"
                  >
                      ×
                  </button>
                `;
                if(previewContainer) previewContainer.appendChild(div);
            });
            if(imageCountMsg) imageCountMsg.textContent = `${data.gambar.length}/5 gambar dipilih`;
        }

        modal.classList.remove('hidden');
        document.body.classList.add('modal-open');
    };

    window.closeModal = function() {
        modal.classList.add('hidden');
        document.body.classList.remove('modal-open');
        if(selKategori) Array.from(selKategori.options).forEach(opt => { opt.disabled = false; });
    };

    window.removeOldImage = function(idGambar, button) {
      deletedImages.push(idGambar);
      const deletedInput = document.getElementById('deletedImages');
      if(deletedInput) deletedInput.value = JSON.stringify(deletedImages);
      button.closest('.group').remove();
    };

    if(portofolioInput) {
        portofolioInput.addEventListener('change', function(e) {
            handleFiles(Array.from(e.target.files));
        });
    }

    function handleFiles(files) {
        if (selectedFiles.length + files.length > MAX_IMAGES) {
            showError(`Maksimal ${MAX_IMAGES} gambar.`);
            return;
        }

        files.forEach(file => {
            if (!file.type.match(/image\/(png|jpeg|jpg)/)) {
                showError('Hanya format PNG, JPG, JPEG yang diperbolehkan.');
                return;
            }
            if (file.size > 2 * 1024 * 1024) {
                showError('Ukuran maksimal per gambar adalah 2MB.');
                return;
            }
            selectedFiles.push(file);
        });

        renderPreviews();
    }

    function renderPreviews() {
        if(!previewContainer) return;
        previewContainer.innerHTML = '';
        
        selectedFiles.forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const div = document.createElement('div');
                div.className = 'relative group';
                div.innerHTML = `
                    <img src="${e.target.result}" class="w-full h-24 object-cover rounded-lg border border-gray-200">
                    <button type="button" onclick="removeNewImage(${index})" class="absolute top-1 right-1 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs opacity-0 group-hover:opacity-100 transition-opacity">✕</button>
                `;
                previewContainer.appendChild(div);
            };
            reader.readAsDataURL(file);
        });

        updateCountMessage();
        updateInputFile();
    }

    window.removeNewImage = function(index) {
        selectedFiles.splice(index, 1);
        renderPreviews();
    };

    function updateInputFile() {
        if(!portofolioInput) return;
        const dataTransfer = new DataTransfer();
        selectedFiles.forEach(file => dataTransfer.items.add(file));
        portofolioInput.files = dataTransfer.files;
    }

    function updateCountMessage() {
        if(!imageCountMsg) return;
        imageCountMsg.textContent = `${selectedFiles.length}/${MAX_IMAGES} gambar dipilih`;
        imageCountMsg.className = selectedFiles.length < MIN_IMAGES ? 'text-xs text-red-500 mt-2' : 'text-xs text-gray-500 mt-2';
    }

    function showError(message) {
        if(!imageErrorMsg) return;
        imageErrorMsg.textContent = message;
        imageErrorMsg.classList.remove('hidden');
        setTimeout(() => imageErrorMsg.classList.add('hidden'), 3000);
    }
});

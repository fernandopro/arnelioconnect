export const imageWordpress = (id_form, { __ }) => {
  // Manejar múltiples campos de carga de imágenes
  const imageUploadFields = document.querySelectorAll('.field-arnelio-image-wordpress');

  imageUploadFields.forEach(field => {
    let mediaUploader;
    const uploadButton = field.querySelector('.upload-button');
    const removeButton = field.querySelector('.remove-button');
    const imagePreview = field.querySelector('.image-preview');
    const imageInput = field.querySelector('.image-input');

    uploadButton.addEventListener('click', (e) => {
      e.preventDefault();
      mediaUploader = wp.media({
        title: 'Seleccionar imagen',
        button: {
          text: 'Usar esta imagen'
        },
        multiple: false
      });
      mediaUploader.on('select', function() {
        const attachment = mediaUploader.state().get('selection').first().toJSON();
        imageInput.value = attachment.id;
        imagePreview.innerHTML = `<img src="${attachment.url}" class="img-fluid">`;
      });
      mediaUploader.open();
    });

    removeButton.addEventListener('click', (e) => {
      e.preventDefault();
      imageInput.value = '';
      imagePreview.innerHTML = '';
      setTimeout(() => {
        // Obtén el formulario y envíalo
        const form = document.getElementById(id_form);
        if (form && form.tagName === "FORM") {
          HTMLFormElement.prototype.submit.call(form);
        } else {
          console.error(
            __('An error occurred.','arnelioconnect')
          );
        }
      }, 500);
    });
  });
};
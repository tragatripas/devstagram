import Dropzone from "dropzone";
Dropzone.autoDiscover = false;

document.addEventListener('DOMContentLoaded', function () {
  const inputImagen = document.querySelector('input[name="imagen"]');
  const dropzoneElement = document.querySelector("#dropzone");

  if (!dropzoneElement) return;

  const dropzone = new Dropzone(dropzoneElement, {
    dictDefaultMessage: "sube aqui tu imagen",
    acceptedFiles: ".png, .jpg, .jpeg, .gif",
    addRemoveLinks: true,
    dictRemoveFile: "Eliminar archivo",
    maxFiles: 1,
    uploadMultiple: false,

    init: function () {
      if (inputImagen && inputImagen.value.trim()) {
        const imagenPublicada = {
          size: 1234, // Tamaño ficticio o real si lo tienes
          name: inputImagen.value
        };

        this.options.addedfile.call(this, imagenPublicada);
        this.options.thumbnail.call(this, imagenPublicada, `/uploads/${imagenPublicada.name}`);
        imagenPublicada.previewElement.classList.add("dz-success", "dz-complete");
      }
    }
  });

  dropzone.on("success", function (file, response) {
    if (inputImagen) {
      inputImagen.value = response.imagen;
    }
  });

  dropzone.on("removedfile", function () {
    if (inputImagen) {
      inputImagen.value = '';
    }
  });
});

import Dropzone from "dropzone";

Dropzone.autoDiscover = false;

const dropzone = new Dropzone("#dropzone", {
  dictDefaultMessage: "sube aqui tu imagen",
  acceptedFiles: ".png, .jpg, .jpeg, .gif",
  addRemoveLinks: true,
  dictRemoveFile: "Eliminar archivo",
  maxFiles: 1,
  uploadMultiple: false,

  init: function () {
    if(document.querySelector('[name="imagen"]').value.trim()) {
      const imagenPublicada = {};
      imagenPublicada.size = 1234; // Tamaño del archivo en bytes
      imagenPublicada.name = document.querySelector('[name="imagen"]').value; // Nombre del archivo
      
      this.options.addedfile.call(this, imagenPublicada);
      this.options.thumbnail.call(this, imagenPublicada, `/uploads/${imagenPublicada.name}`);

      imagenPublicada.previewElement.classList.add("dz-success", "dz-complete");

    }
  }

});

dropzone.on("success", function (file, response) {
  document.querySelector('[name="imagen"]').value = response.imagen;
  // Aquí puedes manejar la respuesta del servidor
  // Por ejemplo, mostrar un mensaje de éxito o actualizar la vista
}
);

dropzone.on("removedfile", function () {
  document.querySelector('[name="imagen"]').value = '';
});
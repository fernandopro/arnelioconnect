export const buttonToggle = ({ Swal, id_form }) => {
  if (Swal && id_form) {
    document.addEventListener("click", (e) => {
      if (e.target.matches("[data-button-toggle]")) {
        Swal.fire({
          title: "",
          timer: 100,
          timerProgressBar: true,
          didOpen: () => {
            Swal.showLoading();
          },
        }).then((result) => {
          if (result.dismiss === Swal.DismissReason.timer) {
            const form = document.getElementById(id_form);
            if (form && form.tagName === "FORM") {
              HTMLFormElement.prototype.submit.call(form);
            } else {
              console.error(
                `El elemento con ID "${id_form}" no es un formulario o no existe.`
              );
            }
          }
        });
      }
    });
  }
};
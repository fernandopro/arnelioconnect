export const autoSaveClick = ({ auto_save_click, Swal, id_form }) => {
  if (auto_save_click && Swal && id_form) {
    const updateClick = (e) => {
      const element = e.target;

      // Verificar si el elemento tiene un ID que coincide o el atributo data-toggle="tab"
      if (
        (element.id &&
          auto_save_click.some((value) => element.id.startsWith(value))) 
      ) {
        Swal.fire({
          title: "",
          timer: 100,
          timerProgressBar: true,
          didOpen: () => {
            Swal.showLoading();
          },
        }).then((result) => {
          if (result.dismiss === Swal.DismissReason.timer) {
            // Obtener el formulario y enviarlo
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
    };
    document.addEventListener("click", updateClick);
  }
};
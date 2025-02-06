export const autoSaveChange = ({ auto_save_change, Swal, id_form }) => {
  if (auto_save_change && Swal && id_form) {
    const updateChange = (e) => {
      const element = e.target;

      if (
        element.id &&
        auto_save_change.some((value) => element.id.startsWith(value))
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
    document.addEventListener("change", updateChange);
  }
};
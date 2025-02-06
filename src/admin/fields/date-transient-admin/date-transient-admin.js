/**
 * Inicializa la gestión de fechas y horas para transients, buscando elementos
 * y registrando eventos de cambio y eliminación.
 * @param {string[]} dateTransientAdmin Array con los nombres de los transients
 */
export const dateTransientAdminField = (
  dateTransientAdmin,
  { __, _e, _n, sprintf },
  Swal,
  id_form,
  security,
  ajax_url
) => {
  // Campos de fecha y hora para transients
  dateTransientAdmin.forEach((transientName) => {
    const startDateInput = document.getElementById(
      `${transientName}_start_date`
    );
    const startTimeInput = document.getElementById(
      `${transientName}_start_time`
    );
    const endDateInput = document.getElementById(`${transientName}_end_date`);
    const endTimeInput = document.getElementById(`${transientName}_end_time`);
    const deleteButton = document.getElementById(
      `${transientName}_delete_value`
    );

    if (startDateInput && startTimeInput && endDateInput && endTimeInput) {
      // Evento al cambiar la fecha u hora de inicio
      [startDateInput, startTimeInput].forEach((input) => {
        input.addEventListener("change", () => {
          const startDateTimeStr = `${startDateInput.value}T${startTimeInput.value}`;
          const endDateTimeStr = `${endDateInput.value}T${endTimeInput.value}`;
          const startDateTime = new Date(startDateTimeStr);
          const endDateTime = new Date(endDateTimeStr);

          // Si la fecha/hora de inicio es posterior a la de fin, actualizar la de fin
          if (startDateTime > endDateTime) {
            endDateInput.value = startDateInput.value;
            endTimeInput.value = startTimeInput.value;
          }
        });
      });

      // Evento al cambiar la fecha u hora de fin
      [endDateInput, endTimeInput].forEach((input) => {
        input.addEventListener("change", () => {
          const startDateTimeStr = `${startDateInput.value}T${startTimeInput.value}`;
          const endDateTimeStr = `${endDateInput.value}T${endTimeInput.value}`;
          const startDateTime = new Date(startDateTimeStr);
          const endDateTime = new Date(endDateTimeStr);

          // Si la fecha/hora de fin es anterior a la de inicio, actualizar la de inicio
          if (endDateTime < startDateTime) {
            startDateInput.value = endDateInput.value;
            startTimeInput.value = endTimeInput.value;
          }
        });
      });

      // Evento para eliminar el transient
      if (deleteButton) {
        deleteButton.addEventListener("click", (e) => {
          e.preventDefault();

          Swal.fire({
            title: __("Are you sure?", "arnelioconnect"),
            text: __("This action will stop the process.", "arnelioconnect"),
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#cccccc",
            confirmButtonText: __("Yes", "arnelioconnect"),
            cancelButtonText: __("No", "arnelioconnect"),
          }).then((result) => {
            if (result.isConfirmed) {
              const ajaxData = {
                action: "scfs_arnelioconnect_delete_date_transient_admin",
                transient_name: transientName,
                security: security,
              };

              fetch(ajax_url, {
                method: "POST",
                credentials: "same-origin",
                headers: {
                  "Content-Type":
                    "application/x-www-form-urlencoded; charset=utf-8",
                },
                body: new URLSearchParams(ajaxData),
              })
                .then((response) => response.json())
                .then((data) => {
                  if (data.success) {
                    // Actualizar la interfaz si es necesario
                    setTimeout(() => {
                      // Obtén el formulario y envíalo
                      const form = document.getElementById(id_form);
                      if (form && form.tagName === "FORM") {
                        HTMLFormElement.prototype.submit.call(form);
                      } else {
                        console.error(__("An error occurred.", "arnelioconnect"));
                      }
                    }, 500);
                  } else {
                    Swal.fire(
                      "Error",
                      __("The process could not be stopped.", "arnelioconnect"),
                      "error"
                    );
                  }
                })
                .catch((error) => {
                  Swal.fire(
                    "Error",
                    __("An error occurred.", "arnelioconnect"),
                    "error"
                  );
                });
            }
          });
        });
      }
    }
  });
};

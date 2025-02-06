/**
 * Inicializa los campos de fecha y hora para comparar
 *
 * @param {string[]} compareTimeField
 */
export const compareTimeFieldField = (
  compareTimeField,
  { __, _e, _n, sprintf },
  Swal,
  id_form,
  post_id,
  name_field_options,
  security,
  ajax_url
) => {
  // Campos de fecha y hora
  compareTimeField.forEach((timeFieldName) => {

    const startDateInput = document.getElementById(
      `${timeFieldName}_start_date`
    );
    const startTimeInput = document.getElementById(
      `${timeFieldName}_start_time`
    );

    const endDateInput = document.getElementById(`${timeFieldName}_end_date`);
    const endTimeInput = document.getElementById(`${timeFieldName}_end_time`);
    const deleteButton = document.getElementById(
      `${timeFieldName}_delete_value`
    );
    const finished_button = document.getElementById(
      `${timeFieldName}_finished_value`
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

      // Función auxiliar para asignar el mismo evento a diferentes botones
      const addResetEventListener = (btn, title, text) => {
        btn.addEventListener("click", (e) => {
          e.preventDefault();
          Swal.fire({
            title: title,
            text: text,
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#cccccc",
            confirmButtonText: __("Yes", "arnelioconnect"),
            cancelButtonText: __("No", "arnelioconnect"),
          }).then((result) => {
            if (result.isConfirmed) {
              const ajaxData = {
                action: "scfs_arnelioconnect_delete_compare_time_field",
                security: security,
                field_name: timeFieldName,
                post_id: post_id,
                name_field_options: name_field_options,
              };
              const xhr = new XMLHttpRequest();
              xhr.open("POST", ajax_url, true);
              xhr.setRequestHeader(
                "Content-Type",
                "application/x-www-form-urlencoded; charset=utf-8"
              );
              xhr.onload = () => {
                if (xhr.status === 200) {
                  let data;
                  try {
                    data = JSON.parse(xhr.responseText);
                  } catch (err) {
                    Swal.fire(
                      "Error",
                      __("Invalid JSON response", "arnelioconnect"),
                      "error"
                    );
                    return;
                  }
                  if (data.success) {
                    location.reload();
                  } else {
                    Swal.fire(
                      "Error",
                      __("The process could not be stopped.", "arnelioconnect"),
                      "error"
                    );
                  }
                } else {
                  Swal.fire(
                    "Error",
                    __("An error occurred.", "arnelioconnect"),
                    "error"
                  );
                }
              };
              xhr.send(new URLSearchParams(ajaxData).toString());
            }
          });
        });
      };

      // Asignar el mismo comportamiento a deleteButton y finished_button
      if (deleteButton) {
        let title = __("Are you sure?", "arnelioconnect");
        let text = __("This action will stop the process.", "arnelioconnect");
        addResetEventListener(deleteButton, title, text);
      }
      if (finished_button) {
        let title = __("Finished", "arnelioconnect");
        let text = __("Insert new date.", "arnelioconnect");
        addResetEventListener(finished_button, title, text);
      }
    }
  });
};

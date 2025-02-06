/**
 * Maneja la clase activa para grupos de cajas de verificación (checkboxes).
 * @param {Object} config Configuración del módulo
 * @param {string} config.nameFieldOptions Nombre base del campo para los checkboxes
 * @param {string[]} config.fieldGroups Array con los nombres de los grupos de checkboxes
 */
export const buttonInlineMulti = ({ nameFieldOptions, fieldGroups }) => {
  const handleCheckboxGroup = (groupName) => {
    const fieldsbuttonsMulti = document.querySelectorAll(
      `input[name="${nameFieldOptions}[${groupName}][]"]`
    );
    fieldsbuttonsMulti.forEach((fieldsbuttonMulti) => {
      fieldsbuttonMulti.addEventListener("change", () => {
        fieldsbuttonsMulti.forEach((checkbox) => {
          const label = document.querySelector(`label[for="${checkbox.id}"]`);
          if (label) {
            if (checkbox.checked) {
              label.classList.add("active");
            } else {
              label.classList.remove("active");
            }
          }
        });
      });
    });
  };

  // Inicializar todos los grupos
  fieldGroups.forEach(handleCheckboxGroup);
};

/**
 * Maneja la clase activa para grupos de botones radio
 * @param {Object} config Configuración del módulo
 * @param {string} config.nameFieldOptions Nombre base del campo para los botones
 * @param {string[]} config.fieldGroups Array con los nombres de los grupos de botones
 */
export const buttonInline = ({ nameFieldOptions, fieldGroups }) => {
  // Función helper para manejar un grupo específico
  const handleButtonGroup = (groupName) => {
    const buttons = document.querySelectorAll(
      `input[name="${nameFieldOptions}[${groupName}]"]`
    );

    buttons.forEach((button) => {
      button.addEventListener("change", () => {
        // Remover clase activa de todas las etiquetas del grupo
        const labels = document.querySelectorAll(
          `input[name="${nameFieldOptions}[${groupName}]"] + label`
        );
        labels.forEach(label => label.classList.remove("active"));

        // Añadir clase activa a la etiqueta seleccionada
        const selectedLabel = document.querySelector(`label[for="${button.id}"]`);
        if (selectedLabel) {
          selectedLabel.classList.add("active");
        }
      });
    });
  };

  // Inicializar todos los grupos
  fieldGroups.forEach(handleButtonGroup);
};

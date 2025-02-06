// CSS
import "../scss/scfs_arnelioconnect_plantilla.scss";

// Importa Popper.js
import { createPopper } from "@popperjs/core";

// Importaciones individuales de Bootstrap
import Alert from "bootstrap/js/dist/alert";
import BaseComponent from "bootstrap/js/dist/base-component";
import Button from "bootstrap/js/dist/button";
import Carousel from "bootstrap/js/dist/carousel";
import Collapse from "bootstrap/js/dist/collapse";
import Dropdown from "bootstrap/js/dist/dropdown";
import Modal from "bootstrap/js/dist/modal";
import Offcanvas from "bootstrap/js/dist/offcanvas";
//import Scrollspy from 'bootstrap/js/dist/scrollspy';
//import Tab from 'bootstrap/js/dist/tab';
import Toast from "bootstrap/js/dist/toast";
import Popover from "bootstrap/js/dist/popover";
import Tooltip from "bootstrap/js/dist/tooltip";

// Importa SweetAlert2
import Swal from "sweetalert2";


import { autoSaveClick } from "./auto_save_click.js";
import { autoSaveChange } from "./auto_save_change.js";

// Fields
import { buttonInline } from "../fields/button-inline/button-inline.js";
import { buttonInlineMulti } from "../fields/button-inline-multi/button-inline-multi.js";
import { dateTransientAdminField } from "../fields/date-transient-admin/date-transient-admin.js";
import { compareTimeFieldField } from "../fields/compare-time-field/compare-time-field.js";
import { imageWordpress } from "../fields/image-wordpress/image-wordpress.js";

const { __, _e, _n, sprintf } = wp.i18n;
const post_id = null;
const php_options = scfs_arnelioconnect_plantilla.php_options;
const security = scfs_arnelioconnect_plantilla.security;
const ajax_url = scfs_arnelioconnect_plantilla.ajax_url;
const id_form = scfs_arnelioconnect_plantilla.id_form;
const auto_save_click = scfs_arnelioconnect_plantilla.auto_save_click;
const auto_save_change = scfs_arnelioconnect_plantilla.auto_save_change;
const name_field_options = scfs_arnelioconnect_plantilla.name_field_options;
const field_buttons = scfs_arnelioconnect_plantilla.field_buttons;
const field_buttons_multi = scfs_arnelioconnect_plantilla.field_buttons_multi;
const dateTransientAdmin = scfs_arnelioconnect_plantilla.dateTransientAdmin;
const compareTimeField = scfs_arnelioconnect_plantilla.compareTimeField;

document.addEventListener("DOMContentLoaded", () => {
  console.log("scfs_arnelioconnect_plantilla.js");


  // AutoSave
  autoSaveClick({ auto_save_click, Swal, id_form });
  autoSaveChange({ auto_save_change, Swal, id_form });

  // Fields
  buttonInline({nameFieldOptions:name_field_options,fieldGroups:field_buttons});
  buttonInlineMulti({nameFieldOptions:name_field_options,fieldGroups:field_buttons_multi});
  dateTransientAdminField(dateTransientAdmin, { __, _e, _n, sprintf }, Swal, id_form, security, ajax_url);
  compareTimeFieldField(compareTimeField, { __, _e, _n, sprintf }, Swal, id_form, post_id, name_field_options, security, ajax_url);
  imageWordpress(id_form, { __ });

  // Box notice settings_updated
  const settingErrorSettingsUpdated = document.getElementById(
    "setting-error-settings_updated"
  );
  if (settingErrorSettingsUpdated) {
    // Aplicar clases de Bootstrap Toast al elemento
    settingErrorSettingsUpdated.classList.add("toast", "show");
    settingErrorSettingsUpdated.setAttribute("role", "alert");
    settingErrorSettingsUpdated.setAttribute("aria-live", "assertive");
    settingErrorSettingsUpdated.setAttribute("aria-atomic", "true");

    // Inicializar el Toast
    const toast = new Toast(settingErrorSettingsUpdated, {
      autohide: true,
      delay: 2000, // Tiempo en milisegundos antes de ocultar el Toast
    });
    toast.show();
  }


  
});



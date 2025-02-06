//  CSS
import '../scss/scfs_arnelioconnect_alimentacion_item.scss';


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
import { compareTimeFieldField } from "../fields/compare-time-field/compare-time-field.js";
import { imageWordpress } from "../fields/image-wordpress/image-wordpress.js";
import { buttonToggle } from "../fields/button-toggle/button-toggle.js";

const { __, _e, _n, sprintf } = wp.i18n;
const post_id = scfs_arnelioconnect_alimentacion_item.post_id;
const php_options = scfs_arnelioconnect_alimentacion_item.php_options;
const security = scfs_arnelioconnect_alimentacion_item.security;
const ajax_url = scfs_arnelioconnect_alimentacion_item.ajax_url;
const id_form = scfs_arnelioconnect_alimentacion_item.id_form;
const auto_save_click = scfs_arnelioconnect_alimentacion_item.auto_save_click;
const auto_save_change = scfs_arnelioconnect_alimentacion_item.auto_save_change;
const name_field_options = scfs_arnelioconnect_alimentacion_item.name_field_options;
const field_buttons = scfs_arnelioconnect_alimentacion_item.field_buttons;
const field_buttons_multi = scfs_arnelioconnect_alimentacion_item.field_buttons_multi;
const compareTimeField = scfs_arnelioconnect_alimentacion_item.compareTimeField;


console.log('scfs_arnelioconnect_alimentacion_item.js')

const updateClasses = (element, removeClasses, addClasses) => {
    if (element) {
        element.classList.remove(...removeClasses);
        element.classList.add(...addClasses);
    }
};

document.addEventListener('DOMContentLoaded', function() {


    // AutoSave
    autoSaveClick({ auto_save_click, Swal, id_form });
    autoSaveChange({ auto_save_change, Swal, id_form });

    // Fields
    buttonInline({nameFieldOptions:name_field_options,fieldGroups:field_buttons});
    buttonInlineMulti({nameFieldOptions:name_field_options,fieldGroups:field_buttons_multi});
    compareTimeFieldField(compareTimeField, { __, _e, _n, sprintf }, Swal, id_form, post_id, name_field_options, security, ajax_url);
    imageWordpress(id_form, { __ });
    buttonToggle({ Swal, id_form });


    // Añade el contenedor principal
    const wpbodyContent = document.getElementById('wpbody-content');
    if (wpbodyContent) {
        updateClasses(wpbodyContent, [], ['container','container-page-arnelio']);
    }

    const screenMeta = document.getElementById('screen-meta');
    const pageTitleAction = document.querySelector('.page-title-action');
    const publish = document.getElementById('publish');
    const submitdelete = document.querySelector('.submitdelete');
    const alimentacionCatAddSubmit = document.getElementById('alimentacion-cat-add-submit');

    updateClasses(screenMeta, ['metabox-prefs'], []);
    updateClasses(publish, ['button', 'button-primary', 'button-large'], ['btn', 'btn-primary']);
    updateClasses(submitdelete, ['submitdelete', 'deletion'], ['btn', 'btn-box-arnelio']);
    updateClasses(alimentacionCatAddSubmit, ['button'], ['btn', 'btn-outline-secondary']);

    if (pageTitleAction) {
        pageTitleAction.style.visibility = 'hidden';
    }

    // Selecciona todos los inputs de tipo checkbox y radio
    const checkboxesAndRadios = document.querySelectorAll('input[type="checkbox"], input[type="radio"]');
    const updateClassesCheckRadio = (element) => {
        if (element) {
            element.classList.add('form-check-input'); // Añade la nueva clase
        }
    };
    checkboxesAndRadios.forEach(updateClassesCheckRadio);


    // Box notice settings_updated
    const message = document.getElementById('message');
    if (message) {
        // Aplicar clases de Bootstrap Toast al elemento
        message.classList.add('toast', 'show');
        message.setAttribute('role', 'alert');
        message.setAttribute('aria-live', 'assertive');
        message.setAttribute('aria-atomic', 'true');

        // Inicializar el Toast
        const toast = new Toast(message, {
            autohide: true,
            delay: 2000 // Tiempo en milisegundos antes de ocultar el Toast
        });
        toast.show();
    }





});

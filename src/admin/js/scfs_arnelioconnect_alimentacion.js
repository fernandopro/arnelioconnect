// Importa Popper.js
import { createPopper } from '@popperjs/core';
//import * as bootstrap from 'bootstrap';


import Alert from 'bootstrap/js/dist/alert';
import BaseComponent from 'bootstrap/js/dist/base-component';
import Button from 'bootstrap/js/dist/button';
import Carousel from 'bootstrap/js/dist/carousel';
import Collapse from 'bootstrap/js/dist/collapse';
import Dropdown from 'bootstrap/js/dist/dropdown';
import Modal from 'bootstrap/js/dist/modal';
import Offcanvas from 'bootstrap/js/dist/offcanvas';
//import Scrollspy from 'bootstrap/js/dist/scrollspy';
//import Tab from 'bootstrap/js/dist/tab';
import Toast from 'bootstrap/js/dist/toast';
import Popover from 'bootstrap/js/dist/popover';
import Tooltip from 'bootstrap/js/dist/tooltip';

// Importa SweetAlert2
import Swal from 'sweetalert2';

//  CSS
import '../scss/scfs_arnelioconnect_alimentacion.scss';

console.log('scfs_arnelioconnect_alimentacion.js')

const { __,_e,_n,sprintf } = wp.i18n;


const updateClasses = (element, removeClasses, addClasses) => {
    if (element) {
        element.classList.remove(...removeClasses);
        element.classList.add(...addClasses);
    }
};

document.addEventListener('DOMContentLoaded', () => {

    // Añade el contenedor principal
    const wpbodyContent = document.getElementById('wpbody-content','bg-body','rounded','shadow-sm');
    if (wpbodyContent) {
        updateClasses(wpbodyContent, [], ['container','container-page-arnelio']);
    }
    // Selecciona los elementos con la clase 'button'
    const pageTitleAction = document.querySelector('.page-title-action');
    if (pageTitleAction) {
        updateClasses(pageTitleAction, ['page-title-action'], ['btn', 'btn-primary']);
    }
    const doaction           = document.getElementById('doaction');
    const doaction2          = document.getElementById('doaction2');
    const postQuerySubmit    = document.getElementById('post-query-submit');
    const delete_all    = document.getElementById('delete_all');
    const searchSubmit       = document.getElementById('search-submit');
    const btnSave            = document.querySelector('.button.save');
    const btnCancel          = document.querySelector('.button.cancel');
    const showSettingsLink   = document.getElementById('show-settings-link');
    const screenOptionsApply = document.getElementById('screen-options-apply');


      // primer array de clases a eliminar, segundo array de clases a añadir
    updateClasses(btnSave, ['button', 'button-primary'], ['btn', 'btn-primary']);
    updateClasses(doaction, ['button', 'button-primary'], ['btn', 'btn-outline-secondary']);
    updateClasses(doaction2, ['button', 'button-primary'], ['btn', 'btn-outline-secondary']);
    updateClasses(postQuerySubmit, ['button', 'button-primary'], ['btn', 'btn-outline-secondary']);
    updateClasses(delete_all, ['button'], ['btn', 'btn-box-arnelio']);
    updateClasses(searchSubmit, ['button', 'button-primary'], ['btn', 'btn-outline-secondary']);
    updateClasses(btnCancel, ['button', 'button-primary'], ['btn', 'btn-outline-secondary']);
    updateClasses(showSettingsLink, ['button', 'button-primary'], ['btn', 'btn-outline-secondary']);
    updateClasses(screenOptionsApply, ['button', 'button-primary'], ['btn', 'btn-primary']);

    // Selecciona los elementos Select'
    const selects = document.querySelectorAll('select');
    const updateClassesInput = (element) => {
        if (element) {
            element.className = ''; // Elimina todas las clases
            element.classList.add('form-select'); // Añade la nueva clase
        }
    };
    selects.forEach(updateClassesInput);
    

    // Selecciona todos los inputs de tipo checkbox y radio
    const checkboxesAndRadios = document.querySelectorAll('input[type="checkbox"], input[type="radio"]');
    const updateClassesCheckRadio = (element) => {
        if (element) {
            element.classList.add('form-check-input'); // Añade la nueva clase
        }
    };
    checkboxesAndRadios.forEach(updateClassesCheckRadio);



});

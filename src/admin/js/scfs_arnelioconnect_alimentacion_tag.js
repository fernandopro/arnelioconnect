// Importa Popper.js
import { createPopper } from '@popperjs/core';
//import * as bootstrap from 'bootstrap';


// Importaciones individuales de Bootstrap
import Alert from 'bootstrap/js/dist/alert';
import BaseComponent from 'bootstrap/js/dist/base-component';
// import Button from 'bootstrap/js/dist/button';
// import Carousel from 'bootstrap/js/dist/carousel';
// import Collapse from 'bootstrap/js/dist/collapse';
// import Dropdown from 'bootstrap/js/dist/dropdown';
// import Modal from 'bootstrap/js/dist/modal';
import Offcanvas from 'bootstrap/js/dist/offcanvas';
//import Scrollspy from 'bootstrap/js/dist/scrollspy';
//import Tab from 'bootstrap/js/dist/tab';
// import Toast from 'bootstrap/js/dist/toast';
// import Popover from 'bootstrap/js/dist/popover';
// import Tooltip from 'bootstrap/js/dist/tooltip';

//  CSS
import '../scss/scfs_arnelioconnect_alimentacion_tag.scss';

console.log('scfs_arnelioconnect_alimentacion_tag.js')

const { __,_e,_n,sprintf } = wp.i18n;
    
const updateClasses = (element, removeClasses, addClasses) => {
    if (element) {
        element.classList.remove(...removeClasses);
        element.classList.add(...addClasses);
    }
};

// Current en el menu lateral de wordpress
const idMenu = document.querySelector('#toplevel_page_scfs_arnelioconnect_dashboard .wp-submenu');
const menuCurrent = idMenu.childNodes[4];
menuCurrent.classList.add('current');



document.addEventListener('DOMContentLoaded', () => {


        // Añade el contenedor principal
        const wpbodyContent = document.getElementById('wpbody-content');
        if (wpbodyContent) {
            updateClasses(wpbodyContent, [], ['container','container-page-arnelio']);
        }
        const submit = document.getElementById('submit');
        const searchSubmit = document.getElementById('search-submit');
        const doaction = document.getElementById('doaction');
        const doaction2 = document.getElementById('doaction2');
        const btnSave = document.querySelector('.button.save');
        const btnCancel = document.querySelector('.button.cancel');
        const screenOptionsApply = document.getElementById('screen-options-apply');
        const editTagButton = document.querySelector('.edit-tag-actions input[type="submit"]');
        

    
        updateClasses(submit, ['button', 'button-primary'], ['btn', 'btn-primary']);
        updateClasses(doaction, ['button', 'button-primary'], ['btn', 'btn-outline-secondary']);
        updateClasses(doaction2, ['button', 'button-primary'], ['btn', 'btn-outline-secondary']);
        updateClasses(searchSubmit, ['button', 'button-primary'], ['btn', 'btn-outline-secondary']);
        updateClasses(btnSave, ['button', 'button-primary'], ['btn', 'btn-primary']);
        updateClasses(btnCancel, ['button', 'button-primary'], ['btn', 'btn-outline-secondary']);
        updateClasses(screenOptionsApply, ['button', 'button-primary'], ['btn', 'btn-primary']);
        updateClasses(editTagButton, ['button', 'button-primary'], ['btn', 'btn-primary']);


            // Selecciona todos los Selects
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


        // Seleccionar todos los toggles de dropdown
        const dropdownToggles = document.querySelectorAll('.nav-item.dropdown .nav-link.dropdown-toggle');

        // Añadir eventos a cada toggle de dropdown
        dropdownToggles.forEach((toggle) => {
            const dropdownMenu = toggle.nextElementSibling;

            if (dropdownMenu) {
                // Manejar el evento de clic en el toggle
                toggle.addEventListener('click', (event) => {
                    event.preventDefault();

                    const isOpen = dropdownMenu.classList.contains('show');

                    // Cerrar todos los dropdowns abiertos
                    closeAllDropdowns();

                    // Si el dropdown no estaba abierto, abrirlo
                    if (!isOpen) {
                        dropdownMenu.classList.add('show');
                    }
                    // Si estaba abierto, ya se cerró con closeAllDropdowns()
                });
            }
        });

        // Función para cerrar todos los dropdowns
        const closeAllDropdowns = () => {
            const openDropdowns = document.querySelectorAll('.dropdown-menu.show');
            openDropdowns.forEach((menu) => {
                menu.classList.remove('show');
            });
        };

        // Cerrar los dropdowns al hacer clic fuera de ellos
        document.addEventListener('click', (event) => {
            if (!event.target.closest('.nav-item.dropdown')) {
                closeAllDropdowns();
            }
        });

        // Cerrar el dropdown al hacer clic en un enlace interno
        const dropdownMenus = document.querySelectorAll('.dropdown-menu');
        dropdownMenus.forEach((menu) => {
            const dropdownLinks = menu.querySelectorAll('a');
            dropdownLinks.forEach((link) => {
                link.addEventListener('click', () => {
                    menu.classList.remove('show');
                });
            });
        });


});
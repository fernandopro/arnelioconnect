import Tab from "bootstrap/js/dist/tab";
import Alert from "bootstrap/js/dist/alert";
import Tooltip from "bootstrap/js/dist/tooltip";

// Importa SweetAlert2
import Swal from "sweetalert2";
const { __, _e, _n, sprintf } = wp.i18n;

console.log("scfs_arnelioconnect_all_offcanvas.js");

document.addEventListener("DOMContentLoaded", () => {
  //TABS DIMÁMICOS CON BOOTSTRAP 5
  /**
   * Activates a tab based on the given hash.
   *
   * @param {string} hash - The hash of the tab to activate.
   */
  const activateTab = (hash) => {
    const triggerEl = document.querySelector(`.nav-link[href="${hash}"]`);
    if (triggerEl) {
      const tab = new Tab(triggerEl);
      tab.show();

      // Si el enlace está dentro de un dropdown, activamos el dropdown padre
      const dropdownMenu = triggerEl.closest(".dropdown-menu");
      if (dropdownMenu) {
        const dropdownToggle = dropdownMenu.previousElementSibling;
        if (
          dropdownToggle &&
          dropdownToggle.classList.contains("dropdown-toggle")
        ) {
          dropdownToggle.classList.add("active");
        }
      }
    }
  };

  // Inicializar la pestaña activa al cargar la página
  const hash = window.location.hash;
  if (hash) {
    activateTab(hash);
  }

  const navArnelioCurrent = document.getElementById("nav-arnelio-current");

  // Escuchar cambios en el hash
  window.addEventListener("hashchange", () => {
    const newHash = window.location.hash.replace("#", ""); // Eliminar el '#' al principio del string

    // Agregamos la condición para evitar actualizar si newHash está vacío
    if (newHash !== "") {
      navArnelioCurrent.value = newHash;
    }

    activateTab(`#${newHash}`);
  });

  // Seleccionar el navbar-toggler (Mobile)
  const navbarToggler = document.querySelector(".navbar-toggler");
  const arnelioconnectNavbar = document.getElementById("arnelioconnectNavbar");
  if (navbarToggler) {
    navbarToggler.addEventListener("click", () => {
      arnelioconnectNavbar.classList.toggle("show");
    });
  }


  // API de WordPress
  const textNotificationEmpty = `<div class="container-notification__empty"><svg width="91" height="74" viewBox="0 0 91 74" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M89.2969 65.4062C90.4219 66.3438 90.5625 67.4219 89.7188 68.6406L86.9062 72.1562C85.9688 73.2812 84.9375 73.4219 83.8125 72.5781L0.984375 8.59375C-0.140625 7.65625 -0.28125 6.57813 0.5625 5.35938L3.375 1.84375C4.3125 0.71875 5.34375 0.578125 6.46875 1.42188L26.8594 17.1719C30.3281 12.5781 34.9219 9.67188 40.6406 8.45312V5.5C40.6406 4.28125 41.0625 3.25 41.9062 2.40625C42.8438 1.46875 43.9219 1 45.1406 1C46.3594 1 47.3906 1.46875 48.2344 2.40625C49.1719 3.25 49.6406 4.28125 49.6406 5.5V8.45312C54.8906 9.48437 59.2031 12.0156 62.5781 16.0469C65.9531 20.0781 67.6406 24.8125 67.6406 30.25C67.6406 34.375 68.1094 38.0312 69.0469 41.2188C69.9844 44.3125 70.8281 46.4219 71.5781 47.5469C72.4219 48.6719 73.5469 49.9375 74.9531 51.3438C75.1406 51.625 75.2812 51.8125 75.375 51.9062C76.2188 52.8438 76.6406 53.875 76.6406 55C76.6406 55.0938 76.5938 55.2344 76.5 55.4219C76.5 55.5156 76.5 55.5625 76.5 55.5625L89.2969 65.4062ZM22.2188 36.4375L52.1719 59.5H18.1406C17.2969 59.5 16.5 59.3125 15.75 58.9375C15.0938 58.4688 14.5781 57.9062 14.2031 57.25C13.8281 56.5 13.6406 55.75 13.6406 55C13.6406 53.875 14.0625 52.8438 14.9062 51.9062C16.2188 50.5 17.1562 49.4688 17.7188 48.8125C18.2812 48.1562 19.0781 46.6562 20.1094 44.3125C21.1406 41.9688 21.8438 39.3438 22.2188 36.4375ZM45.1406 73C42.7031 73 40.5938 72.1094 38.8125 70.3281C37.0312 68.6406 36.1406 66.5312 36.1406 64H54.1406C54.1406 65.5938 53.7188 67.0938 52.875 68.5C52.125 69.9062 51.0469 70.9844 49.6406 71.7344C48.2344 72.5781 46.7344 73 45.1406 73Z" fill="#E2E4E9"></path></svg></div>`;


  const container = document.getElementById("arnelioconnect-notifications");
  const containerUnread = document.getElementById("arnelioconnect-notifications-unread");
  const containerRead = document.getElementById("arnelioconnect-notifications-read");
  const notificationApiButton = document.getElementById("notification-api");
  const notificationApiNum = document.getElementById("notification-api-num");
  const notificationApiNum2 = document.getElementById("notification-api-num2");
  const offcanvas_dismiss = document.getElementById("offcanvas_dismiss");

  // Actualizar el badge al cargar la página
  if (notificationApiNum && typeof all_js.posts_count !== "undefined") {
    if (all_js.posts_count > 0) {
      notificationApiNum.textContent = all_js.posts_count;
      notificationApiNum.style.display = "inline-block";
    } else {
      notificationApiNum.style.display = "none";
    }
  }

  if (notificationApiNum2 && typeof all_js.posts_count !== "undefined") {
    if (all_js.posts_count > 0) {
      notificationApiNum2.textContent = all_js.posts_count;
      notificationApiNum2.style.display = "inline-block";
    } else {
      notificationApiNum2.style.display = "none";
    }
  }

  if (notificationApiButton) {
    notificationApiButton.addEventListener("click", () => {
      // Verificar que container no sea nulo
      if (container && container.innerHTML === "") {
        if (all_js.posts.length > 0) {
          let html = "";
          all_js.posts.forEach((post) => {
            const title = post.title;
            const link = post.link;
            const relativeDate = post.relative_time;
            // Construir el HTML utilizando clases de Bootstrap
            html += `
                    <div class="post-item-content">
                        <div class="post-item-icon">
                      <i class="bi bi-bookmarks-fill"></i>
                        </div>
                        <div class="post-item mb-4">
                                <div class="title-data">
                                <a class="link-secondary title-data_link" href="${link}" target="_blank">${title}</a>
                                <span class="title-data_date text-body-secondary">${relativeDate}</span>
                                </div>
                                <div class="post-item_body text-body-secondary">
                                    <p>${post.excerpt}</p>
                                </div>
                                <a href="${link}" target="_blank" class="btn btn-outline-secondary">${all_js.messages.m2}</a>
                            </div>
                    </div>
                        `;
          });
          // Insertar el HTML en el contenedor
          container.innerHTML = html;
        } else {
          container.innerHTML = textNotificationEmpty;
        }
      }
    });
  }

  const alertPlaceholder = document.getElementById(
    "arnelioconnect-alert-placeholder"
  );
  const notificationUpdateButton = document.getElementById(
    "notification-update"
  );
  const notificationUpdateIcon = document.getElementById(
    "notification-update-icon"
  );
  const notificationUpdateLoader = document.getElementById(
    "notification-update-loader"
  );

  const tooltipTriggerList = document.querySelectorAll(
    '[data-bs-toggle="tooltip"]'
  );
  const tooltipList = [...tooltipTriggerList].map(
    (tooltipTriggerEl) => new Tooltip(tooltipTriggerEl)
  );

  // Asegurar que el botón loader esté oculto inicialmente
  if (notificationUpdateLoader) {
    notificationUpdateLoader.style.display = "none";
  }

  if (notificationUpdateButton && notificationUpdateLoader) {
    notificationUpdateButton.addEventListener("click", () => {
        notificationUpdateIcon.style.display = "none";
        notificationUpdateLoader.style.display = "inline-block";

        const minTime = new Promise((resolve) => setTimeout(resolve, 2000));

        const ajaxRequest = fetch(all_js.ajaxurl, {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded; charset=UTF-8",
            },
            body: new URLSearchParams({
                action: "scfs_arnelioconnect_clear_transients",
                _wpnonce: all_js.nonce,
            }),
        }).then((response) => response.json());

        Promise.all([ajaxRequest, minTime])
            .then(([data]) => {
                notificationUpdateLoader.style.display = "none";
                notificationUpdateIcon.style.display = "inline-block";

                if (data.success) {
                    // Actualizar los arrays locales con los nuevos datos
                    unreadPosts.length = 0; // Vaciar array actual
                    readPosts.length = 0;
                    
                    // Llenar con nuevos datos
                    unreadPosts.push(...data.data.unread);
                    readPosts.push(...data.data.read);

                    // Actualizar UI
                    renderUnreadPosts();
                    renderReadPosts();

                    // Actualizar badge
                    if (notificationApiNum) {
                        if (unreadPosts.length > 0) {
                            notificationApiNum.textContent = unreadPosts.length;
                            notificationApiNum.style.display = "inline-block";
                        } else {
                            notificationApiNum.style.display = "none";
                        }
                    }
                    if (notificationApiNum2) {
                      if (unreadPosts.length > 0) {
                        notificationApiNum2.textContent = unreadPosts.length;
                        notificationApiNum2.style.display = "inline-block";
                      } else {
                        notificationApiNum2.style.display = "none";
                      }
                  }
                }
            })
            .catch((error) => {
                console.error(error);
                showBootstrapAlert("Ha ocurrido un error.", "danger");
                notificationUpdateLoader.style.display = "none";
                notificationUpdateIcon.style.display = "inline-block";
            });
    });
  }

  // Variables para posts no leídos y leídos 
  const unreadPosts = all_js.posts.unread || [];
  const readPosts = all_js.posts.read || [];

  // Función para renderizar los posts no leídos
  const renderUnreadPosts = () => {
    if (unreadPosts.length > 0) {
      let htmlUnread = "";
      unreadPosts.forEach((post, index) => {
        htmlUnread += `
          <div class="post-item-content" data-post-index="${index}">
            <div class="post-item-icon">
              <i class="bi bi-bookmarks-fill"></i>
            </div>
            <div class="post-item mb-4">
              <div class="title-data">
                <a class="link-secondary title-data_link" data-post-index="${index}" href="${post.link}">${post.title}</a>
                <span class="title-data_date text-body-secondary">${post.relative_time}</span>
              </div>
              <div class="post-item_body text-body-secondary">
                <p>${post.excerpt}</p>
              </div>
              <a href="${post.link}" class="btn btn-outline-secondary read-post" data-post-index="${index}">${all_js.messages.m2}</a>
            </div>
          </div>
        `;
      });
      containerUnread.innerHTML = htmlUnread;
    } else {
      containerUnread.innerHTML = textNotificationEmpty;
    }
  };

  // Función para renderizar los posts leídos
  const renderReadPosts = () => {
    if (readPosts.length > 0) {
      let htmlRead = "";
      readPosts.forEach((post) => {
        htmlRead += `
          <div class="post-item-content">
            <div class="post-item-icon">
              <i style="opacity:0.7" class="bi bi-bookmarks-fill"></i>
            </div>
            <div class="post-item mb-4">
              <div class="title-data">
                <div class="link-secondary title-data_link read">${post.title}</div>
              </div>
              <div class="post-item_body text-body-secondary">
                <p>${post.excerpt}</p>
              </div>
              <a href="${post.link}" target="_blank" class="btn btn-outline-secondary">${all_js.messages.m2}</a>
            </div>
          </div>
        `;
      });
      containerRead.innerHTML = htmlRead;
    } else {
      containerRead.innerHTML = textNotificationEmpty;
    }
  };

  // Inicializar contenido
  renderUnreadPosts();
  renderReadPosts();

  // Actualizar el badge con el número de posts no leídos
  if (notificationApiNum) {
    if (unreadPosts.length > 0) {
      notificationApiNum.textContent = unreadPosts.length;
      notificationApiNum.style.display = "inline-block";
    } else {
      notificationApiNum.style.display = "none";
    }
  }
  if (notificationApiNum2) {
    if (unreadPosts.length > 0) {
      notificationApiNum2.textContent = unreadPosts.length;
      notificationApiNum2.style.display = "inline-block";
    } else {
      notificationApiNum2.style.display = "none";
    }
  }

  // Actualizar la UI cuando se marca como leído
  document.addEventListener("click", async (e) => {
    if (e.target && (e.target.classList.contains("read-post") || e.target.classList.contains("title-data_link"))) {
      e.preventDefault(); // Prevenir la apertura automática
      const index = e.target.getAttribute("data-post-index");
      const selectedPost = unreadPosts[index];
      if (!selectedPost) return;

      try {
        const formData = new URLSearchParams();
        formData.append("action", "scfs_arnelioconnect_mark_as_read");
        formData.append("post_id", selectedPost.id);
        formData.append("_wpnonce", all_js.nonce);
        await fetch(all_js.ajaxurl, {
          method: "POST",
          headers: { "Content-Type": "application/x-www-form-urlencoded" },
          body: formData
        });

        // Mover post de no leídos a leídos
        unreadPosts.splice(index, 1);
        readPosts.unshift(selectedPost);

        // Actualizar UI
        renderUnreadPosts();
        renderReadPosts();

        // Actualizar badge
        if (notificationApiNum) {
          if (unreadPosts.length === 0) {
            notificationApiNum.style.display = "none";
          } else {
            notificationApiNum.textContent = unreadPosts.length;
          }
        }
        if (notificationApiNum2) {
          if (unreadPosts.length === 0) {
            notificationApiNum2.style.display = "none";
          } else {
            notificationApiNum2.textContent = unreadPosts.length;
          }
        }

        // Abrir enlace después de procesar todo
        window.open(selectedPost.link, "_blank");
      } catch (error) {
        console.error(error);
      }
    }
  });

  /**
   * Muestra una alerta de Bootstrap en el contenedor especificado.
   *
   * @param {string} message - Mensaje a mostrar.
   * @param {string} type - Tipo de alerta ('success', 'danger', etc.).
   */
  const showBootstrapAlert = (message, type) => {
    if (alertPlaceholder) {
      const wrapper = document.createElement("div");
      wrapper.innerHTML = `
                <div class="alert alert-${type} alert-dismissible fade show mt-3" role="alert">
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            `;
      alertPlaceholder.append(wrapper);

      // Inicializar el componente de alerta de Bootstrap
      const alertElement = wrapper.querySelector(".alert");
      const bsAlert = new Alert(alertElement);

      // Cerrar la alerta automáticamente después de 2 segundos
      setTimeout(() => {
        bsAlert.close();
      }, 2000);
    }
  };

  // Función para marcar todos los posts como leídos
  const markAllAsRead = async () => {
    // Mostrar confirmación con SweetAlert2
    const result = await Swal.fire({
      title: __('¿Mark all as read?', 'arnelioconnect'),
      text: __('This action cannot be undone', 'arnelioconnect'),
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#cccccc',
      confirmButtonText: __('Yes', 'arnelioconnect'),
      cancelButtonText: __('Cancel', 'arnelioconnect')
    });

    // Si el usuario confirma, proceder con el marcado
    if (result.isConfirmed) {
      try {
        const postsToMark = [...unreadPosts];
        
        // Procesar cada post no leído
        for (const post of postsToMark) {
          const formData = new URLSearchParams();
          formData.append("action", "scfs_arnelioconnect_mark_as_read");
          formData.append("post_id", post.id);
          formData.append("_wpnonce", all_js.nonce);
          
          await fetch(all_js.ajaxurl, {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: formData
          });
        }

        // Mover todos los posts no leídos a leídos
        readPosts.unshift(...unreadPosts);
        unreadPosts.length = 0;

        // Actualizar UI
        renderUnreadPosts();
        renderReadPosts();

        // Actualizar badges
        if (notificationApiNum) {
          notificationApiNum.style.display = "none";
        }
        if (notificationApiNum2) {
          notificationApiNum2.style.display = "none";
        }

        // Mostrar mensaje de éxito
        Swal.fire({
          title: __('Success!', 'arnelioconnect'),
          text: __('All notifications have been dismissed', 'arnelioconnect'),
          icon: 'success',
          timer: 2000,
          showConfirmButton: false
        });

      } catch (error) {
        console.error(error);
        Swal.fire({
          title: __('Error!', 'arnelioconnect'),
          text: __('An error occurred while dismissing notifications', 'arnelioconnect'),
          icon: 'error'
        });
      }
    }
  };

  // Agregar evento al botón dismiss
  if (offcanvas_dismiss) {
    offcanvas_dismiss.addEventListener("click", async (e) => {
      e.preventDefault();
      await markAllAsRead();
    });
  }
});

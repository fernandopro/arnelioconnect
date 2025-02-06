<?php

/**
 * The admin-specific functionality of the plugin.
 *
 */

class Arnelioconnect_Admin {

	private $plugin_name;

	private $version;

	// Constructor
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}



	// MENU CABECERA
	public function cabecera_arnelioconnect(){
		global $menu, $submenu;

		$plugin_slug = 'scfs_arnelioconnect_dashboard';
		$plugin_menu_items = [];

		// Crear el menú automáticamente a partir de los elementos de menú del plugin
		if ( isset( $submenu[ $plugin_slug ] ) ) {
			foreach ( $submenu[ $plugin_slug ] as $sub_item ) {
				// Construir la URL usando la función auxiliar
				$url = $this->construct_menu_url( $sub_item[2] );
				$plugin_menu_items[] = [
					'title' => $sub_item[0],
					'slug'  => $sub_item[2],
					'url'   => $url
				];
			}
		}

		// $plugin_menu_items = [
		// 	[
		// 		'title' => __('Dashboard', 'arnelioconnect'),
		// 		'slug'  => 'scfs_arnelioconnect_dashboard',
		// 		'url'   => admin_url( 'admin.php?page=scfs_arnelioconnect_dashboard' )
		// 	],
		// 	[
		// 		'title' => __('Plantilla', 'arnelioconnect'),
		// 		'slug'  => 'scfs_arnelioconnect_plantilla',
		// 		'url'   => admin_url( 'admin.php?page=scfs_arnelioconnect_plantilla' )
		// 	],
		// 	[
		// 		'title' => __('Alimentos', 'arnelioconnect'),
		// 		'slug'  => 'post_type=alimentacion',
		// 		'url'   => admin_url( 'edit.php?post_type=alimentacion' )
		// 	],
		// 	[
		// 		'title' => __('Categorías', 'arnelioconnect'),
		// 		'slug'  => 'taxonomy=alimentacion-cat&post_type=alimentacion',
		// 		'url'   => admin_url( 'edit-tags.php?taxonomy=alimentacion-cat&post_type=alimentacion' )
		// 	]
		// ];


		// Definir los Items de menú que deben mostrar el badge pro. [0, 1, 2, ...]
		$badge_view = [2];
		$badge_pro = '<span class="badge-pro badge text-bg-secondary">PRO</span>';

		?>
		<div class="scfs-cabecera">
			<div class="container container-page-arnelio scfs-cabecera__content py-3">
				<div class="logo"><span class="logo1">Arnelioconnect</span><span class="logo2">Logo</span></div>
				<ul class="nav justify-content-end nav-logo">
					<li class="nav-item">
						<button id="notification-update" type="button" class="btn btn-outline-secondary">
							<i id="notification-update-icon" style="font-size: 1.3rem;" class="bi bi-arrow-repeat" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="<?php echo __('Update')?>"></i>
							<div style="padding:5px 2px 0 2px" id="notification-update-loader">
								<span class="spinner-border" style="width: 1.2rem; height: 1.2rem;display:inline-block" role="status"></span>
							</div>
						</button>
					</li>
					<li class="nav-item">
						<button type="button" id="notification-api" class="btn btn-secondary position-relative" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNotifications" aria-controls="offcanvasNotifications">
							<i style="font-size: 1.2rem;" class="bi bi-megaphone-fill" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="<?php echo __('News')?>"></i>
							<span id="notification-api-num" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
								<span class="visually-hidden">unread messages</span>
							</span>
						</button>
					</li>
				</ul>
			</div>
			<nav class="navbar bg-body navbar-expand-md p-0" data-bs-theme="light">
				<div class="container container-page-arnelio">
					<!-- logo movil -->
					<div class="logoMobile"><span class="logo1">Arnelioconnect</span><span class="logo2">Logo</span></div>
					<button class="navbar-toggler" type="button" aria-controls="arnelioconnectNavbar" aria-expanded="false" aria-label="<?php echo __('Toggle navigation', 'arnelioconnect'); ?>">
						<span class="navbar-toggler-icon"></span>
					</button>
					<div class="collapse navbar-collapse" id="arnelioconnectNavbar">
						<div class="navbar-nav">
							<?php 
							$count_array = count($plugin_menu_items);
							foreach ($plugin_menu_items as $index => $menu_item ) {
								// Verificar si la URL actual contiene el slug para resaltar el enlace activo
								$is_active = $this->is_active_menu_item( $menu_item );
							?>
								<a class="nav-link <?php echo esc_attr( $is_active ); ?> position-relative" href="<?php echo esc_url( $menu_item['url'] ); ?>">
								<?php echo esc_html( $menu_item['title'] ); ?>
								<?php if (in_array($index, $badge_view)) echo $badge_pro; ?>
								</a>
							<?php } ?>
							
							<div class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="#" type="button" data-bs-toggle="dropdown" aria-expanded="false">
									Dropdown
								</a>
								<ul class="dropdown-menu">
									<li><a class="dropdown-item" href="#"><?php echo __('Action', 'arnelioconnect'); ?> <?php echo $badge_pro; ?></a></li>
									<li><a class="dropdown-item" href="#"><?php echo __('Another action', 'arnelioconnect'); ?></a></li>
									<li><hr class="dropdown-divider"></li>
									<li><a class="dropdown-item" href="#"><?php echo __('Something else here', 'arnelioconnect'); ?></a></li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</nav>
			<div class="container_notices container-page-arnelio">
				<?php
					settings_errors();
					echo do_action('scfs_arnelioconnect_notices_all_header');
					?>
					<div id="arnelioconnect-alert-placeholder"></div>
			</div>
		</div>
		<?php
	}

	// Función auxiliar para construir la URL correcta del menú
	private function construct_menu_url( $slug ) {
		// Si el slug contiene 'edit.php?post_type=', es un Custom Post Type
		if ( strpos( $slug, 'edit.php?post_type=' ) === 0 ) {
			return admin_url( $slug );
		}
		// Si el slug contiene 'edit-tags.php?taxonomy=', es una Taxonomía
		elseif ( strpos( $slug, 'edit-tags.php?taxonomy=' ) === 0 ) {
			return admin_url( $slug );
		}
		// Si el slug contiene '=', asumimos que es una query personalizada
		elseif ( strpos( $slug, '=' ) !== false ) {
			return admin_url( $slug );
		}
		// En caso contrario, es una página del plugin
		else {
			return admin_url( 'admin.php?page=' . $slug );
		}
	}

	// Función auxiliar para determinar si un elemento del menú está activo
	private function is_active_menu_item( $menu_item ) {
		$current_url = esc_url( $_SERVER['REQUEST_URI'] );
		$menu_url = esc_url( $menu_item['url'] );

		// Convertir URLs a path sin protocolo ni dominio
		$current_path = parse_url( $current_url, PHP_URL_PATH ) . '?' . ( parse_url( $current_url, PHP_URL_QUERY ) ?? '' );
		$menu_path = parse_url( $menu_url, PHP_URL_PATH ) . '?' . ( parse_url( $menu_url, PHP_URL_QUERY ) ?? '' );

		// Escapar caracteres especiales para la expresión regular
		$menu_path_escaped = preg_quote( $menu_path, '/' );

		// Construir patrón de expresión regular
		$pattern = '/^' . $menu_path_escaped . '(&|$)/';

		// Verificar si la URL actual coincide con el patrón
		if ( preg_match( $pattern, $current_path ) ) {
			return 'active';
		}

		return '';
	}


	/**
	 * Elimina todos los avisos en el área de administración de WordPress.
	 */
	public function arnelioconnect_remove_all_notices() {
		// Verifica si el usuario tiene permisos de administrador
		if (defined('IS_URL_ARNELIOCONNECT') && IS_URL_ARNELIOCONNECT) {
			// Elimina todas las acciones asociadas al hook 'admin_notices'
			remove_all_actions('admin_notices');
			// Elimina todas las acciones asociadas al hook 'all_admin_notices'
			remove_all_actions('all_admin_notices');
		}
	}


		// Update plugin desde el exterior
		public function scfs_upgrader_process_complete($upgrader_object, $options) {
			$thisPlugin = 'arnelioconnect/arnelioconnect.php';
	
			if ($options['action'] == 'update' && $options['type'] == 'plugin' && isset( $options['plugins'])) {
				foreach( $options['plugins'] as $plugin ) {
					if( $plugin == $thisPlugin ) {
						error_log('UPDATE EXTERNAL - arnelioconnect : ' . __FILE__ . ' en la línea ' . __LINE__);
					}
	
	
				}
			}
		}
	
	
		// Update plugin desde un archivo ZIP
		public function scfs_upgrader_post_install($response, $hook_extra, $result) {
			$thisPlugin = 'arnelioconnect/arnelioconnect.php';
	
			if (isset($result['destination_name'])) {
				if ($result['destination_name'] == dirname($thisPlugin)) {
					error_log('UPDATE ZIP - arnelioconnect : ' . __FILE__ . ' en la línea ' . __LINE__);
				}
			}
	
			return $response;
		}



		// LINK Review in footer web for arnelioconnect
		public function scfs_arnelioconnect_brand_footer( $text ) {
			global $current_screen;
			if ($current_screen->parent_base == 'scfs_arnelioconnect_dashboard') {
				$url  = 'https://arnelio.com/downloads/arnelioconnect/#respond';
				$text = sprintf(
					wp_kses(
						__( 'Please rate %1s <a href="%2s" target="_blank" rel="noopener noreferrer">&#9733;&#9733;&#9733;&#9733;&#9733;</a> on <a href="%3s" target="_blank" rel="noopener">arnelio.com</a> to help us spread the word. Thank you from the Arnelio team!', 'arnelioconnect' ),
						[
							'a' => [
								'href'   => [],
								'target' => [],
								'rel'    => [],
							],
						]
					),
					'<strong>arnelioconnect</strong>',
					$url,
					$url
				);
				return '<div class="footerReview">'.$text.'</div>';	
			}else{
				return $text;
			}
		}


}

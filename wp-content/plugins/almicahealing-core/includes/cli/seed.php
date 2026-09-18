<?php
/**
 * `wp almicahealing seed` — idempotent content seeding.
 *
 * WordPress has no first-class equivalent of a Laravel migration/seeder
 * for content: data created via wp-cli in one environment (e.g. this
 * developer's VVV database) never reaches another (a teammate's VVV,
 * staging, production) on its own. This command is that missing piece —
 * it is version-controlled here and safe to run in any environment to
 * bring it up to the same baseline content: the servicio/curso/
 * testimonio posts, the Acerca de/Servicios pages, and the primary/
 * footer nav menus described in the Figma design.
 *
 * Safe to re-run: every seeded post carries a `_almicahealing_seed_key`
 * meta value and is looked up by that key, so re-running updates
 * existing content in place instead of duplicating it. Menus are only
 * populated the first time (an empty menu at that location) so it never
 * clobbers manual edits made afterward.
 *
 * Usage: wp almicahealing seed
 *
 * @package AlmicaHealingCore
 */

defined( 'ABSPATH' ) || exit;

if ( ! defined( 'WP_CLI' ) || ! WP_CLI ) {
	return;
}

/**
 * Inserts or updates a post by its stable seed key.
 *
 * @param string $seed_key Stable machine name, e.g. 'servicio-arteterapia'.
 * @param array  $postarr  Args for wp_insert_post()/wp_update_post().
 * @param array  $meta     Extra meta to set (besides the seed key itself).
 * @return int Post ID.
 */
function almicahealing_seed_post( $seed_key, array $postarr, array $meta = array() ) {
	$existing = get_posts(
		array(
			'post_type'      => $postarr['post_type'],
			'post_status'    => 'any',
			'posts_per_page' => 1,
			'meta_key'       => '_almicahealing_seed_key',
			'meta_value'     => $seed_key,
			'fields'         => 'ids',
		)
	);

	// Fall back to matching by title, so content created by hand (or by
	// an earlier ad-hoc wp-cli command) before this seed key existed
	// gets adopted in place instead of duplicated.
	if ( ! $existing && ! empty( $postarr['post_title'] ) ) {
		$existing = get_posts(
			array(
				'post_type'      => $postarr['post_type'],
				'post_status'    => 'any',
				'posts_per_page' => 1,
				'title'          => $postarr['post_title'],
				'fields'         => 'ids',
			)
		);
	}

	if ( $existing ) {
		$postarr['ID'] = $existing[0];
		wp_update_post( $postarr );
		$post_id = $existing[0];
	} else {
		$post_id = wp_insert_post( $postarr );
		update_post_meta( $post_id, '_almicahealing_seed_key', $seed_key );
	}

	foreach ( $meta as $meta_key => $meta_value ) {
		update_post_meta( $post_id, $meta_key, $meta_value );
	}

	return $post_id;
}

/**
 * Seeds a nav menu location only if it's currently empty, so re-running
 * the seeder never duplicates or overwrites manually edited menus.
 *
 * @param string $location Registered menu location (see inc/setup.php).
 * @param string $menu_name Menu name to create if the location has none.
 * @param array  $items Each: array( 'title', 'url' ) or array( 'title', 'object_id' => page ID ).
 */
function almicahealing_seed_menu( $location, $menu_name, array $items ) {
	$locations = get_nav_menu_locations();
	$menu      = ! empty( $locations[ $location ] ) ? wp_get_nav_menu_object( $locations[ $location ] ) : false;

	if ( ! $menu ) {
		$menu_id                = wp_create_nav_menu( $menu_name );
		$locations[ $location ] = $menu_id;
		set_theme_mod( 'nav_menu_locations', $locations );
		$menu = wp_get_nav_menu_object( $menu_id );
	}

	if ( $menu && wp_get_nav_menu_items( $menu->term_id ) ) {
		return; // Already populated — leave manual edits alone.
	}

	foreach ( $items as $item ) {
		$args = array(
			'menu-item-title'  => $item['title'],
			'menu-item-status' => 'publish',
		);
		if ( isset( $item['object_id'] ) ) {
			$args['menu-item-object']    = 'page';
			$args['menu-item-object-id'] = $item['object_id'];
			$args['menu-item-type']      = 'post_type';
		} else {
			$args['menu-item-url']  = $item['url'];
			$args['menu-item-type'] = 'custom';
		}
		wp_update_nav_menu_item( $menu->term_id, 0, $args );
	}
}

/**
 * Runs the seed.
 */
function almicahealing_seed_run() {
	// Pages.
	$acerca_de_id = almicahealing_seed_post(
		'page-acerca-de',
		array(
			'post_type'   => 'page',
			'post_title'  => 'Acerca de',
			'post_name'   => 'acerca-de',
			'post_status' => 'publish',
		)
	);
	$servicios_id = almicahealing_seed_post(
		'page-servicios',
		array(
			'post_type'   => 'page',
			'post_title'  => 'Servicios',
			'post_name'   => 'servicios',
			'post_status' => 'publish',
		)
	);

	// Servicios — full catalog order (Figma "Servicios" frame, node-id
	// 146-634); the featured six also appear in the Home teaser.
	$servicios = array(
		array( 'arteterapia', 'Arteterapia', true ),
		array( 'biodescodificacion', 'Biodescodificación', true ),
		array( 'constelacion-familiar', 'Constelación Familiar para el Trabajo', true ),
		array( 'armonizacion-energetica', 'Armonización Energética Laboral y Bloqueos Relacionados', true ),
		array( 'limpieza-energetica-lugares', 'Limpieza Energética de Lugares', false ),
		array( 'escaneo-balance-energetico', 'Escaneo y Balance Energético en Personas', true ),
		array( 'conexion-seres-trascendidos', 'Conexión con Seres Trascendidos', false ),
		array( 'conexion-registros', 'Conexión con Registros', true ),
		array( 'futuros-posibles', 'Futuros Posibles', false ),
		array( 'limpieza-conexion-personas', 'Limpieza y Conexión con Personas', false ),
		array( 'limpieza-conexion-emocional-personas', 'Limpieza y Conexión Emocional con Personas', false ),
	);
	foreach ( $servicios as $order => list( $key, $title, $featured ) ) {
		almicahealing_seed_post(
			"servicio-{$key}",
			array(
				'post_type'   => 'servicio',
				'post_title'  => $title,
				'post_status' => 'publish',
				'menu_order'  => $order + 1,
			),
			array( '_almicahealing_featured' => $featured ? '1' : '' )
		);
	}

	// Cursos (Figma "Courses" frame, node-id 146-200).
	$cursos = array(
		array( 'clantanra', 'Clantanra', 'Un programa de alta conexión interior para quienes buscan ampliar su percepción e intuición.' ),
		array( 'riutunmi', 'Riutunmi', 'Un espacio de formación para el desarrollo de la conciencia y la conexión con dimensiones más profundas del ser.' ),
		array( 'lo-que-nadie-nos-enseno', 'Lo Que Nadie Nos Enseñó', 'Herramientas prácticas para afrontar los desafíos cotidianos con mayor conciencia y equilibrio.' ),
	);
	foreach ( $cursos as $order => list( $key, $title, $excerpt ) ) {
		almicahealing_seed_post(
			"curso-{$key}",
			array(
				'post_type'    => 'curso',
				'post_title'   => $title,
				'post_excerpt' => $excerpt,
				'post_status'  => 'publish',
				'menu_order'   => $order + 1,
			)
		);
	}

	// Testimonios (Figma "Testimonials" frame, node-id 146-279).
	almicahealing_seed_post(
		'testimonio-valentina-r',
		array(
			'post_type'    => 'testimonio',
			'post_title'   => 'Valentina R.',
			'post_excerpt' => 'Biodescodificación',
			'post_content' => 'Llegué sin saber qué esperar y salí con una claridad que no había sentido en años. La sesión de biodescodificación fue un antes y un después en cómo entiendo mi cuerpo.',
			'post_status'  => 'publish',
			'menu_order'   => 1,
		)
	);

	// Nav menus (only populated if empty — see almicahealing_seed_menu()).
	almicahealing_seed_menu(
		'primary',
		'Menú principal',
		array(
			array(
				'title' => 'Inicio',
				'url'   => home_url( '/' ),
			),
			array(
				'title'     => 'Acerca de',
				'object_id' => $acerca_de_id,
			),
			array(
				'title'     => 'Servicios',
				'object_id' => $servicios_id,
			),
			array(
				'title' => 'Cursos',
				'url'   => home_url( '/#cursos' ),
			),
		)
	);
	almicahealing_seed_menu(
		'footer',
		'Menú de pie de página',
		array(
			array(
				'title'     => 'Acerca de',
				'object_id' => $acerca_de_id,
			),
			array(
				'title'     => 'Servicios',
				'object_id' => $servicios_id,
			),
			array(
				'title' => 'Cursos',
				'url'   => home_url( '/#cursos' ),
			),
		)
	);

	if ( '' === get_option( 'permalink_structure' ) ) {
		update_option( 'permalink_structure', '/%postname%/' );
		flush_rewrite_rules();
		WP_CLI::log( 'Permalink structure was empty — set to /%postname%/ and flushed rewrite rules.' );
	}

	WP_CLI::success( 'Seed complete.' );
}

WP_CLI::add_command( 'almicahealing seed', 'almicahealing_seed_run' );

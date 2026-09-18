<?php
/**
 * "Servicio" content type — the 11 individual service pages under
 * Servicios in the Figma sitemap (Arteterapia, Biodecodificación, etc.).
 *
 * @package AlmicaHealingCore
 */

defined( 'ABSPATH' ) || exit;

/**
 * Registers the `servicio` post type.
 */
function almicahealing_register_servicio() {
	register_post_type(
		'servicio',
		array(
			'labels'        => array(
				'name'               => __( 'Servicios', 'almicahealing' ),
				'singular_name'      => __( 'Servicio', 'almicahealing' ),
				'add_new_item'       => __( 'Añadir servicio', 'almicahealing' ),
				'edit_item'          => __( 'Editar servicio', 'almicahealing' ),
				'search_items'       => __( 'Buscar servicios', 'almicahealing' ),
				'not_found'          => __( 'No se encontraron servicios.', 'almicahealing' ),
				'not_found_in_trash' => __( 'No hay servicios en la papelera.', 'almicahealing' ),
			),
			'public'        => true,
			'has_archive'   => false,
			'show_in_rest'  => true,
			'menu_icon'     => 'dashicons-universal-access-alt',
			'menu_position' => 20,
			'supports'      => array( 'title', 'editor', 'excerpt', 'thumbnail', 'page-attributes' ),
			'rewrite'       => array( 'slug' => 'servicios' ),
		)
	);
}
add_action( 'init', 'almicahealing_register_servicio' );

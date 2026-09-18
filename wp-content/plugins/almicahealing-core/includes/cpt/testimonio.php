<?php
/**
 * "Testimonio" content type — the client-testimonial slider on the Home
 * page (Figma "Testimonials" section, node-id 146-279).
 *
 * @package AlmicaHealingCore
 */

defined( 'ABSPATH' ) || exit;

/**
 * Registers the `testimonio` post type.
 *
 * Title holds the client's name (e.g. "Valentina R."), the excerpt holds
 * the short service label shown under the name (e.g. "Biodescodificación"),
 * and the editor holds the quote itself.
 */
function almicahealing_register_testimonio() {
	register_post_type(
		'testimonio',
		array(
			'labels'        => array(
				'name'               => __( 'Testimonios', 'almicahealing' ),
				'singular_name'      => __( 'Testimonio', 'almicahealing' ),
				'add_new_item'       => __( 'Añadir testimonio', 'almicahealing' ),
				'edit_item'          => __( 'Editar testimonio', 'almicahealing' ),
				'search_items'       => __( 'Buscar testimonios', 'almicahealing' ),
				'not_found'          => __( 'No se encontraron testimonios.', 'almicahealing' ),
				'not_found_in_trash' => __( 'No hay testimonios en la papelera.', 'almicahealing' ),
			),
			'public'        => true,
			'has_archive'   => false,
			'show_in_rest'  => true,
			'menu_icon'     => 'dashicons-format-quote',
			'menu_position' => 22,
			'supports'      => array( 'title', 'editor', 'excerpt', 'page-attributes' ),
			'rewrite'       => false,
		)
	);
}
add_action( 'init', 'almicahealing_register_testimonio' );

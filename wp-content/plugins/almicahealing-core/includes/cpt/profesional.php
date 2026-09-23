<?php
/**
 * "Profesional" content type — therapists, course facilitators and the
 * founder. Written once and referenced from `servicio.professionals`,
 * `curso.facilitators` and the Acerca de page, so a bio or photo change
 * lands everywhere that person appears.
 *
 * MV1 has no public profile pages (content model Q7), so the type is
 * registered `public => false` with the admin UI on. Flipping it to
 * public later needs a `single-profesional.php` template and no data
 * migration.
 *
 * @package AlmicaHealingCore
 */

defined( 'ABSPATH' ) || exit;

/**
 * Registers the `profesional` post type.
 *
 * `post_title` holds the display name, `post_content` the bio and the
 * featured image the (square) portrait. The gold role line and the
 * "Formación" credentials live in the `group_profesional` field group.
 */
function almicahealing_register_profesional() {
	register_post_type(
		'profesional',
		array(
			'labels'        => array(
				'name'               => __( 'Profesionales', 'almicahealing' ),
				'singular_name'      => __( 'Profesional', 'almicahealing' ),
				'add_new_item'       => __( 'Añadir profesional', 'almicahealing' ),
				'edit_item'          => __( 'Editar profesional', 'almicahealing' ),
				'search_items'       => __( 'Buscar profesionales', 'almicahealing' ),
				'not_found'          => __( 'No se encontraron profesionales.', 'almicahealing' ),
				'not_found_in_trash' => __( 'No hay profesionales en la papelera.', 'almicahealing' ),
			),
			'public'        => false,
			'show_ui'       => true,
			'show_in_menu'  => true,
			'show_in_rest'  => true,
			'has_archive'   => false,
			'menu_icon'     => 'dashicons-groups',
			'menu_position' => 23,
			'supports'      => array( 'title', 'editor', 'thumbnail', 'page-attributes' ),
			'rewrite'       => false,
		)
	);
}
add_action( 'init', 'almicahealing_register_profesional' );

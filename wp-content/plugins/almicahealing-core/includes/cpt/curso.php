<?php
/**
 * "Curso" content type — Clantarra, Riutunmi, Lo Que Nadie Nos Enseñó.
 *
 * @package AlmicaHealingCore
 */

defined( 'ABSPATH' ) || exit;

/**
 * Registers the `curso` post type.
 */
function almicahealing_register_curso() {
	register_post_type(
		'curso',
		array(
			'labels'        => array(
				'name'               => __( 'Cursos', 'almicahealing' ),
				'singular_name'      => __( 'Curso', 'almicahealing' ),
				'add_new_item'       => __( 'Añadir curso', 'almicahealing' ),
				'edit_item'          => __( 'Editar curso', 'almicahealing' ),
				'search_items'       => __( 'Buscar cursos', 'almicahealing' ),
				'not_found'          => __( 'No se encontraron cursos.', 'almicahealing' ),
				'not_found_in_trash' => __( 'No hay cursos en la papelera.', 'almicahealing' ),
			),
			'public'        => true,
			'has_archive'   => false,
			'show_in_rest'  => true,
			'menu_icon'     => 'dashicons-welcome-learn-more',
			'menu_position' => 21,
			'supports'      => array( 'title', 'editor', 'excerpt', 'thumbnail', 'page-attributes' ),
			'rewrite'       => array( 'slug' => 'cursos' ),
		)
	);
}
add_action( 'init', 'almicahealing_register_curso' );

<?php
/**
 * "Acerca de Álmica" hero (Figma "Hero" frame, node-id 146-436).
 *
 * @package AlmicaHealing
 */

defined( 'ABSPATH' ) || exit;

get_template_part(
	'template-parts/parts/page-hero',
	null,
	array(
		'eyebrow'  => __( 'Álmica Healing', 'almicahealing' ),
		'title'    => __( 'Acerca de Álmica', 'almicahealing' ),
		'subtitle' => __( 'Somos un espacio que te brinda Terapias de sanación en donde unes pasado y presente para un futuro equilibrado.', 'almicahealing' ),
		'image'    => get_theme_file_uri( 'assets/img/acerca-de-hero.jpg' ),
	)
);

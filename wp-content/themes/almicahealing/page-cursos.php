<?php
/**
 * "Cursos" (Figma frame 4): hero and the full course listing. The
 * counterpart of page-servicios.php — the Page provides an editable
 * hero, so the CPT needs no archive.
 *
 * @package AlmicaHealing
 */

defined( 'ABSPATH' ) || exit;

get_header();

get_template_part(
	'template-parts/parts/page-hero',
	null,
	array(
		'eyebrow'  => __( 'Formación', 'almicahealing' ),
		'title'    => __( 'Programas para crecer desde adentro.', 'almicahealing' ),
		'subtitle' => __( 'Cursos diseñados para quienes buscan herramientas reales de transformación interior, a su propio ritmo.', 'almicahealing' ),
	)
);

get_template_part( 'template-parts/sections/courses-catalog' );

get_footer();

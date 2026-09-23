<?php
/**
 * Servicios page hero (Figma "Hero" frame, node-id 146-636).
 *
 * @package AlmicaHealing
 */

defined( 'ABSPATH' ) || exit;

get_template_part(
	'template-parts/parts/page-hero',
	null,
	array(
		'eyebrow'  => __( 'Servicios', 'almicahealing' ),
		'title'    => __( 'Distintos caminos. Un mismo propósito: volver a ti.', 'almicahealing' ),
		'subtitle' => __( 'En Álmica Healing reunimos terapias energéticas, emocionales y sistémicas en un mismo espacio, guiadas por profesionales especializados en cada disciplina. Explora las opciones disponibles y descubre la que mejor acompañe tu momento actual.', 'almicahealing' ),
	)
);

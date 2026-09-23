<?php
/**
 * Page-level field groups (KW-154): the shared page hero, the Home
 * section copy and the Acerca de founder link. These turn the copy that
 * `front-page.php` and `page-acerca-de.php` currently hard-code into
 * editable content.
 *
 * Section labels ("Lo que esta sesión puede ofrecerte", "Quién imparte"
 * …) deliberately stay translatable theme strings — they're design, not
 * per-site content.
 *
 * @package AlmicaHealingCore
 */

defined( 'ABSPATH' ) || exit;

/**
 * Builds an ACF location rule matching a single page by slug.
 *
 * `page-acerca-de.php` and friends are slug-based templates, not
 * selectable "Template" choices, so there's no `page_template` value to
 * match on — the rule has to resolve the page to an ID at runtime.
 *
 * @param string $slug Page slug, e.g. 'acerca-de'.
 * @return array<int,array<string,string>>|null Location rule, or null when the page doesn't exist.
 */
function almicahealing_page_location( $slug ) {
	$page = get_page_by_path( $slug );

	if ( ! $page ) {
		return null;
	}

	return array(
		array(
			'param'    => 'page',
			'operator' => '==',
			'value'    => (string) $page->ID,
		),
	);
}

/**
 * Registers the shared "Encabezado de página" group.
 *
 * Applied to every page rather than an enumerated list of templates:
 * the fields are optional everywhere and each template reads only the
 * ones it renders, which is simpler than keeping a template whitelist
 * in sync.
 */
function almicahealing_register_page_hero_fields() {
	if ( ! almicahealing_has_scf() ) {
		return;
	}

	acf_add_local_field_group(
		array(
			'key'             => 'group_page_hero',
			'title'           => __( 'Encabezado de página', 'almicahealing' ),
			'menu_order'      => 0,
			'position'        => 'normal',
			'style'           => 'default',
			'label_placement' => 'top',
			'active'          => true,
			'location'        => array(
				array(
					array(
						'param'    => 'post_type',
						'operator' => '==',
						'value'    => 'page',
					),
				),
			),
			'fields'          => array(
				array(
					'key'       => 'field_hero_eyebrow',
					'label'     => __( 'Antetítulo', 'almicahealing' ),
					'name'      => 'hero_eyebrow',
					'type'      => 'text',
					'maxlength' => 60,
					'wrapper'   => array( 'width' => '40' ),
				),
				array(
					'key'       => 'field_hero_title',
					'label'     => __( 'Título', 'almicahealing' ),
					'name'      => 'hero_title',
					'type'      => 'text',
					'maxlength' => 120,
					'wrapper'   => array( 'width' => '60' ),
				),
				array(
					'key'   => 'field_hero_subtitle',
					'label' => __( 'Subtítulo', 'almicahealing' ),
					'name'  => 'hero_subtitle',
					'type'  => 'textarea',
					'rows'  => 3,
				),
				array(
					'key'           => 'field_hero_image',
					'label'         => __( 'Imagen de fondo', 'almicahealing' ),
					'name'          => 'hero_image',
					'type'          => 'image',
					'return_format' => 'id',
					'preview_size'  => 'medium',
				),
				array(
					'key'       => 'field_hero_cta_label',
					'label'     => __( 'Texto del botón', 'almicahealing' ),
					'name'      => 'hero_cta_label',
					'type'      => 'text',
					'maxlength' => 60,
					'wrapper'   => array( 'width' => '50' ),
				),
				array(
					'key'     => 'field_hero_cta_url',
					'label'   => __( 'Enlace del botón', 'almicahealing' ),
					'name'    => 'hero_cta_url',
					'type'    => 'text',
					'wrapper' => array( 'width' => '50' ),
				),
			),
		)
	);
}
add_action( 'acf/init', 'almicahealing_register_page_hero_fields' );

/**
 * Registers the "Inicio" group — the copy for every Home section below
 * the hero.
 */
function almicahealing_register_home_fields() {
	if ( ! almicahealing_has_scf() ) {
		return;
	}

	acf_add_local_field_group(
		array(
			'key'             => 'group_home',
			'title'           => __( 'Inicio', 'almicahealing' ),
			'menu_order'      => 1,
			'position'        => 'normal',
			'style'           => 'default',
			'label_placement' => 'top',
			'active'          => true,
			'location'        => array(
				array(
					array(
						'param'    => 'page_type',
						'operator' => '==',
						'value'    => 'front_page',
					),
				),
			),
			'fields'          => array(
				array(
					'key'        => 'field_home_intro',
					'label'      => __( 'Introducción', 'almicahealing' ),
					'name'       => 'intro',
					'type'       => 'group',
					'layout'     => 'block',
					'sub_fields' => array(
						array(
							'key'   => 'field_home_intro_title',
							'label' => __( 'Título', 'almicahealing' ),
							'name'  => 'title',
							'type'  => 'text',
						),
						array(
							'key'          => 'field_home_intro_body',
							'label'        => __( 'Texto', 'almicahealing' ),
							'name'         => 'body',
							'type'         => 'wysiwyg',
							'tabs'         => 'visual',
							'media_upload' => 0,
							'toolbar'      => 'basic',
						),
						array(
							'key'           => 'field_home_intro_image',
							'label'         => __( 'Imagen', 'almicahealing' ),
							'name'          => 'image',
							'type'          => 'image',
							'return_format' => 'id',
							'preview_size'  => 'medium',
						),
						array(
							'key'     => 'field_home_intro_cta_label',
							'label'   => __( 'Texto del botón', 'almicahealing' ),
							'name'    => 'cta_label',
							'type'    => 'text',
							'wrapper' => array( 'width' => '50' ),
						),
						array(
							'key'     => 'field_home_intro_cta_url',
							'label'   => __( 'Enlace del botón', 'almicahealing' ),
							'name'    => 'cta_url',
							'type'    => 'text',
							'wrapper' => array( 'width' => '50' ),
						),
					),
				),
				array(
					'key'        => 'field_home_services_intro',
					'label'      => __( 'Servicios (encabezado)', 'almicahealing' ),
					'name'       => 'services_intro',
					'type'       => 'group',
					'layout'     => 'block',
					'sub_fields' => array(
						array(
							'key'   => 'field_home_services_eyebrow',
							'label' => __( 'Antetítulo', 'almicahealing' ),
							'name'  => 'eyebrow',
							'type'  => 'text',
						),
						array(
							'key'   => 'field_home_services_title',
							'label' => __( 'Título', 'almicahealing' ),
							'name'  => 'title',
							'type'  => 'text',
						),
						array(
							'key'   => 'field_home_services_subtitle',
							'label' => __( 'Subtítulo', 'almicahealing' ),
							'name'  => 'subtitle',
							'type'  => 'textarea',
							'rows'  => 2,
						),
					),
				),
				array(
					'key'          => 'field_home_process_steps',
					'label'        => __( 'Cómo funciona', 'almicahealing' ),
					'name'         => 'process_steps',
					'type'         => 'repeater',
					'instructions' => __( 'Exactamente 3 pasos. Los iconos y la numeración vienen del tema.', 'almicahealing' ),
					'min'          => 3,
					'max'          => 3,
					'layout'       => 'table',
					'sub_fields'   => array(
						array(
							'key'      => 'field_home_process_step_title',
							'label'    => __( 'Título', 'almicahealing' ),
							'name'     => 'title',
							'type'     => 'text',
							'required' => 1,
						),
						array(
							'key'      => 'field_home_process_step_body',
							'label'    => __( 'Texto', 'almicahealing' ),
							'name'     => 'body',
							'type'     => 'textarea',
							'rows'     => 2,
							'required' => 1,
						),
					),
				),
				array(
					'key'        => 'field_home_quote',
					'label'      => __( 'Cita', 'almicahealing' ),
					'name'       => 'quote',
					'type'       => 'group',
					'layout'     => 'block',
					'sub_fields' => array(
						array(
							'key'     => 'field_home_quote_line_1',
							'label'   => __( 'Línea 1', 'almicahealing' ),
							'name'    => 'line_1',
							'type'    => 'text',
							'wrapper' => array( 'width' => '50' ),
						),
						array(
							'key'     => 'field_home_quote_line_2',
							'label'   => __( 'Línea 2', 'almicahealing' ),
							'name'    => 'line_2',
							'type'    => 'text',
							'wrapper' => array( 'width' => '50' ),
						),
						array(
							'key'           => 'field_home_quote_image',
							'label'         => __( 'Imagen de fondo', 'almicahealing' ),
							'name'          => 'image',
							'type'          => 'image',
							'return_format' => 'id',
							'preview_size'  => 'medium',
						),
					),
				),
				array(
					'key'        => 'field_home_courses_intro',
					'label'      => __( 'Cursos (encabezado)', 'almicahealing' ),
					'name'       => 'courses_intro',
					'type'       => 'group',
					'layout'     => 'block',
					'sub_fields' => array(
						array(
							'key'   => 'field_home_courses_eyebrow',
							'label' => __( 'Antetítulo', 'almicahealing' ),
							'name'  => 'eyebrow',
							'type'  => 'text',
						),
						array(
							'key'   => 'field_home_courses_title',
							'label' => __( 'Título', 'almicahealing' ),
							'name'  => 'title',
							'type'  => 'text',
						),
						array(
							'key'   => 'field_home_courses_body',
							'label' => __( 'Texto', 'almicahealing' ),
							'name'  => 'body',
							'type'  => 'textarea',
							'rows'  => 4,
						),
					),
				),
				array(
					'key'   => 'field_home_testimonials_title',
					'label' => __( 'Testimonios (título)', 'almicahealing' ),
					'name'  => 'testimonials_title',
					'type'  => 'text',
				),
			),
		)
	);
}
add_action( 'acf/init', 'almicahealing_register_home_fields' );

/**
 * Registers the "Acerca de" group — the founder link. The "Formación"
 * list on that page is read from the founder's own `credentials`, so it
 * isn't duplicated here.
 */
function almicahealing_register_acerca_de_fields() {
	if ( ! almicahealing_has_scf() ) {
		return;
	}

	$location = almicahealing_page_location( 'acerca-de' );

	if ( ! $location ) {
		return;
	}

	acf_add_local_field_group(
		array(
			'key'             => 'group_acerca_de',
			'title'           => __( 'Acerca de', 'almicahealing' ),
			'menu_order'      => 1,
			'position'        => 'normal',
			'style'           => 'default',
			'label_placement' => 'top',
			'active'          => true,
			'location'        => array( $location ),
			'fields'          => array(
				array(
					'key'           => 'field_acerca_de_founder',
					'label'         => __( 'Fundadora', 'almicahealing' ),
					'name'          => 'founder',
					'type'          => 'post_object',
					'instructions'  => __( 'La biografía, la foto y la lista de Formación se leen de esta ficha.', 'almicahealing' ),
					'post_type'     => array( 'profesional' ),
					'required'      => 1,
					'return_format' => 'id',
					'ui'            => 1,
				),
			),
		)
	);
}
add_action( 'acf/init', 'almicahealing_register_acerca_de_fields' );

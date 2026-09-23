<?php
/**
 * `group_ajustes` — the "Ajustes de Álmica" options page (KW-151),
 * which replaces the hard-coded array in the theme's `inc/brand.php`.
 *
 * The defaults below are the canonical contact values from that file
 * (decision D3) — the differing @almica.mx addresses in Figma are not
 * used.
 *
 * @package AlmicaHealingCore
 */

defined( 'ABSPATH' ) || exit;

/**
 * Default value for every global setting.
 *
 * Also used by `almicahealing_setting()` in the theme, so the site
 * renders correctly before anyone opens the options page and on an
 * environment where SCF isn't installed.
 *
 * @return array<string,string>
 */
function almicahealing_setting_defaults() {
	return array(
		'contact_email'         => 'almicahealing@gmail.com',
		'phone'                 => '+52 81 7008 8058',
		'whatsapp'              => '',
		'location_label'        => 'México · sesiones virtuales',
		'social_instagram'      => '',
		'social_facebook'       => '',
		'social_tiktok'         => '',
		'footer_blurb'          => 'Bienestar integral para un proceso de conexión, claridad y transformación.',
		'footer_tagline'        => 'El equilibrio que da origen a todo',
		'currency_label'        => 'MXN',
		'service_price_basis'   => 'por sesión individual',
		'price_on_request_text' => 'Escríbenos para conocer el precio',
		'course_inquiry_title'  => '¿Te interesa este programa?',
		'course_inquiry_body'   => 'Escríbenos directamente y con gusto te damos más información.',
		'legal_contact_note'    => 'Para cualquier duda relacionada con este documento, puedes escribirnos.',
	);
}

/**
 * Registers the options-page field group.
 */
function almicahealing_register_ajustes_fields() {
	if ( ! almicahealing_has_scf() ) {
		return;
	}

	$defaults = almicahealing_setting_defaults();

	acf_add_local_field_group(
		array(
			'key'             => 'group_ajustes',
			'title'           => __( 'Ajustes de Álmica', 'almicahealing' ),
			'menu_order'      => 0,
			'position'        => 'normal',
			'style'           => 'default',
			'label_placement' => 'top',
			'active'          => true,
			'location'        => array(
				array(
					array(
						'param'    => 'options_page',
						'operator' => '==',
						'value'    => 'almica-ajustes',
					),
				),
			),
			'fields'          => array(
				array(
					'key'   => 'field_ajustes_tab_contacto',
					'label' => __( 'Contacto', 'almicahealing' ),
					'type'  => 'tab',
				),
				array(
					'key'           => 'field_ajustes_contact_email',
					'label'         => __( 'Correo de contacto', 'almicahealing' ),
					'name'          => 'contact_email',
					'type'          => 'email',
					'instructions'  => __( 'Se usa en el pie de página, en la tarjeta de contacto de los cursos y en los avisos legales.', 'almicahealing' ),
					'default_value' => $defaults['contact_email'],
					'wrapper'       => array( 'width' => '50' ),
				),
				array(
					'key'           => 'field_ajustes_phone',
					'label'         => __( 'Teléfono', 'almicahealing' ),
					'name'          => 'phone',
					'type'          => 'text',
					'default_value' => $defaults['phone'],
					'wrapper'       => array( 'width' => '50' ),
				),
				array(
					'key'          => 'field_ajustes_whatsapp',
					'label'        => __( 'WhatsApp', 'almicahealing' ),
					'name'         => 'whatsapp',
					'type'         => 'text',
					'instructions' => __( 'Número o enlace. Vacío oculta las menciones a WhatsApp.', 'almicahealing' ),
					'wrapper'      => array( 'width' => '50' ),
				),
				array(
					'key'           => 'field_ajustes_location_label',
					'label'         => __( 'Ubicación', 'almicahealing' ),
					'name'          => 'location_label',
					'type'          => 'text',
					'default_value' => $defaults['location_label'],
					'wrapper'       => array( 'width' => '50' ),
				),
				array(
					'key'   => 'field_ajustes_tab_redes',
					'label' => __( 'Redes sociales', 'almicahealing' ),
					'type'  => 'tab',
				),
				array(
					'key'          => 'field_ajustes_social_instagram',
					'label'        => __( 'Instagram', 'almicahealing' ),
					'name'         => 'social_instagram',
					'type'         => 'url',
					'instructions' => __( 'Vacío oculta el botón.', 'almicahealing' ),
				),
				array(
					'key'   => 'field_ajustes_social_facebook',
					'label' => __( 'Facebook', 'almicahealing' ),
					'name'  => 'social_facebook',
					'type'  => 'url',
				),
				array(
					'key'   => 'field_ajustes_social_tiktok',
					'label' => __( 'TikTok', 'almicahealing' ),
					'name'  => 'social_tiktok',
					'type'  => 'url',
				),
				array(
					'key'   => 'field_ajustes_tab_pie',
					'label' => __( 'Pie de página', 'almicahealing' ),
					'type'  => 'tab',
				),
				array(
					'key'           => 'field_ajustes_footer_blurb',
					'label'         => __( 'Descripción', 'almicahealing' ),
					'name'          => 'footer_blurb',
					'type'          => 'textarea',
					'rows'          => 2,
					'default_value' => $defaults['footer_blurb'],
				),
				array(
					'key'           => 'field_ajustes_footer_tagline',
					'label'         => __( 'Lema', 'almicahealing' ),
					'name'          => 'footer_tagline',
					'type'          => 'text',
					'default_value' => $defaults['footer_tagline'],
				),
				array(
					'key'   => 'field_ajustes_tab_precios',
					'label' => __( 'Precios', 'almicahealing' ),
					'type'  => 'tab',
				),
				array(
					'key'           => 'field_ajustes_currency_label',
					'label'         => __( 'Moneda', 'almicahealing' ),
					'name'          => 'currency_label',
					'type'          => 'text',
					'default_value' => $defaults['currency_label'],
					'wrapper'       => array( 'width' => '33' ),
				),
				array(
					'key'           => 'field_ajustes_service_price_basis',
					'label'         => __( 'Base del precio (servicios)', 'almicahealing' ),
					'name'          => 'service_price_basis',
					'type'          => 'text',
					'default_value' => $defaults['service_price_basis'],
					'wrapper'       => array( 'width' => '33' ),
				),
				array(
					'key'           => 'field_ajustes_price_on_request_text',
					'label'         => __( 'Texto de precio a consultar', 'almicahealing' ),
					'name'          => 'price_on_request_text',
					'type'          => 'text',
					'default_value' => $defaults['price_on_request_text'],
					'wrapper'       => array( 'width' => '34' ),
				),
				array(
					'key'   => 'field_ajustes_tab_cursos',
					'label' => __( 'Cursos', 'almicahealing' ),
					'type'  => 'tab',
				),
				array(
					'key'           => 'field_ajustes_course_inquiry_title',
					'label'         => __( 'Título de la tarjeta de contacto', 'almicahealing' ),
					'name'          => 'course_inquiry_title',
					'type'          => 'text',
					'default_value' => $defaults['course_inquiry_title'],
				),
				array(
					'key'           => 'field_ajustes_course_inquiry_body',
					'label'         => __( 'Texto de la tarjeta de contacto', 'almicahealing' ),
					'name'          => 'course_inquiry_body',
					'type'          => 'textarea',
					'rows'          => 2,
					'default_value' => $defaults['course_inquiry_body'],
				),
				array(
					'key'   => 'field_ajustes_tab_legal',
					'label' => __( 'Legales', 'almicahealing' ),
					'type'  => 'tab',
				),
				array(
					'key'           => 'field_ajustes_legal_contact_note',
					'label'         => __( 'Nota de contacto', 'almicahealing' ),
					'name'          => 'legal_contact_note',
					'type'          => 'textarea',
					'rows'          => 3,
					'default_value' => $defaults['legal_contact_note'],
				),
			),
		)
	);
}
add_action( 'acf/init', 'almicahealing_register_ajustes_fields' );

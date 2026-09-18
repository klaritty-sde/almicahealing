<?php
/**
 * Contact form field definitions, order, and shared validation messages.
 *
 * Unlike Klaritty's B2B form (empresa/cargo/personal-email block), this is a
 * consumer-facing wellness form — no company fields, no personal-email
 * restriction.
 *
 * @package AlmicaHealingCore
 */

defined( 'ABSPATH' ) || exit;

const ALMICAHEALING_CONTACT_ACTION = 'almicahealing_contacto';

/**
 * Field definitions, in display order. Validation, the notification email
 * and the admin meta box are all built from this list.
 *
 * @return array
 */
function almicahealing_contact_fields() {
	return array(
		'nombre'   => array(
			'label'        => __( 'Nombre completo', 'almicahealing' ),
			'type'         => 'text',
			'required'     => true,
			'maxlength'    => 100,
			'autocomplete' => 'name',
		),
		'email'    => array(
			'label'        => __( 'Correo electrónico', 'almicahealing' ),
			'type'         => 'email',
			'required'     => true,
			'maxlength'    => 254,
			'autocomplete' => 'email',
		),
		'telefono' => array(
			'label'        => __( 'Número de teléfono', 'almicahealing' ),
			'type'         => 'tel',
			'required'     => false,
			'maxlength'    => 20,
			'autocomplete' => 'tel',
		),
		'pais'     => array(
			'label'    => __( 'País', 'almicahealing' ),
			'type'     => 'select',
			'required' => true,
			'default'  => 'MX',
			'options'  => almicahealing_contact_countries(),
		),
		'interes'  => array(
			'label'    => __( 'Servicio de interés', 'almicahealing' ),
			'type'     => 'select',
			'required' => false,
			'options'  => almicahealing_contact_interest_options(),
		),
		'mensaje'  => array(
			'label'     => __( 'Cuéntanos brevemente qué buscas', 'almicahealing' ),
			'type'      => 'textarea',
			'required'  => true,
			'maxlength' => 2000,
		),
	);
}

/**
 * "Servicio de interés" options, built from published `servicio` posts.
 *
 * @return array<string, string>
 */
function almicahealing_contact_interest_options() {
	$options = array();

	foreach ( get_posts(
		array(
			'post_type'      => 'servicio',
			'posts_per_page' => -1,
			'orderby'        => 'menu_order',
			'order'          => 'ASC',
		)
	) as $servicio ) {
		$options[ (string) $servicio->ID ] = $servicio->post_title;
	}

	return $options;
}

/**
 * Messages shared by server-side validation and the browser-side copy.
 *
 * @return array<string, string>
 */
function almicahealing_contact_messages() {
	return array(
		'required' => __( 'Este campo es obligatorio.', 'almicahealing' ),
		'tooLong'  => __( 'Este campo es demasiado largo.', 'almicahealing' ),
		'email'    => __( 'Ingresa un correo electrónico válido.', 'almicahealing' ),
		'phone'    => __( 'Ingresa un número de teléfono válido.', 'almicahealing' ),
		'option'   => __( 'Selecciona una opción de la lista.', 'almicahealing' ),
		'sending'  => __( 'Enviando…', 'almicahealing' ),
		'network'  => __( 'No pudimos enviar tu mensaje. Revisa tu conexión e inténtalo de nuevo.', 'almicahealing' ),
		'failed'   => sprintf(
			/* translators: %s: correo de contacto. */
			__( 'No pudimos enviar tu mensaje. Inténtalo de nuevo o escríbenos a %s.', 'almicahealing' ),
			almicahealing_contact_notify_to()
		),
	);
}

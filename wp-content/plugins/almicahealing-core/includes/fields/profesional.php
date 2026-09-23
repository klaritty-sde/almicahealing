<?php
/**
 * `group_profesional` — the gold role line and the "Formación"
 * credentials (KW-148). Name, bio and portrait are native fields.
 *
 * @package AlmicaHealingCore
 */

defined( 'ABSPATH' ) || exit;

/**
 * Registers the Profesional field group.
 */
function almicahealing_register_profesional_fields() {
	if ( ! almicahealing_has_scf() ) {
		return;
	}

	acf_add_local_field_group(
		array(
			'key'             => 'group_profesional',
			'title'           => __( 'Profesional', 'almicahealing' ),
			'menu_order'      => 0,
			'position'        => 'normal',
			'style'           => 'default',
			'label_placement' => 'top',
			'active'          => true,
			'hide_on_screen'  => array( 'custom_fields' ),
			'location'        => array(
				array(
					array(
						'param'    => 'post_type',
						'operator' => '==',
						'value'    => 'profesional',
					),
				),
			),
			'fields'          => array(
				array(
					'key'          => 'field_profesional_role',
					'label'        => __( 'Rol', 'almicahealing' ),
					'name'         => 'role',
					'type'         => 'text',
					'instructions' => __( 'Línea dorada bajo el nombre. Ej. «Terapeuta Holística. Especialista en Terapia Centrada en Soluciones».', 'almicahealing' ),
					'required'     => 1,
					'maxlength'    => 140,
				),
				array(
					'key'          => 'field_profesional_credentials',
					'label'        => __( 'Formación', 'almicahealing' ),
					'name'         => 'credentials',
					'type'         => 'repeater',
					'instructions' => __( 'Se muestra en la página Acerca de para la fundadora.', 'almicahealing' ),
					'min'          => 0,
					'layout'       => 'block',
					'button_label' => __( 'Añadir formación', 'almicahealing' ),
					'sub_fields'   => array(
						array(
							'key'       => 'field_profesional_credential_title',
							'label'     => __( 'Título', 'almicahealing' ),
							'name'      => 'title',
							'type'      => 'text',
							'required'  => 1,
							'maxlength' => 160,
							'wrapper'   => array( 'width' => '60' ),
						),
						array(
							'key'     => 'field_profesional_credential_year',
							'label'   => __( 'Año', 'almicahealing' ),
							'name'    => 'year',
							'type'    => 'number',
							'min'     => 1900,
							'max'     => 2100,
							'wrapper' => array( 'width' => '15' ),
						),
						array(
							'key'       => 'field_profesional_credential_institution',
							'label'     => __( 'Institución', 'almicahealing' ),
							'name'      => 'institution',
							'type'      => 'text',
							'maxlength' => 160,
							'wrapper'   => array( 'width' => '25' ),
						),
						array(
							'key'   => 'field_profesional_credential_description',
							'label' => __( 'Descripción', 'almicahealing' ),
							'name'  => 'description',
							'type'  => 'textarea',
							'rows'  => 2,
						),
					),
				),
			),
		)
	);
}
add_action( 'acf/init', 'almicahealing_register_profesional_fields' );

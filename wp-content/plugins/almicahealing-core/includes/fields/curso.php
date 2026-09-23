<?php
/**
 * `group_curso` — structured fields for the Curso content type (KW-150).
 *
 * `price` is deliberately optional: Clantanra is "price on request" in
 * the design, which hides the Inversión card and shows the global
 * `price_on_request_text` instead.
 *
 * @package AlmicaHealingCore
 */

defined( 'ABSPATH' ) || exit;

/**
 * Registers the Curso field group.
 */
function almicahealing_register_curso_fields() {
	if ( ! almicahealing_has_scf() ) {
		return;
	}

	acf_add_local_field_group(
		array(
			'key'             => 'group_curso',
			'title'           => __( 'Curso', 'almicahealing' ),
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
						'value'    => 'curso',
					),
				),
			),
			'fields'          => array(
				array(
					'key'          => 'field_curso_tagline',
					'label'        => __( 'Frase del encabezado', 'almicahealing' ),
					'name'         => 'tagline',
					'type'         => 'text',
					'instructions' => __( 'Subtítulo del hero. Si se deja vacío se usa el resumen (extracto). En el diseño difieren.', 'almicahealing' ),
					'maxlength'    => 250,
				),
				array(
					'key'          => 'field_curso_program_label',
					'label'        => __( 'Etiqueta del programa', 'almicahealing' ),
					'name'         => 'program_label',
					'type'         => 'text',
					'instructions' => __( 'Píldora del encabezado. Ej. «Curso intermedio de canalización y sanación».', 'almicahealing' ),
					'required'     => 1,
					'maxlength'    => 80,
				),
				array(
					'key'           => 'field_curso_level',
					'label'         => __( 'Nivel', 'almicahealing' ),
					'name'          => 'level',
					'type'          => 'select',
					'required'      => 1,
					'choices'       => almicahealing_level_choices(),
					'default_value' => 'basico',
					'return_format' => 'value',
				),
				array(
					'key'          => 'field_curso_price',
					'label'        => __( 'Precio', 'almicahealing' ),
					'name'         => 'price',
					'type'         => 'number',
					'instructions' => __( 'Vacío muestra «precio a consultar» y oculta la tarjeta de Inversión.', 'almicahealing' ),
					'min'          => 0,
					'step'         => '1',
				),
				array(
					'key'          => 'field_curso_duration',
					'label'        => __( 'Duración', 'almicahealing' ),
					'name'         => 'duration',
					'type'         => 'text',
					'instructions' => __( 'Texto libre. Ej. «2 meses».', 'almicahealing' ),
					'maxlength'    => 40,
				),
				array(
					'key'           => 'field_curso_outcomes_heading',
					'label'         => __( 'Encabezado de la lista', 'almicahealing' ),
					'name'          => 'outcomes_heading',
					'type'          => 'select',
					'required'      => 1,
					'choices'       => almicahealing_outcomes_heading_choices(),
					'default_value' => 'objetivos',
					'return_format' => 'value',
				),
				array(
					'key'          => 'field_curso_outcomes',
					'label'        => __( 'Puntos de la lista', 'almicahealing' ),
					'name'         => 'outcomes',
					'type'         => 'repeater',
					'instructions' => __( 'La numeración se genera sola: no la escribas en el texto.', 'almicahealing' ),
					'required'     => 1,
					'min'          => 1,
					'max'          => 10,
					'layout'       => 'table',
					'button_label' => __( 'Añadir punto', 'almicahealing' ),
					'sub_fields'   => array(
						array(
							'key'       => 'field_curso_outcome_text',
							'label'     => __( 'Texto', 'almicahealing' ),
							'name'      => 'text',
							'type'      => 'text',
							'required'  => 1,
							'maxlength' => 200,
						),
					),
				),
				array(
					'key'           => 'field_curso_facilitators',
					'label'         => __( 'Facilitador/a', 'almicahealing' ),
					'name'          => 'facilitators',
					'type'          => 'relationship',
					'post_type'     => array( 'profesional' ),
					'filters'       => array( 'search' ),
					'min'           => 1,
					'max'           => 2,
					'return_format' => 'id',
				),
			),
		)
	);
}
add_action( 'acf/init', 'almicahealing_register_curso_fields' );

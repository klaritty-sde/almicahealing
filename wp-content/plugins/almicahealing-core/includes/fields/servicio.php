<?php
/**
 * `group_servicio` — structured fields for the Servicio content type
 * (KW-149). Native fields carry title, slug, summary (`post_excerpt`),
 * description (`post_content`) and the card image (featured image);
 * everything below is what the detail template needs on top of those.
 *
 * @package AlmicaHealingCore
 */

defined( 'ABSPATH' ) || exit;

/**
 * Registers the Servicio field group.
 */
function almicahealing_register_servicio_fields() {
	if ( ! almicahealing_has_scf() ) {
		return;
	}

	acf_add_local_field_group(
		array(
			'key'             => 'group_servicio',
			'title'           => __( 'Servicio', 'almicahealing' ),
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
						'value'    => 'servicio',
					),
				),
			),
			'fields'          => array(
				array(
					'key'          => 'field_servicio_tagline',
					'label'        => __( 'Frase del encabezado', 'almicahealing' ),
					'name'         => 'tagline',
					'type'         => 'text',
					'instructions' => __( 'Subtítulo del hero. Si se deja vacío se usa el resumen (extracto) del servicio.', 'almicahealing' ),
					'maxlength'    => 200,
				),
				array(
					'key'           => 'field_servicio_hero_image',
					'label'         => __( 'Imagen del encabezado', 'almicahealing' ),
					'name'          => 'hero_image',
					'type'          => 'image',
					'instructions'  => __( 'Opcional. Si se deja vacía se usa la imagen destacada (la de la tarjeta).', 'almicahealing' ),
					'return_format' => 'id',
					'preview_size'  => 'medium',
					'library'       => 'all',
				),
				array(
					'key'          => 'field_servicio_price',
					'label'        => __( 'Precio', 'almicahealing' ),
					'name'         => 'price',
					'type'         => 'number',
					'instructions' => __( 'Sólo el número, sin símbolo de moneda. Ej. 1150', 'almicahealing' ),
					'required'     => 1,
					'min'          => 0,
					'step'         => '0.01',
				),
				array(
					'key'          => 'field_servicio_price_basis',
					'label'        => __( 'Base del precio', 'almicahealing' ),
					'name'         => 'price_basis',
					'type'         => 'text',
					'instructions' => __( 'Sólo si este servicio no se cobra por sesión individual. Vacío usa el valor global de Ajustes de Álmica.', 'almicahealing' ),
					'maxlength'    => 80,
				),
				array(
					'key'           => 'field_servicio_duration_minutes',
					'label'         => __( 'Duración (minutos)', 'almicahealing' ),
					'name'          => 'duration_minutes',
					'type'          => 'number',
					'instructions'  => __( 'Se muestra tanto en el encabezado como en la tarjeta de Inversión.', 'almicahealing' ),
					'required'      => 1,
					'default_value' => 60,
					'min'           => 15,
					'max'           => 480,
					'step'          => 15,
				),
				array(
					'key'           => 'field_servicio_modality',
					'label'         => __( 'Modalidad', 'almicahealing' ),
					'name'          => 'modality',
					'type'          => 'select',
					'required'      => 1,
					'choices'       => almicahealing_modality_choices(),
					'default_value' => 'presencial',
					'return_format' => 'value',
				),
				array(
					'key'          => 'field_servicio_benefits',
					'label'        => __( 'Beneficios', 'almicahealing' ),
					'name'         => 'benefits',
					'type'         => 'repeater',
					'instructions' => __( 'Lo que esta sesión puede ofrecerte. Entre 1 y 6 tarjetas.', 'almicahealing' ),
					'required'     => 1,
					'min'          => 1,
					'max'          => 6,
					'layout'       => 'block',
					'button_label' => __( 'Añadir beneficio', 'almicahealing' ),
					'sub_fields'   => array(
						array(
							'key'           => 'field_servicio_benefit_icon',
							'label'         => __( 'Icono', 'almicahealing' ),
							'name'          => 'icon',
							'type'          => 'select',
							'required'      => 1,
							'choices'       => almicahealing_benefit_icon_choices(),
							'default_value' => 'corazon',
							'return_format' => 'value',
							'wrapper'       => array( 'width' => '25' ),
						),
						array(
							'key'       => 'field_servicio_benefit_title',
							'label'     => __( 'Título', 'almicahealing' ),
							'name'      => 'title',
							'type'      => 'text',
							'required'  => 1,
							'maxlength' => 90,
							'wrapper'   => array( 'width' => '75' ),
						),
						array(
							'key'          => 'field_servicio_benefit_description',
							'label'        => __( 'Descripción', 'almicahealing' ),
							'name'         => 'description',
							'type'         => 'textarea',
							'instructions' => __( 'Opcional: varias tarjetas del diseño sólo llevan título.', 'almicahealing' ),
							'rows'         => 2,
							'maxlength'    => 180,
						),
					),
				),
				array(
					'key'           => 'field_servicio_professionals',
					'label'         => __( 'Quién imparte', 'almicahealing' ),
					'name'          => 'professionals',
					'type'          => 'relationship',
					'instructions'  => __( 'Déjalo vacío si aún no está confirmado: la sección completa se oculta.', 'almicahealing' ),
					'post_type'     => array( 'profesional' ),
					'filters'       => array( 'search' ),
					'max'           => 3,
					'return_format' => 'id',
				),
				array(
					'key'           => 'field_servicio_related_services',
					'label'         => __( 'Otros servicios', 'almicahealing' ),
					'name'          => 'related_services',
					'type'          => 'relationship',
					'instructions'  => __( 'Opcional. Vacío elige automáticamente los 3 servicios siguientes por orden.', 'almicahealing' ),
					'post_type'     => array( 'servicio' ),
					'filters'       => array( 'search' ),
					'max'           => 3,
					'return_format' => 'id',
				),
				array(
					'key'           => 'field_servicio_is_featured',
					'label'         => __( 'Destacado en Inicio', 'almicahealing' ),
					'name'          => 'is_featured',
					'type'          => 'true_false',
					'instructions'  => __( 'La página de inicio muestra 6 servicios destacados.', 'almicahealing' ),
					'ui'            => 1,
					'default_value' => 0,
				),
				array(
					'key'           => 'field_servicio_includes_workbook',
					'label'         => __( 'Incluye cuadernillo', 'almicahealing' ),
					'name'          => 'includes_workbook',
					'type'          => 'true_false',
					'instructions'  => __( 'Muestra una línea indicando que el servicio incluye cuadernillo descargable.', 'almicahealing' ),
					'ui'            => 1,
					'default_value' => 0,
				),
			),
		)
	);
}
add_action( 'acf/init', 'almicahealing_register_servicio_fields' );

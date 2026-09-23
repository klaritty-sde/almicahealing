<?php
/**
 * `group_testimonio` — replaces the free-text excerpt under a client's
 * name with a real relationship to the service or course they're
 * talking about (KW-153), so renaming a service updates the label.
 *
 * @package AlmicaHealingCore
 */

defined( 'ABSPATH' ) || exit;

/**
 * Registers the Testimonio field group.
 */
function almicahealing_register_testimonio_fields() {
	if ( ! almicahealing_has_scf() ) {
		return;
	}

	acf_add_local_field_group(
		array(
			'key'             => 'group_testimonio',
			'title'           => __( 'Testimonio', 'almicahealing' ),
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
						'value'    => 'testimonio',
					),
				),
			),
			'fields'          => array(
				array(
					'key'           => 'field_testimonio_about',
					'label'         => __( 'Sobre', 'almicahealing' ),
					'name'          => 'about',
					'type'          => 'post_object',
					'instructions'  => __( 'Servicio o curso del que habla el testimonio. La etiqueta bajo el nombre sale de aquí.', 'almicahealing' ),
					'post_type'     => array( 'servicio', 'curso' ),
					'allow_null'    => 1,
					'return_format' => 'id',
					'ui'            => 1,
				),
			),
		)
	);
}
add_action( 'acf/init', 'almicahealing_register_testimonio_fields' );

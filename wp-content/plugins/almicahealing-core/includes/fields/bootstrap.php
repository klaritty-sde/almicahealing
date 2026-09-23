<?php
/**
 * Secure Custom Fields bootstrap.
 *
 * Every field group in this plugin is registered in code via
 * `acf_add_local_field_group()` (content model, "Field groups") so the
 * schema is versioned and deploys with the plugin. Nothing is defined
 * through the admin UI — a group created there would exist only in the
 * database of whichever environment it was clicked in.
 *
 * SCF is a fork of ACF and keeps ACF's PHP API, so the `acf_*` function
 * names below are correct for it.
 *
 * @package AlmicaHealingCore
 */

defined( 'ABSPATH' ) || exit;

/**
 * Whether Secure Custom Fields is available.
 *
 * Every read in the theme goes through `almicahealing_field()`, which
 * falls back to raw post meta, so the site degrades rather than fatals
 * when the plugin is missing (e.g. before it's installed on a new
 * environment).
 *
 * @return bool
 */
function almicahealing_has_scf() {
	return function_exists( 'acf_add_local_field_group' );
}

/**
 * Warns in the admin when the plugin is missing, since the editing UI
 * for most of the site's content silently disappears with it.
 */
function almicahealing_scf_admin_notice() {
	if ( almicahealing_has_scf() || ! current_user_can( 'activate_plugins' ) ) {
		return;
	}

	printf(
		'<div class="notice notice-error"><p>%s</p></div>',
		esc_html__( 'Álmica Healing: el plugin Secure Custom Fields no está activo. Los campos de servicios, cursos, profesionales y ajustes no se pueden editar hasta instalarlo.', 'almicahealing' )
	);
}
add_action( 'admin_notices', 'almicahealing_scf_admin_notice' );

/**
 * Modality choices for `servicio.modality` (decision D5).
 *
 * @return array<string,string> Machine value => label.
 */
function almicahealing_modality_choices() {
	return array(
		'presencial' => __( 'Presencial', 'almicahealing' ),
		'virtual'    => __( 'Virtual', 'almicahealing' ),
		'hibrida'    => __( 'Presencial y virtual', 'almicahealing' ),
	);
}

/**
 * Course level choices for `curso.level`.
 *
 * @return array<string,string> Machine value => label.
 */
function almicahealing_level_choices() {
	return array(
		'basico'     => __( 'Básico', 'almicahealing' ),
		'intermedio' => __( 'Intermedio', 'almicahealing' ),
		'abierto'    => __( 'Abierto a todos', 'almicahealing' ),
	);
}

/**
 * Heading choices for the numbered list on a course detail page.
 *
 * @return array<string,string> Machine value => label.
 */
function almicahealing_outcomes_heading_choices() {
	return array(
		'objetivos'  => __( 'Objetivos', 'almicahealing' ),
		'beneficios' => __( 'Beneficios', 'almicahealing' ),
		'temas'      => __( 'Temas', 'almicahealing' ),
	);
}

/**
 * The fixed benefit-icon set (content model Q8).
 *
 * Editors pick a slug; the SVG ships in the theme at
 * `assets/img/icons/beneficio-{slug}.svg`. Keeping it a closed list is
 * deliberate — an image field here would let the icon style drift.
 *
 * @return array<string,string> Slug => label.
 */
function almicahealing_benefit_icon_choices() {
	return array(
		'corazon'    => __( 'Corazón', 'almicahealing' ),
		'ondas'      => __( 'Ondas', 'almicahealing' ),
		'brote'      => __( 'Brote', 'almicahealing' ),
		'ojo'        => __( 'Ojo', 'almicahealing' ),
		'circulos'   => __( 'Círculos', 'almicahealing' ),
		'equilibrio' => __( 'Equilibrio', 'almicahealing' ),
		'espiral'    => __( 'Espiral', 'almicahealing' ),
		'manos'      => __( 'Manos', 'almicahealing' ),
		'luna'       => __( 'Luna', 'almicahealing' ),
		'chispa'     => __( 'Chispa', 'almicahealing' ),
	);
}

/**
 * Registers the "Ajustes de Álmica" options page (KW-151), which
 * replaces the hard-coded `inc/brand.php` values in the theme.
 */
function almicahealing_register_options_page() {
	if ( ! function_exists( 'acf_add_options_page' ) ) {
		return;
	}

	acf_add_options_page(
		array(
			'page_title'      => __( 'Ajustes de Álmica', 'almicahealing' ),
			'menu_title'      => __( 'Ajustes de Álmica', 'almicahealing' ),
			'menu_slug'       => 'almica-ajustes',
			'capability'      => 'manage_options',
			'icon_url'        => 'dashicons-admin-settings',
			'position'        => 24,
			'redirect'        => false,
			'update_button'   => __( 'Guardar ajustes', 'almicahealing' ),
			'updated_message' => __( 'Ajustes guardados.', 'almicahealing' ),
		)
	);
}
add_action( 'acf/init', 'almicahealing_register_options_page' );

<?php
/**
 * Small template helpers shared across template-parts.
 *
 * @package AlmicaHealing
 */

defined( 'ABSPATH' ) || exit;

/**
 * Renders the contact form via the site plugin, if it's active.
 * Guarded so the theme doesn't fatal when almicahealing-core is off.
 */
function almicahealing_render_contact_form() {
	if ( function_exists( 'almicahealing_contact_form' ) ) {
		almicahealing_contact_form();
		return;
	}

	if ( WP_DEBUG ) {
		echo '<!-- almicahealing-core is not active: contact form not rendered -->';
	}
}

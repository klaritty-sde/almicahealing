<?php
/**
 * Brand-level contact/social data, centralized so it's edited in one place.
 *
 * TODO: move to a Customizer/settings page once the client needs to edit
 * these without a deploy (see PLAN-NEW-SITE-FROM-KLARITTY.md Phase 10).
 *
 * @package AlmicaHealing
 */

defined( 'ABSPATH' ) || exit;

/**
 * Looks up a brand-level contact/social value.
 *
 * @param string $key One of 'email', 'phone', 'location', 'social'.
 * @return string|array The value, or an empty string if the key is unknown.
 */
function almicahealing_brand( $key ) {
	$brand = array(
		'email'    => 'almicahealing@gmail.com',
		'phone'    => '+52 81 7008 8058',
		'location' => 'México · sesiones virtuales',
		'social'   => array(
			'instagram' => '',
			'facebook'  => '',
			'tiktok'    => '',
		),
	);

	return $brand[ $key ] ?? '';
}

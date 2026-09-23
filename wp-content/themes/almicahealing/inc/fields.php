<?php
/**
 * Field-read helpers.
 *
 * Templates never call `get_field()` directly. Going through these
 * wrappers means the theme still renders when Secure Custom Fields is
 * inactive (it falls back to raw post meta), and a later move away from
 * SCF is a change in this file rather than in every template.
 *
 * @package AlmicaHealing
 */

defined( 'ABSPATH' ) || exit;

/**
 * Reads a custom field from a post.
 *
 * @param string           $name    Field name, e.g. 'price'.
 * @param int|WP_Post|null $post   Post to read from. Defaults to the current post.
 * @param mixed            $fallback Value returned when the field is empty or missing.
 * @return mixed
 */
function almicahealing_field( $name, $post = null, $fallback = '' ) {
	$post_id = $post instanceof WP_Post ? $post->ID : ( $post ? (int) $post : get_the_ID() );

	if ( ! $post_id ) {
		return $fallback;
	}

	if ( function_exists( 'get_field' ) ) {
		$value = get_field( $name, $post_id );
	} else {
		// Without SCF, scalars still resolve — repeaters and groups
		// don't, and the sections that use them stay hidden.
		$value = get_post_meta( $post_id, $name, true );
	}

	if ( null === $value || '' === $value || array() === $value || false === $value ) {
		return $fallback;
	}

	return $value;
}

/**
 * Reads a repeater field, always as an array.
 *
 * @param string           $name Field name.
 * @param int|WP_Post|null $post Post to read from.
 * @return array<int,array<string,mixed>>
 */
function almicahealing_rows( $name, $post = null ) {
	$rows = almicahealing_field( $name, $post, array() );

	return is_array( $rows ) ? $rows : array();
}

/**
 * Reads a global setting from the "Ajustes de Álmica" options page,
 * falling back to the packaged default.
 *
 * @param string $key Setting key, e.g. 'contact_email'.
 * @return string
 */
function almicahealing_setting( $key ) {
	$defaults = function_exists( 'almicahealing_setting_defaults' ) ? almicahealing_setting_defaults() : array();
	$default  = $defaults[ $key ] ?? '';

	if ( ! function_exists( 'get_field' ) ) {
		return $default;
	}

	$value = get_field( $key, 'option' );

	return ( null === $value || '' === $value ) ? $default : $value;
}

/**
 * Formats a price the way the design shows it: "$1,150.00 MXN" for
 * services (two decimals) and "$5,900 MXN" for courses (whole pesos).
 *
 * @param float|string $amount   Raw amount.
 * @param int          $decimals Decimal places.
 * @return string Empty string when there's no amount.
 */
function almicahealing_price( $amount, $decimals = 2 ) {
	if ( '' === $amount || null === $amount ) {
		return '';
	}

	return sprintf(
		'$%s %s',
		number_format( (float) $amount, $decimals, '.', ',' ),
		almicahealing_setting( 'currency_label' )
	);
}

/**
 * Formats a duration in minutes as the design's chip text, e.g. "60 min".
 *
 * @param int|string $minutes Duration in minutes.
 * @return string Empty string when there's no duration.
 */
function almicahealing_duration( $minutes ) {
	$minutes = (int) $minutes;

	if ( $minutes <= 0 ) {
		return '';
	}

	/* translators: %d: duration in minutes. */
	return sprintf( __( '%d min', 'almicahealing' ), $minutes );
}

/**
 * Resolves a page hero field, letting each template fall back to the
 * copy that shipped with the design when nothing has been entered yet.
 *
 * @param string           $name     Field name, e.g. 'hero_title'.
 * @param string           $fallback Designed copy.
 * @param int|WP_Post|null $post     Post to read from.
 * @return string
 */
function almicahealing_hero_field( $name, $fallback = '', $post = null ) {
	return (string) almicahealing_field( $name, $post, $fallback );
}

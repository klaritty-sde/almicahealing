<?php
/**
 * Server-side validation for the contact form.
 *
 * @package AlmicaHealingCore
 */

defined( 'ABSPATH' ) || exit;

/**
 * Sanitizes and validates a submission.
 *
 * @param array $input Unslashed data as it arrives in $_POST.
 * @return array{data: array, errors: array<string, string>}
 */
function almicahealing_contact_validate( array $input ) {
	$messages = almicahealing_contact_messages();
	$data     = array();
	$errors   = array();

	foreach ( almicahealing_contact_fields() as $key => $field ) {
		$raw = isset( $input[ $key ] ) ? $input[ $key ] : '';

		if ( ! is_string( $raw ) ) {
			$raw = '';
		}

		$value        = 'textarea' === $field['type'] ? sanitize_textarea_field( $raw ) : sanitize_text_field( $raw );
		$data[ $key ] = $value;

		if ( '' === $value ) {
			if ( ! empty( $field['required'] ) ) {
				$errors[ $key ] = $messages['required'];
			}
			continue;
		}

		if ( isset( $field['maxlength'] ) && mb_strlen( $value ) > $field['maxlength'] ) {
			$errors[ $key ] = $messages['tooLong'];
			continue;
		}

		if ( 'email' === $field['type'] && ! is_email( $value ) ) {
			$errors[ $key ] = $messages['email'];
		} elseif ( 'tel' === $field['type'] ) {
			$digits = strlen( preg_replace( '/\D/', '', $value ) );
			if ( ! preg_match( '/^[0-9+()\s.-]+$/', $value ) || $digits < 7 || $digits > 15 ) {
				$errors[ $key ] = $messages['phone'];
			}
		} elseif ( 'select' === $field['type'] && isset( $field['options'] ) && ! isset( $field['options'][ $value ] ) ) {
			$errors[ $key ] = $messages['option'];
		}
	}

	return array(
		'data'   => $data,
		'errors' => $errors,
	);
}

/**
 * Label => readable-value pairs for a submission, for email and wp-admin.
 *
 * @param array $data Validated data.
 * @return array<string, string>
 */
function almicahealing_contact_display_values( array $data ) {
	$values = array();

	foreach ( almicahealing_contact_fields() as $key => $field ) {
		$value = $data[ $key ] ?? '';

		if ( 'select' === $field['type'] && isset( $field['options'][ $value ] ) ) {
			$value = $field['options'][ $value ];
		}

		$values[ $field['label'] ] = '' === $value ? '—' : $value;
	}

	return $values;
}

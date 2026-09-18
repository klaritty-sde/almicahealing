<?php
/**
 * Internal notification and confirmation emails for the contact form.
 *
 * @package AlmicaHealingCore
 */

defined( 'ABSPATH' ) || exit;

/**
 * The address that receives new-contact notifications. Filterable so it
 * isn't hardcoded — see almicahealing-environment.php, which keeps this off
 * the client's inbox on non-production environments.
 *
 * @return string
 */
function almicahealing_contact_notify_to() {
	$default = defined( 'ALMICAHEALING_NOTIFY_TO' ) ? ALMICAHEALING_NOTIFY_TO : 'almicahealing@gmail.com';

	return apply_filters( 'almicahealing_contact_notify_to', $default );
}

/**
 * Sends the internal notification and the visitor's confirmation email.
 *
 * @param array $data Validated form data.
 * @return bool Whether both emails were accepted for sending.
 */
function almicahealing_contact_send_emails( array $data ) {
	$notify_to = almicahealing_contact_notify_to();

	$rows = '';
	foreach ( almicahealing_contact_display_values( $data ) as $label => $value ) {
		$rows .= sprintf(
			'<tr><th style="text-align:left;vertical-align:top;padding:6px 16px 6px 0;">%1$s</th><td style="padding:6px 0;">%2$s</td></tr>',
			esc_html( $label ),
			nl2br( esc_html( $value ) )
		);
	}

	$headers = array(
		'Content-Type: text/html; charset=UTF-8',
		'From: Álmica Healing <' . $notify_to . '>',
	);

	$notified = wp_mail(
		$notify_to,
		/* translators: %s: nombre de quien escribió. */
		sprintf( __( 'Nuevo contacto: %s', 'almicahealing' ), $data['nombre'] ),
		'<table style="border-collapse:collapse;font-family:Arial,sans-serif;font-size:14px;color:#263B33;">' . $rows . '</table>',
		array_merge( $headers, array( 'Reply-To: ' . $data['email'] ) )
	);

	$confirmed = wp_mail(
		$data['email'],
		__( 'Gracias por contactar a Álmica Healing', 'almicahealing' ),
		sprintf(
			'<div style="font-family:Arial,sans-serif;font-size:16px;line-height:1.5;color:#263B33;"><p>%1$s</p><p>%2$s</p></div>',
			/* translators: %s: nombre de quien escribió. */
			esc_html( sprintf( __( 'Hola %s,', 'almicahealing' ), $data['nombre'] ) ),
			esc_html__( 'Gracias por escribirnos. Leeremos tu mensaje y te responderemos pronto.', 'almicahealing' )
		),
		$headers
	);

	return $notified && $confirmed;
}

/**
 * Logs the real reason when wp_mail() fails (SMTP rejected, mail()
 * disabled, etc.) instead of leaving just a boolean.
 *
 * @param WP_Error $error Error from PHPMailer/wp_mail.
 */
function almicahealing_contact_log_mail_failure( WP_Error $error ) {
	$data = $error->get_error_data();
	$to   = isset( $data['to'] ) ? implode( ', ', (array) $data['to'] ) : 'desconocido';

	if ( defined( 'WP_DEBUG_LOG' ) && WP_DEBUG_LOG ) {
		// phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_error_log -- No dedicated logging service; error_log() falls through to debug.log with WP_DEBUG_LOG on.
		error_log( sprintf( 'Almica Healing contacto: wp_mail failed for %s: %s', $to, $error->get_error_message() ) );
	}
}
add_action( 'wp_mail_failed', 'almicahealing_contact_log_mail_failure' );

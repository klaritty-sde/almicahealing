<?php
/**
 * Renders the contact form and handles its submission via admin-post.php.
 *
 * No nonce, by design (same reasoning Klaritty used): a nonce would only
 * fail submissions from tabs left open for hours, and this form has no
 * session to protect. Spam/abuse is filtered by three independent checks
 * instead: a honeypot field, a minimum time-to-submit, and a per-IP rate
 * limit.
 *
 * @package AlmicaHealingCore
 */

defined( 'ABSPATH' ) || exit;

const ALMICAHEALING_CONTACT_MIN_SECONDS = 3;
const ALMICAHEALING_CONTACT_RATE_LIMIT  = 5;
const ALMICAHEALING_CONTACT_RATE_WINDOW = 10 * MINUTE_IN_SECONDS;

/**
 * Renders the public contact form. Called by the theme via
 * almicahealing_render_contact_form() in inc/template-tags.php.
 */
function almicahealing_contact_form() {
	?>
	<form class="contact-form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
		<input type="hidden" name="action" value="<?php echo esc_attr( ALMICAHEALING_CONTACT_ACTION ); ?>">
		<input type="hidden" name="ts" value="<?php echo esc_attr( time() ); ?>">
		<p class="contact-form__honeypot" aria-hidden="true">
			<label for="sitio_web"><?php esc_html_e( 'Sitio web', 'almicahealing' ); ?></label>
			<input type="text" id="sitio_web" name="sitio_web" tabindex="-1" autocomplete="off">
		</p>

		<?php foreach ( almicahealing_contact_fields() as $key => $field ) : ?>
			<p class="contact-form__field">
				<label for="almicahealing-<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $field['label'] ); ?></label>
				<?php if ( 'select' === $field['type'] ) : ?>
					<select id="almicahealing-<?php echo esc_attr( $key ); ?>" name="<?php echo esc_attr( $key ); ?>" <?php echo ! empty( $field['required'] ) ? 'required' : ''; ?>>
						<?php foreach ( $field['options'] as $value => $label ) : ?>
							<option value="<?php echo esc_attr( $value ); ?>" <?php selected( $field['default'] ?? '', $value ); ?>><?php echo esc_html( $label ); ?></option>
						<?php endforeach; ?>
					</select>
				<?php elseif ( 'textarea' === $field['type'] ) : ?>
					<textarea id="almicahealing-<?php echo esc_attr( $key ); ?>" name="<?php echo esc_attr( $key ); ?>" maxlength="<?php echo esc_attr( $field['maxlength'] ?? '' ); ?>" <?php echo ! empty( $field['required'] ) ? 'required' : ''; ?>></textarea>
				<?php else : ?>
					<input type="<?php echo esc_attr( $field['type'] ); ?>" id="almicahealing-<?php echo esc_attr( $key ); ?>" name="<?php echo esc_attr( $key ); ?>" maxlength="<?php echo esc_attr( $field['maxlength'] ?? '' ); ?>" autocomplete="<?php echo esc_attr( $field['autocomplete'] ?? 'off' ); ?>" <?php echo ! empty( $field['required'] ) ? 'required' : ''; ?>>
				<?php endif; ?>
			</p>
		<?php endforeach; ?>

		<button type="submit" class="button button--gold"><?php esc_html_e( 'Enviar', 'almicahealing' ); ?></button>
	</form>
	<?php
}

/**
 * The visitor's thank-you page, or the home page if none is set up.
 *
 * @return string
 */
function almicahealing_contact_thanks_url() {
	$thanks = get_page_by_path( 'gracias' );

	return $thanks ? get_permalink( $thanks ) : home_url( '/' );
}

/**
 * True once a client IP has submitted ALMICAHEALING_CONTACT_RATE_LIMIT
 * times within ALMICAHEALING_CONTACT_RATE_WINDOW.
 *
 * @param string $ip Client IP.
 * @return bool
 */
function almicahealing_contact_rate_limited( $ip ) {
	$key   = 'almicahealing_contact_rl_' . md5( $ip );
	$count = (int) get_transient( $key );

	if ( $count >= ALMICAHEALING_CONTACT_RATE_LIMIT ) {
		return true;
	}

	set_transient( $key, $count + 1, ALMICAHEALING_CONTACT_RATE_WINDOW );

	return false;
}

/**
 * Handles the form submission posted to admin-post.php.
 *
 * With JavaScript (Accept: application/json) it responds with JSON;
 * without it, it redirects to /gracias/ or shows the errors with a link
 * back.
 */
function almicahealing_contact_handle() {
	// phpcs:disable WordPress.Security.NonceVerification.Missing, WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- Public form, no session (see file docblock); honeypot + time-trap + rate limit filter abuse, and almicahealing_contact_validate() sanitizes every field.
	$accept     = isset( $_SERVER['HTTP_ACCEPT'] ) ? sanitize_text_field( wp_unslash( $_SERVER['HTTP_ACCEPT'] ) ) : '';
	$wants_json = false !== strpos( $accept, 'application/json' );
	$redirect   = almicahealing_contact_thanks_url();
	$ip         = isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '';

	// Honeypot: bots fill every field, humans never see this one.
	if ( ! empty( $_POST['sitio_web'] ) ) {
		if ( $wants_json ) {
			wp_send_json_success( array( 'redirect' => $redirect ) );
		}
		wp_safe_redirect( $redirect );
		exit;
	}

	// Time-trap: a submit faster than a human can fill the form is a bot.
	$rendered_at = isset( $_POST['ts'] ) ? (int) $_POST['ts'] : 0;
	if ( $rendered_at && ( time() - $rendered_at ) < ALMICAHEALING_CONTACT_MIN_SECONDS ) {
		if ( $wants_json ) {
			wp_send_json_success( array( 'redirect' => $redirect ) );
		}
		wp_safe_redirect( $redirect );
		exit;
	}

	if ( $ip && almicahealing_contact_rate_limited( $ip ) ) {
		$message = __( 'Demasiados envíos. Intenta de nuevo en unos minutos.', 'almicahealing' );
		if ( $wants_json ) {
			wp_send_json_error( array( 'message' => $message ), 429 );
		}
		wp_die(
			esc_html( $message ),
			'',
			array(
				'response'  => 429,
				'back_link' => true,
			)
		);
	}

	$result = almicahealing_contact_validate( wp_unslash( $_POST ) );
	// phpcs:enable

	if ( $result['errors'] ) {
		if ( $wants_json ) {
			wp_send_json_error( array( 'errors' => $result['errors'] ), 422 );
		}

		$fields = almicahealing_contact_fields();
		$items  = '';
		foreach ( $result['errors'] as $key => $message ) {
			$items .= '<li><strong>' . esc_html( $fields[ $key ]['label'] ) . ':</strong> ' . esc_html( $message ) . '</li>';
		}
		wp_die(
			wp_kses_post( '<ul>' . $items . '</ul>' ),
			esc_html__( 'Revisa el formulario', 'almicahealing' ),
			array(
				'response'  => 422,
				'back_link' => true,
			)
		);
	}

	$saved    = almicahealing_contact_save_lead( $result['data'] );
	$notified = almicahealing_contact_send_emails( $result['data'] );

	if ( ! $saved && ! $notified ) {
		$message = almicahealing_contact_messages()['failed'];
		if ( $wants_json ) {
			wp_send_json_error( array( 'message' => $message ), 500 );
		}
		wp_die(
			esc_html( $message ),
			'',
			array(
				'response'  => 500,
				'back_link' => true,
			)
		);
	}

	if ( $wants_json ) {
		wp_send_json_success( array( 'redirect' => $redirect ) );
	}
	wp_safe_redirect( $redirect );
	exit;
}
add_action( 'admin_post_nopriv_' . ALMICAHEALING_CONTACT_ACTION, 'almicahealing_contact_handle' );
add_action( 'admin_post_' . ALMICAHEALING_CONTACT_ACTION, 'almicahealing_contact_handle' );

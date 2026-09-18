<?php
/**
 * Plugin Name: Almica Healing Analytics (Google Tag Manager)
 * Description: Injects the official Google Tag Manager snippets via wp_head/wp_body_open. Theme-independent MU plugin. Production only.
 * Version:     1.0.0
 * Author:      Klaritty SDE
 *
 * @package AlmicaHealingAnalytics
 */

defined( 'ABSPATH' ) || exit;

/**
 * Whether GTM should load on the current request: production only, never
 * in wp-admin or WP-CLI, and only once a real container ID is configured
 * (via the ALMICAHEALING_GTM_CONTAINER_ID wp-config constant — never
 * committed to git).
 *
 * @return bool
 */
function almicahealing_gtm_should_load() {
	if ( 'production' !== wp_get_environment_type() ) {
		return false;
	}

	if ( is_admin() ) {
		return false;
	}

	if ( defined( 'WP_CLI' ) && WP_CLI ) {
		return false;
	}

	if ( ! defined( 'ALMICAHEALING_GTM_CONTAINER_ID' ) ) {
		return false;
	}

	// Validate the shape of a real container ID rather than comparing
	// against a placeholder string.
	return (bool) preg_match( '/^GTM-[A-Z0-9]+$/', ALMICAHEALING_GTM_CONTAINER_ID );
}

/**
 * Prints the GTM <script> snippet inside <head>.
 */
function almicahealing_gtm_head_snippet() {
	if ( ! almicahealing_gtm_should_load() ) {
		return;
	}

	$gtm_id = esc_js( ALMICAHEALING_GTM_CONTAINER_ID );
	?>
	<!-- Google Tag Manager -->
	<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
	new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
	j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
	'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
	})(window,document,'script','dataLayer','<?php echo $gtm_id; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- already escaped via esc_js() above. ?>');</script>
	<!-- End Google Tag Manager -->
	<?php
}
add_action( 'wp_head', 'almicahealing_gtm_head_snippet', 1 );

/**
 * Prints the GTM <noscript> snippet immediately after <body>.
 */
function almicahealing_gtm_body_snippet() {
	if ( ! almicahealing_gtm_should_load() ) {
		return;
	}

	$gtm_id = rawurlencode( ALMICAHEALING_GTM_CONTAINER_ID );
	?>
	<!-- Google Tag Manager (noscript) -->
	<noscript><iframe title="Google Tag Manager" src="https://www.googletagmanager.com/ns.html?id=<?php echo esc_attr( $gtm_id ); ?>"
	height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
	<!-- End Google Tag Manager (noscript) -->
	<?php
}
add_action( 'wp_body_open', 'almicahealing_gtm_body_snippet', 1 );

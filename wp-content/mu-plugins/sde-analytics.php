<?php
/**
 * Plugin Name: SDE Analytics (Google Tag Manager)
 * Description: Injects the official Google Tag Manager snippets via wp_head/wp_body_open. Site-neutral: the same file ships unchanged in every Klaritty SDE site, configured from wp-config.php.
 * Version:     2.1.0
 * Author:      Klaritty SDE
 *
 * Configure per environment in wp-config.php (never committed):
 *
 *     define( 'SDE_GTM_CONTAINER_ID', 'GTM-XXXXXXX' );
 *
 *     // Optional: environments that load GTM, as a comma-separated string
 *     // or an array. Defaults to production only.
 *     define( 'SDE_GTM_ENVIRONMENTS', 'production,local' );
 *
 * Keep this file byte-identical across sites; site-specific behavior belongs
 * in wp-config.php or the `sde_analytics_should_load` filter.
 *
 * @package SDEAnalytics
 */

defined( 'ABSPATH' ) || exit;

/**
 * Cookie that carries queued dataLayer events to the visitor's next page.
 */
const SDE_ANALYTICS_QUEUE_COOKIE = 'sde_analytics_queue';

/**
 * Returns the configured container ID, or '' when it is missing, not shaped
 * like a real container ID, or still the GTM-XXXXXXX example from above.
 *
 * @return string
 */
function sde_analytics_container_id() {
	if ( ! defined( 'SDE_GTM_CONTAINER_ID' ) ) {
		return '';
	}

	$id = trim( (string) SDE_GTM_CONTAINER_ID );

	return preg_match( '/^GTM-(?!X+$)[A-Z0-9]+$/', $id ) ? $id : '';
}

/**
 * Returns the environment types allowed to load GTM.
 *
 * @return string[]
 */
function sde_analytics_environments() {
	$environments = defined( 'SDE_GTM_ENVIRONMENTS' ) ? SDE_GTM_ENVIRONMENTS : 'production';

	if ( is_string( $environments ) ) {
		$environments = explode( ',', $environments );
	}

	return array_filter( array_map( 'trim', (array) $environments ) );
}

/**
 * Whether GTM should load on the current request.
 *
 * Requires a valid container ID and an allowed environment, and skips
 * wp-admin, WP-CLI, and logged-in users so the team's own visits do not
 * count (test with a private window).
 *
 * @return bool
 */
function sde_analytics_should_load() {
	$load = '' !== sde_analytics_container_id()
		&& in_array( wp_get_environment_type(), sde_analytics_environments(), true )
		&& ! is_admin()
		&& ! ( defined( 'WP_CLI' ) && WP_CLI )
		&& ! is_user_logged_in();

	/**
	 * Filters whether GTM loads on the current request.
	 *
	 * @param bool $load Whether GTM loads.
	 */
	return (bool) apply_filters( 'sde_analytics_should_load', $load );
}

/**
 * Prints the GTM <script> snippet inside <head>.
 */
function sde_analytics_head_snippet() {
	if ( ! sde_analytics_should_load() ) {
		return;
	}

	$gtm_id = esc_js( sde_analytics_container_id() );
	?>
	<!-- Google Tag Manager -->
	<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
	new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
	j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
	'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
	})(window,document,'script','dataLayer','<?php echo $gtm_id; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- already escaped via esc_js() above. ?>');</script>
	<!-- End Google Tag Manager -->
	<script>(function(){var n='<?php echo esc_js( SDE_ANALYTICS_QUEUE_COOKIE ); ?>',m=document.cookie.match(new RegExp('(?:^|; )'+n+'=([^;]*)'));
	if(!m){return;}document.cookie=n+'=; Max-Age=0; path=/; SameSite=Lax';
	try{JSON.parse(decodeURIComponent(m[1])).forEach(function(e){if(e&&e.event){window.dataLayer.push(e);}});}catch(e){}})();</script>
	<?php
}
add_action( 'wp_head', 'sde_analytics_head_snippet', 1 );

/**
 * Queues a dataLayer event for the visitor's next page view.
 *
 * For flows that end in a server-side redirect, such as a form posted
 * without JavaScript, where no page is left to push the event from. The
 * event rides in a short-lived cookie that the next page reads and clears
 * client-side, so it also works behind full-page caching. Call it before
 * any output, typically right before wp_safe_redirect().
 *
 * @param string                     $event  GA4-style event name, e.g. 'generate_lead'.
 * @param array<string, scalar|null> $params Flat event parameters, e.g. array( 'form_name' => 'contacto' ).
 * @return bool Whether the event was queued.
 */
function sde_analytics_queue_event( $event, array $params = array() ) {
	if ( headers_sent() || ! preg_match( '/^[a-z][a-z0-9_]{0,39}$/', $event ) ) {
		return false;
	}

	// Keep events already queued this page view (at most the last four),
	// dropping anything in the cookie that is not a well-formed event.
	$queue = array();
	if ( isset( $_COOKIE[ SDE_ANALYTICS_QUEUE_COOKIE ] ) ) {
		$queued = json_decode( wp_unslash( $_COOKIE[ SDE_ANALYTICS_QUEUE_COOKIE ] ), true ); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- JSON; every entry is validated below.
		foreach ( is_array( $queued ) ? array_slice( $queued, -4 ) : array() as $entry ) {
			if ( is_array( $entry ) && isset( $entry['event'] ) && is_string( $entry['event'] ) && preg_match( '/^[a-z][a-z0-9_]{0,39}$/', $entry['event'] ) ) {
				$queue[] = array_filter( $entry, 'is_scalar' );
			}
		}
	}

	$queue[] = array_merge( array_filter( $params, 'is_scalar' ), array( 'event' => $event ) );

	return setrawcookie(
		SDE_ANALYTICS_QUEUE_COOKIE,
		rawurlencode( wp_json_encode( $queue ) ),
		array(
			'expires'  => time() + 5 * MINUTE_IN_SECONDS,
			'path'     => '/',
			'secure'   => is_ssl(),
			'httponly' => false, // Read by the snippet in sde_analytics_head_snippet().
			'samesite' => 'Lax',
		)
	);
}

/**
 * Prints the GTM <noscript> snippet immediately after <body>.
 */
function sde_analytics_body_snippet() {
	if ( ! sde_analytics_should_load() ) {
		return;
	}

	$gtm_id = rawurlencode( sde_analytics_container_id() );
	?>
	<!-- Google Tag Manager (noscript) -->
	<noscript><iframe title="Google Tag Manager" src="https://www.googletagmanager.com/ns.html?id=<?php echo esc_attr( $gtm_id ); ?>"
	height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
	<!-- End Google Tag Manager (noscript) -->
	<?php
}
add_action( 'wp_body_open', 'sde_analytics_body_snippet', 1 );

/**
 * Warns administrators on production when no valid container is configured,
 * so a deploy without the wp-config.php constant cannot silently stop tracking.
 */
function sde_analytics_missing_container_notice() {
	if ( 'production' !== wp_get_environment_type() || '' !== sde_analytics_container_id() || ! current_user_can( 'manage_options' ) ) {
		return;
	}

	printf(
		'<div class="notice notice-error"><p>%s</p></div>',
		esc_html__( 'SDE Analytics: Google Tag Manager is not loading. Define SDE_GTM_CONTAINER_ID (GTM-XXXXXXX) in wp-config.php.', 'sde-analytics' )
	);
}
add_action( 'admin_notices', 'sde_analytics_missing_container_notice' );

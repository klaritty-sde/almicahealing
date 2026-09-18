<?php
/**
 * Plugin Name: Almica Healing Environment Safety Net
 * Description: Non-production guardrails — blocks search indexing, flags the environment in the admin bar, and blocks outgoing mail to non-allowlisted addresses.
 * Version:     1.0.0
 * Author:      Klaritty SDE
 *
 * @package AlmicaHealingEnvironment
 */

defined( 'ABSPATH' ) || exit;

/**
 * Forces "discourage search engines" off production so a local/staging
 * clone never accidentally gets indexed.
 */
function almicahealing_force_non_production_privacy() {
	if ( 'production' === wp_get_environment_type() ) {
		return;
	}

	if ( '0' !== get_option( 'blog_public' ) ) {
		update_option( 'blog_public', '0' );
	}
}
add_action( 'init', 'almicahealing_force_non_production_privacy' );

/**
 * Adds a LOCAL/STAGING badge to the admin bar so nobody mistakes a
 * non-production environment for the real site.
 *
 * @param WP_Admin_Bar $admin_bar Core admin bar instance.
 */
function almicahealing_environment_admin_bar_badge( $admin_bar ) {
	$env = wp_get_environment_type();

	if ( 'production' === $env ) {
		return;
	}

	$colors = array(
		'local'       => '#2271b1',
		'development' => '#2271b1',
		'staging'     => '#d63638',
	);

	$admin_bar->add_node(
		array(
			'id'    => 'almicahealing-environment',
			'title' => strtoupper( $env ),
			'meta'  => array(
				'class' => 'almicahealing-environment-badge',
				'html'  => sprintf(
					'<style>#wp-admin-bar-almicahealing-environment .ab-item{background:%s!important;color:#fff!important;font-weight:600;}</style>',
					esc_attr( $colors[ $env ] ?? '#787c82' )
				),
			),
		)
	);
}
add_action( 'admin_bar_menu', 'almicahealing_environment_admin_bar_badge', 999 );

/**
 * Addresses that outgoing mail is allowed to reach on staging — the
 * site's own domain.
 *
 * @return array<string>
 */
function almicahealing_mail_allowlist_domains() {
	return apply_filters( 'almicahealing_mail_allowlist_domains', array( 'almicahealing.com' ) );
}

/**
 * Reroutes wp_mail() recipients that aren't on the allowlist to a dev
 * inbox on staging — prevents a staging test run from emailing a real
 * client or lead. Local is exempt: VVV's MailHog already intercepts
 * every outgoing message at the VM level regardless of recipient (see
 * provision/core/mailhog), so this would just be redundant there.
 *
 * @param array $args wp_mail() arguments.
 * @return array
 */
function almicahealing_guard_staging_mail( $args ) {
	if ( 'staging' !== wp_get_environment_type() ) {
		return $args;
	}

	if ( ! defined( 'ALMICAHEALING_DEV_INBOX' ) ) {
		return $args;
	}

	$allowlist  = almicahealing_mail_allowlist_domains();
	$rerouted   = array();
	$args['to'] = array();

	foreach ( (array) $args['to'] as $recipient ) {
		$domain = strtolower( substr( strrchr( $recipient, '@' ), 1 ) );
		if ( in_array( $domain, $allowlist, true ) ) {
			$args['to'][] = $recipient;
		} else {
			$rerouted[] = $recipient;
		}
	}

	if ( $rerouted ) {
		$args['to'][]    = ALMICAHEALING_DEV_INBOX;
		$args['subject'] = '[staging → ' . implode( ', ', $rerouted ) . '] ' . $args['subject'];
	}

	return $args;
}
add_filter( 'wp_mail', 'almicahealing_guard_staging_mail' );

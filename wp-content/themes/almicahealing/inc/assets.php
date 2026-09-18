<?php
/**
 * Enqueue theme CSS/JS. Everything goes through this file — no inline
 * <link>/<script> tags in templates.
 *
 * @package AlmicaHealing
 */

defined( 'ABSPATH' ) || exit;

/**
 * Enqueues the compiled theme CSS/JS.
 */
function almicahealing_enqueue_assets() {
	$css_path = ALMICAHEALING_DIR . '/build/app.css';
	$js_path  = ALMICAHEALING_DIR . '/build/app.js';

	if ( file_exists( $css_path ) ) {
		wp_enqueue_style(
			'almicahealing-app',
			ALMICAHEALING_URI . '/build/app.css',
			array(),
			filemtime( $css_path )
		);
	}

	if ( file_exists( $js_path ) ) {
		wp_enqueue_script(
			'almicahealing-app',
			ALMICAHEALING_URI . '/build/app.js',
			array(),
			filemtime( $js_path ),
			array( 'strategy' => 'defer' )
		);
	}
}
add_action( 'wp_enqueue_scripts', 'almicahealing_enqueue_assets' );

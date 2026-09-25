<?php
/**
 * Theme supports, menus, image sizes.
 *
 * @package AlmicaHealing
 */

defined( 'ABSPATH' ) || exit;

/**
 * Registers theme supports, nav menus and image sizes.
 */
function almicahealing_setup() {
	load_theme_textdomain( 'almicahealing', ALMICAHEALING_DIR . '/languages' );

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'responsive-embeds' );

	register_nav_menus(
		array(
			'primary' => __( 'Menú principal', 'almicahealing' ),
			'footer'  => __( 'Menú de pie de página', 'almicahealing' ),
		)
	);

	add_image_size( 'almicahealing-card', 640, 480, true );
	add_image_size( 'almicahealing-hero', 1600, 900, true );
	// Therapist portraits are drawn in a circle, so they need a SQUARE
	// crop. Asking for the 4:3 card size instead shaves the top and
	// bottom off a square photo and then the circle clips the sides,
	// which cuts faces. 400px covers the largest circle (128px) at 3x.
	add_image_size( 'almicahealing-portrait', 400, 400, true );
}
add_action( 'after_setup_theme', 'almicahealing_setup' );

<?php
/**
 * Minimal meta/OG tags. Replace with a dedicated SEO plugin if the client
 * needs more control (redirects, sitemaps, schema) — see Phase 10 notes.
 *
 * @package AlmicaHealing
 */

defined( 'ABSPATH' ) || exit;

/**
 * Prints the description and Open Graph meta tags.
 */
function almicahealing_meta_tags() {
	$description = get_bloginfo( 'description' );

	if ( is_singular() ) {
		$excerpt     = get_the_excerpt();
		$description = $excerpt ? $excerpt : $description;
	}

	printf( '<meta name="description" content="%s">' . "\n", esc_attr( wp_strip_all_tags( $description ) ) );
	printf( '<meta property="og:title" content="%s">' . "\n", esc_attr( wp_get_document_title() ) );
	printf( '<meta property="og:description" content="%s">' . "\n", esc_attr( wp_strip_all_tags( $description ) ) );
	printf( '<meta property="og:type" content="%s">' . "\n", is_singular() ? 'article' : 'website' );
}
add_action( 'wp_head', 'almicahealing_meta_tags' );

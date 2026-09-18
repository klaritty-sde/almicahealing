<?php
/**
 * Fallback template.
 *
 * @package AlmicaHealing
 */

defined( 'ABSPATH' ) || exit;

get_header();

if ( have_posts() ) {
	while ( have_posts() ) {
		the_post();
		the_title( '<h1>', '</h1>' );
		the_content();
	}
} else {
	esc_html_e( 'No se encontró contenido.', 'almicahealing' );
}

get_footer();

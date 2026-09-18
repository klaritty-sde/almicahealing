<?php
/**
 * Home. Section order follows the Figma "Home" frame (node-id 146-31):
 * hero, services teaser, courses teaser, contact.
 *
 * @package AlmicaHealing
 */

defined( 'ABSPATH' ) || exit;

get_header();

get_template_part( 'template-parts/sections/hero' );
get_template_part( 'template-parts/sections/services' );
get_template_part( 'template-parts/sections/courses' );
get_template_part( 'template-parts/sections/contact' );

get_footer();

<?php
/**
 * Home. Section order follows the Figma "Home" frame (node-id 146-31):
 * hero, intro, services teaser, how-it-works, quote interlude, courses
 * teaser, testimonials. Contact only lives in the footer on this page.
 *
 * @package AlmicaHealing
 */

defined( 'ABSPATH' ) || exit;

get_header();

get_template_part( 'template-parts/sections/hero' );
get_template_part( 'template-parts/sections/intro' );
get_template_part( 'template-parts/sections/services' );
get_template_part( 'template-parts/sections/how-it-works' );
get_template_part( 'template-parts/sections/quote-interlude' );
get_template_part( 'template-parts/sections/courses' );
get_template_part( 'template-parts/sections/testimonials' );

get_footer();

<?php
/**
 * "Acerca de" (Figma "Acerca de" frame, node-id 146-432): hero, "Nosotros"
 * history block, founder profile, and "Formación" credentials.
 *
 * @package AlmicaHealing
 */

defined( 'ABSPATH' ) || exit;

get_header();

get_template_part( 'template-parts/sections/about-hero' );
get_template_part( 'template-parts/sections/historia' );
get_template_part( 'template-parts/sections/fundadora' );
get_template_part( 'template-parts/sections/formacion' );

get_footer();

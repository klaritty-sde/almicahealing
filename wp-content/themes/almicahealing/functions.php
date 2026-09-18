<?php
/**
 * Almica Healing theme bootstrap.
 *
 * @package AlmicaHealing
 */

defined( 'ABSPATH' ) || exit;

define( 'ALMICAHEALING_VERSION', '0.1.0' );
define( 'ALMICAHEALING_DIR', get_template_directory() );
define( 'ALMICAHEALING_URI', get_template_directory_uri() );

require ALMICAHEALING_DIR . '/inc/setup.php';
require ALMICAHEALING_DIR . '/inc/assets.php';
require ALMICAHEALING_DIR . '/inc/brand.php';
require ALMICAHEALING_DIR . '/inc/seo.php';
require ALMICAHEALING_DIR . '/inc/template-tags.php';

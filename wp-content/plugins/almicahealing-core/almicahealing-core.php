<?php
/**
 * Plugin Name: Almica Healing — Core
 * Description: Site-specific business logic — services/courses content types and the contact form. Presentation stays in the theme.
 * Version: 0.1.0
 * Requires PHP: 8.2
 * Text Domain: almicahealing
 *
 * @package AlmicaHealingCore
 */

defined( 'ABSPATH' ) || exit;

define( 'ALMICAHEALING_CORE_DIR', plugin_dir_path( __FILE__ ) );
define( 'ALMICAHEALING_CORE_URI', plugin_dir_url( __FILE__ ) );

require ALMICAHEALING_CORE_DIR . 'includes/cpt/servicio.php';
require ALMICAHEALING_CORE_DIR . 'includes/cpt/curso.php';
require ALMICAHEALING_CORE_DIR . 'includes/cpt/testimonio.php';

require ALMICAHEALING_CORE_DIR . 'includes/contact/countries.php';
require ALMICAHEALING_CORE_DIR . 'includes/contact/fields.php';
require ALMICAHEALING_CORE_DIR . 'includes/contact/validation.php';
require ALMICAHEALING_CORE_DIR . 'includes/contact/leads.php';
require ALMICAHEALING_CORE_DIR . 'includes/contact/mail.php';
require ALMICAHEALING_CORE_DIR . 'includes/contact/handler.php';

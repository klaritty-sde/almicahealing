<?php
/**
 * Contact section. Renders the form from almicahealing-core if it's active.
 *
 * @package AlmicaHealing
 */

defined( 'ABSPATH' ) || exit;
?>
<section class="contact" id="contacto">
	<div class="contact__inner">
		<h2 class="contact__title"><?php esc_html_e( 'Contáctanos', 'almicahealing' ); ?></h2>
		<?php almicahealing_render_contact_form(); ?>
	</div>
</section>

<?php
/**
 * Quote interlude between "How it works" and "Courses" (Figma
 * "QuoteInterlude" frame, node-id 146-197).
 *
 * @package AlmicaHealing
 */

defined( 'ABSPATH' ) || exit;
?>
<section class="quote-interlude">
	<div
		class="quote-interlude__media"
		aria-hidden="true"
		style="background-image: linear-gradient(to top, rgba(38,59,51,.9), rgba(38,59,51,.5)), url(<?php echo esc_url( get_theme_file_uri( 'assets/img/home-quote-interlude.jpg' ) ); ?>);"
	></div>
	<blockquote class="quote-interlude__quote">
		<p><?php esc_html_e( 'La claridad no llega de golpe:', 'almicahealing' ); ?></p>
		<p><em><?php esc_html_e( 'se construye paso a paso, proceso a proceso.', 'almicahealing' ); ?></em></p>
	</blockquote>
</section>

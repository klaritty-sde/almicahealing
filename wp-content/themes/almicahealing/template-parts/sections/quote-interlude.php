<?php
/**
 * Quote interlude between "How it works" and "Courses" (Figma
 * "QuoteInterlude" frame, node-id 146-197). Copy and image come from
 * the `quote` group on the front page.
 *
 * @package AlmicaHealing
 */

defined( 'ABSPATH' ) || exit;

$almicahealing_quote = almicahealing_field( 'quote', get_the_ID(), array() );
$almicahealing_quote = is_array( $almicahealing_quote ) ? $almicahealing_quote : array();

$almicahealing_image_id = $almicahealing_quote['image'] ?? 0;
$almicahealing_image    = $almicahealing_image_id
	? wp_get_attachment_image_url( (int) $almicahealing_image_id, 'almicahealing-hero' )
	: get_theme_file_uri( 'assets/img/home-quote-interlude.jpg' );
?>
<section class="quote-interlude">
	<?php
	/*
	 * One flat 50% wash, not a gradient reaching 90% at the foot — Figma
	 * node 146-198. The heavier end was darkening the sunset out of the
	 * photo and reading as a green filter.
	 */
	?>
	<div
		class="quote-interlude__media"
		aria-hidden="true"
		style="background-image: linear-gradient(rgba(38,59,51,.5), rgba(38,59,51,.5)), url(<?php echo esc_url( $almicahealing_image ); ?>);"
	></div>
	<blockquote class="quote-interlude__quote">
		<p><?php echo esc_html( $almicahealing_quote['line_1'] ?? __( 'La claridad no llega de golpe:', 'almicahealing' ) ); ?></p>
		<p><em><?php echo esc_html( $almicahealing_quote['line_2'] ?? __( 'se construye paso a paso, proceso a proceso.', 'almicahealing' ) ); ?></em></p>
	</blockquote>
</section>

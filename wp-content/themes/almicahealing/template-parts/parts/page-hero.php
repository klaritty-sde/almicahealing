<?php
/**
 * Listing-page hero (Servicios, Cursos, legal pages).
 *
 * Reads the shared `group_page_hero` fields so the copy is editable,
 * falling back to the copy the design shipped with — that way the page
 * looks right before anyone has opened the editor.
 *
 * $args: eyebrow, title, subtitle, image (string) — the designed
 * fallbacks. `image` is a URL used until an editor uploads one.
 *
 * @package AlmicaHealing
 */

defined( 'ABSPATH' ) || exit;

$almicahealing_defaults = wp_parse_args(
	$args ?? array(),
	array(
		'eyebrow'  => '',
		'title'    => '',
		'subtitle' => '',
		'image'    => '',
		'modifier' => '',
	)
);

$almicahealing_eyebrow  = almicahealing_hero_field( 'hero_eyebrow', $almicahealing_defaults['eyebrow'] );
$almicahealing_title    = almicahealing_hero_field( 'hero_title', $almicahealing_defaults['title'] );
$almicahealing_subtitle = almicahealing_hero_field( 'hero_subtitle', $almicahealing_defaults['subtitle'] );
$almicahealing_image_id = almicahealing_field( 'hero_image' );
$almicahealing_image    = $almicahealing_image_id
	? wp_get_attachment_image_url( (int) $almicahealing_image_id, 'almicahealing-hero' )
	: $almicahealing_defaults['image'];
?>
<section class="hero hero--short<?php echo $almicahealing_defaults['modifier'] ? ' ' . esc_attr( $almicahealing_defaults['modifier'] ) : ''; ?>">
	<div
		class="hero__media"
		aria-hidden="true"
		<?php if ( $almicahealing_image ) : ?>
			style="background-image: linear-gradient(to bottom right, rgba(38,59,51,.85), rgba(38,59,51,.65)), url(<?php echo esc_url( $almicahealing_image ); ?>);"
		<?php endif; ?>
	></div>
	<div class="hero__inner hero__inner--center">
		<?php if ( $almicahealing_eyebrow ) : ?>
			<p class="hero__eyebrow"><?php echo esc_html( $almicahealing_eyebrow ); ?></p>
		<?php endif; ?>

		<h1 class="hero__title"><?php echo esc_html( $almicahealing_title ); ?></h1>

		<?php if ( $almicahealing_subtitle ) : ?>
			<p class="hero__subtitle"><?php echo esc_html( $almicahealing_subtitle ); ?></p>
		<?php endif; ?>
	</div>
</section>

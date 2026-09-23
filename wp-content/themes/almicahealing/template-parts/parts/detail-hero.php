<?php
/**
 * Detail-page hero, shared by single-servicio.php and single-curso.php
 * (Figma frames 5–7 and 10–20): full-bleed photo under a dark scrim,
 * a back link, centred eyebrow / title / tagline and a meta chip.
 *
 * Expected $args:
 * - back_url, back_label (string) — the "Volver a…" link.
 * - eyebrow, title, tagline (string).
 * - chips (string[]) — pill labels, e.g. "60 min" or the course's
 *   program label.
 * - chips_first (bool) — render the pills above the title instead of
 *   below the tagline. Courses lead with the programme pill (frames
 *   5–7); services close with the duration chip (frames 10–20).
 * - image (string) — background image URL.
 *
 * @package AlmicaHealing
 */

defined( 'ABSPATH' ) || exit;

$almicahealing_hero = wp_parse_args(
	$args ?? array(),
	array(
		'back_url'    => '',
		'back_label'  => '',
		'eyebrow'     => '',
		'title'       => '',
		'tagline'     => '',
		'chips'       => array(),
		'chips_first' => false,
		'image'       => '',
	)
);
?>
<section class="detail-hero">
	<?php if ( $almicahealing_hero['image'] ) : ?>
		<div class="detail-hero__media" aria-hidden="true" style="background-image: url(<?php echo esc_url( $almicahealing_hero['image'] ); ?>);"></div>
	<?php endif; ?>
	<div class="detail-hero__scrim" aria-hidden="true"></div>

	<div class="detail-hero__inner">
		<?php if ( $almicahealing_hero['back_url'] ) : ?>
			<?php almicahealing_back_link( $almicahealing_hero['back_url'], $almicahealing_hero['back_label'] ); ?>
		<?php endif; ?>

		<div class="detail-hero__content">
			<?php if ( $almicahealing_hero['chips_first'] ) : ?>
				<?php if ( array_filter( $almicahealing_hero['chips'] ) ) : ?>
				<ul class="detail-hero__chips detail-hero__chips--above">
					<?php foreach ( array_filter( $almicahealing_hero['chips'] ) as $almicahealing_chip ) : ?>
						<li class="detail-hero__chip"><?php echo esc_html( $almicahealing_chip ); ?></li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
			<?php endif; ?>

			<?php if ( $almicahealing_hero['eyebrow'] ) : ?>
				<p class="detail-hero__eyebrow"><?php echo esc_html( $almicahealing_hero['eyebrow'] ); ?></p>
			<?php endif; ?>

			<h1 class="detail-hero__title"><?php echo esc_html( $almicahealing_hero['title'] ); ?></h1>

			<?php if ( $almicahealing_hero['tagline'] ) : ?>
				<p class="detail-hero__tagline"><?php echo esc_html( $almicahealing_hero['tagline'] ); ?></p>
			<?php endif; ?>

			<?php if ( ! $almicahealing_hero['chips_first'] ) : ?>
				<?php if ( array_filter( $almicahealing_hero['chips'] ) ) : ?>
				<ul class="detail-hero__chips">
					<?php foreach ( array_filter( $almicahealing_hero['chips'] ) as $almicahealing_chip ) : ?>
						<li class="detail-hero__chip"><?php echo esc_html( $almicahealing_chip ); ?></li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
			<?php endif; ?>

		</div>
	</div>
</section>

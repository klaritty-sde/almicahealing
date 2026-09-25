<?php
/**
 * Course detail — the template all three courses render through.
 * Reference instance: Clantanra (Figma frame 5, node 177-748). Check
 * anything to do with the Inversión card against Riutunmi (node
 * 181-3772) instead: Clantanra hides that card, so its sidebar looks
 * correct under orderings that are wrong on the other two courses.
 *
 * Section order: hero, then "Sobre el curso" as two columns, then
 * "Otros programas". The left column holds the copy AND the numbered
 * outcomes box — the box is only as wide as the copy, not a full-width
 * band, and the sidebar runs alongside it. The sidebar's own order is
 * Inversión, Facilitador/a, contact card.
 *
 * Clantanra has no price, which is the "price on request" variation:
 * the Inversión card is hidden and the global `price_on_request_text`
 * is shown on the contact card instead.
 *
 * @package AlmicaHealing
 */

defined( 'ABSPATH' ) || exit;

get_header();

while ( have_posts() ) :
	the_post();

	$almicahealing_id           = get_the_ID();
	$almicahealing_tagline      = almicahealing_field( 'tagline', $almicahealing_id, get_the_excerpt() );
	$almicahealing_label        = almicahealing_field( 'program_label', $almicahealing_id );
	$almicahealing_price        = almicahealing_field( 'price', $almicahealing_id );
	$almicahealing_duration     = almicahealing_field( 'duration', $almicahealing_id );
	$almicahealing_heading_key  = almicahealing_field( 'outcomes_heading', $almicahealing_id, 'objetivos' );
	$almicahealing_headings     = function_exists( 'almicahealing_outcomes_heading_choices' ) ? almicahealing_outcomes_heading_choices() : array();
	$almicahealing_outcomes     = almicahealing_rows( 'outcomes', $almicahealing_id );
	$almicahealing_facilitators = array_filter( array_map( 'intval', (array) almicahealing_field( 'facilitators', $almicahealing_id, array() ) ) );
	$almicahealing_email        = almicahealing_setting( 'contact_email' );

	$almicahealing_others = get_posts(
		array(
			'post_type'      => 'curso',
			'posts_per_page' => -1,
			'orderby'        => 'menu_order',
			'order'          => 'ASC',
			'post__not_in'   => array( $almicahealing_id ),
			'fields'         => 'ids',
		)
	);
	?>

	<?php
	get_template_part(
		'template-parts/parts/detail-hero',
		null,
		array(
			'back_url'    => almicahealing_page_url( 'cursos' ),
			'back_label'  => __( 'Volver a cursos', 'almicahealing' ),
			'eyebrow'     => '',
			'title'       => get_the_title(),
			'tagline'     => $almicahealing_tagline,
			'chips'       => array( $almicahealing_label ),
			'chips_first' => true,
			'image'       => almicahealing_hero_image_url( $almicahealing_id ),
		)
	);
	?>

	<section class="detail-about detail-about--course">
		<div class="detail-about__inner">
			<div class="detail-about__copy">
				<span class="section-rule" aria-hidden="true"></span>
				<p class="section-eyebrow"><?php esc_html_e( 'Sobre el curso', 'almicahealing' ); ?></p>
				<div class="detail-about__text"><?php the_content(); ?></div>

				<?php if ( $almicahealing_outcomes ) : ?>
					<div class="outcomes__box">
						<p class="section-eyebrow"><?php echo esc_html( $almicahealing_headings[ $almicahealing_heading_key ] ?? $almicahealing_heading_key ); ?></p>

						<?php // Numbers come from the list itself — the design has a duplicated "4" that shouldn't be reproduced. ?>
						<ol class="outcomes__list">
							<?php foreach ( $almicahealing_outcomes as $almicahealing_outcome ) : ?>
								<?php if ( empty( $almicahealing_outcome['text'] ) ) : ?>
									<?php continue; ?>
								<?php endif; ?>
								<li class="outcomes__item"><?php echo esc_html( $almicahealing_outcome['text'] ); ?></li>
							<?php endforeach; ?>
						</ol>
					</div>
				<?php endif; ?>
			</div>

			<aside class="course-aside">
				<?php if ( '' !== $almicahealing_price ) : ?>
					<div class="course-aside__card course-aside__card--investment">
						<p class="course-aside__eyebrow"><?php esc_html_e( 'Inversión', 'almicahealing' ); ?></p>
						<p class="course-aside__price"><?php echo esc_html( almicahealing_price( $almicahealing_price, 0 ) ); ?></p>
						<?php if ( $almicahealing_duration ) : ?>
							<p class="course-aside__duration"><?php echo esc_html( $almicahealing_duration ); ?></p>
						<?php endif; ?>
					</div>
				<?php endif; ?>

				<?php foreach ( $almicahealing_facilitators as $almicahealing_facilitator ) : ?>
					<div class="course-aside__card">
						<p class="course-aside__eyebrow"><?php esc_html_e( 'Facilitador/a', 'almicahealing' ); ?></p>
						<?php
						get_template_part(
							'template-parts/parts/profesional',
							null,
							array(
								'post_id' => $almicahealing_facilitator,
								'compact' => true,
							)
						);
						?>
					</div>
				<?php endforeach; ?>

				<div class="course-aside__card course-aside__card--inquiry">
					<p class="course-aside__eyebrow"><?php echo esc_html( almicahealing_setting( 'course_inquiry_title' ) ); ?></p>
					<p class="course-aside__body"><?php echo esc_html( almicahealing_setting( 'course_inquiry_body' ) ); ?></p>

					<?php if ( '' === $almicahealing_price ) : ?>
						<p class="course-aside__on-request"><?php echo esc_html( almicahealing_setting( 'price_on_request_text' ) ); ?></p>
					<?php endif; ?>

					<?php if ( $almicahealing_email ) : ?>
						<a class="course-aside__email" href="mailto:<?php echo esc_attr( $almicahealing_email ); ?>"><?php echo esc_html( $almicahealing_email ); ?></a>
					<?php endif; ?>
				</div>
			</aside>
		</div>
	</section>

	<?php if ( $almicahealing_others ) : ?>
		<section class="related related--dark">
			<div class="related__inner">
				<p class="section-eyebrow"><?php esc_html_e( 'Otros programas', 'almicahealing' ); ?></p>

				<div class="courses__grid courses__grid--related">
					<?php foreach ( $almicahealing_others as $almicahealing_other ) : ?>
						<?php
						get_template_part(
							'template-parts/cards/curso',
							null,
							array(
								'post_id' => $almicahealing_other,
								'compact' => true,
							)
						);
						?>
					<?php endforeach; ?>
				</div>
			</div>
		</section>
	<?php endif; ?>

	<?php
endwhile;

get_footer();

<?php
/**
 * Service detail — the template all 11 services render through.
 * Reference instance: Arteterapia (Figma frame 10, node 146-893).
 *
 * Section order: hero, "Sobre este servicio" + Inversión card,
 * Beneficios, Quién imparte, Otros servicios.
 *
 * Every variation across frames 10–20 is data, not markup: 1–5 benefit
 * tiles, benefits with or without a description, two-line titles, and a
 * missing therapist (which hides "Quién imparte" entirely, decision D4).
 *
 * @package AlmicaHealing
 */

defined( 'ABSPATH' ) || exit;

get_header();

while ( have_posts() ) :
	the_post();

	$almicahealing_id            = get_the_ID();
	$almicahealing_tagline       = almicahealing_field( 'tagline', $almicahealing_id, get_the_excerpt() );
	$almicahealing_duration      = almicahealing_duration( almicahealing_field( 'duration_minutes', $almicahealing_id ) );
	$almicahealing_price         = almicahealing_field( 'price', $almicahealing_id );
	$almicahealing_price_basis   = almicahealing_field( 'price_basis', $almicahealing_id, almicahealing_setting( 'service_price_basis' ) );
	$almicahealing_modality      = almicahealing_field( 'modality', $almicahealing_id );
	$almicahealing_modalities    = function_exists( 'almicahealing_modality_choices' ) ? almicahealing_modality_choices() : array();
	$almicahealing_benefits      = almicahealing_rows( 'benefits', $almicahealing_id );
	$almicahealing_professionals = array_filter( array_map( 'intval', (array) almicahealing_field( 'professionals', $almicahealing_id, array() ) ) );
	$almicahealing_workbook      = almicahealing_field( 'includes_workbook', $almicahealing_id );
	$almicahealing_related       = almicahealing_related_services( $almicahealing_id );
	?>

	<?php
	get_template_part(
		'template-parts/parts/detail-hero',
		null,
		array(
			'back_url'   => almicahealing_page_url( 'servicios' ),
			'back_label' => __( 'Volver a servicios', 'almicahealing' ),
			'eyebrow'    => __( 'Servicios', 'almicahealing' ),
			'title'      => get_the_title(),
			'tagline'    => $almicahealing_tagline,
			'chips'      => array( $almicahealing_duration ),
			'image'      => almicahealing_hero_image_url( $almicahealing_id ),
			'modifier'   => 'detail-hero--service',
		)
	);
	?>

	<section class="detail-about">
		<div class="detail-about__inner">
			<div class="detail-about__copy">
				<span class="section-rule" aria-hidden="true"></span>
				<p class="section-eyebrow"><?php esc_html_e( 'Sobre este servicio', 'almicahealing' ); ?></p>
				<div class="detail-about__text"><?php the_content(); ?></div>

				<?php if ( $almicahealing_workbook ) : ?>
					<p class="detail-about__workbook"><?php esc_html_e( 'Incluye cuadernillo descargable.', 'almicahealing' ); ?></p>
				<?php endif; ?>
			</div>

			<?php if ( '' !== $almicahealing_price ) : ?>
				<aside class="investment-card">
					<p class="investment-card__eyebrow"><?php esc_html_e( 'Inversión', 'almicahealing' ); ?></p>
					<p class="investment-card__price"><?php echo esc_html( almicahealing_price( $almicahealing_price ) ); ?></p>

					<?php if ( $almicahealing_price_basis ) : ?>
						<p class="investment-card__basis"><?php echo esc_html( $almicahealing_price_basis ); ?></p>
					<?php endif; ?>

					<dl class="investment-card__meta">
						<?php if ( $almicahealing_duration ) : ?>
							<div class="investment-card__row">
								<dt><?php esc_html_e( 'Duración', 'almicahealing' ); ?></dt>
								<dd><?php echo esc_html( $almicahealing_duration ); ?></dd>
							</div>
						<?php endif; ?>

						<?php if ( isset( $almicahealing_modalities[ $almicahealing_modality ] ) ) : ?>
							<div class="investment-card__row">
								<dt><?php esc_html_e( 'Modalidad', 'almicahealing' ); ?></dt>
								<dd><?php echo esc_html( $almicahealing_modalities[ $almicahealing_modality ] ); ?></dd>
							</div>
						<?php endif; ?>
					</dl>
				</aside>
			<?php endif; ?>
		</div>
	</section>

	<?php if ( $almicahealing_benefits ) : ?>
		<section class="benefits">
			<div class="benefits__inner">
				<p class="section-eyebrow"><?php esc_html_e( 'Beneficios', 'almicahealing' ); ?></p>
				<h2 class="benefits__title"><?php esc_html_e( 'Lo que esta sesión puede ofrecerte', 'almicahealing' ); ?></h2>

				<?php
				get_template_part(
					'template-parts/parts/benefit-grid',
					null,
					array( 'rows' => $almicahealing_benefits )
				);
				?>
			</div>
		</section>
	<?php endif; ?>

	<?php if ( $almicahealing_professionals ) : ?>
		<section class="who-teaches">
			<div class="who-teaches__inner">
				<p class="section-eyebrow"><?php esc_html_e( 'Quién imparte', 'almicahealing' ); ?></p>

				<?php foreach ( $almicahealing_professionals as $almicahealing_pro ) : ?>
					<?php
					get_template_part(
						'template-parts/parts/profesional',
						null,
						array( 'post_id' => $almicahealing_pro )
					);
					?>
				<?php endforeach; ?>
			</div>
		</section>
	<?php endif; ?>

	<?php if ( $almicahealing_related ) : ?>
		<section class="related">
			<div class="related__inner">
				<p class="section-eyebrow"><?php esc_html_e( 'Otros servicios', 'almicahealing' ); ?></p>

				<div class="services__grid">
					<?php foreach ( $almicahealing_related as $almicahealing_related_id ) : ?>
						<?php
						get_template_part(
							'template-parts/cards/servicio',
							null,
							array( 'post_id' => $almicahealing_related_id )
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

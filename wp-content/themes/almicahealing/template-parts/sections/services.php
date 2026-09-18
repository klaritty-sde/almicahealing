<?php
/**
 * Services teaser grid. Pulls from the `servicio` CPT registered in
 * almicahealing-core; falls back to nothing if that plugin isn't active.
 *
 * @package AlmicaHealing
 */

defined( 'ABSPATH' ) || exit;

if ( ! post_type_exists( 'servicio' ) ) {
	return;
}

$almicahealing_services = new WP_Query(
	array(
		'post_type'      => 'servicio',
		'posts_per_page' => -1,
		'orderby'        => 'menu_order',
		'order'          => 'ASC',
	)
);

if ( ! $almicahealing_services->have_posts() ) {
	return;
}
?>
<section class="services" id="servicios">
	<div class="services__inner">
		<h2 class="services__title"><?php esc_html_e( 'Servicios', 'almicahealing' ); ?></h2>

		<div class="services__grid">
			<?php
			while ( $almicahealing_services->have_posts() ) :
				$almicahealing_services->the_post();
				?>
				<article class="service-card">
					<?php if ( has_post_thumbnail() ) : ?>
						<div class="service-card__media">
							<?php the_post_thumbnail( 'almicahealing-card' ); ?>
						</div>
					<?php endif; ?>
					<h3 class="service-card__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
				</article>
			<?php endwhile; ?>
		</div>
	</div>
</section>
<?php
wp_reset_postdata();

<?php
/**
 * Full services catalog (Figma "Catalog" frame, node-id 146-687). Pulls
 * every published `servicio` post, ordered by menu_order.
 *
 * @package AlmicaHealing
 */

defined( 'ABSPATH' ) || exit;

if ( ! post_type_exists( 'servicio' ) ) {
	return;
}

$almicahealing_catalog = new WP_Query(
	array(
		'post_type'      => 'servicio',
		'posts_per_page' => -1,
		'orderby'        => 'menu_order',
		'order'          => 'ASC',
	)
);

if ( ! $almicahealing_catalog->have_posts() ) {
	return;
}
?>
<section class="services-catalog">
	<div class="services-catalog__inner">
		<div class="services__grid">
			<?php
			while ( $almicahealing_catalog->have_posts() ) :
				$almicahealing_catalog->the_post();
				?>
				<article class="service-card">
					<a class="service-card__link" href="<?php the_permalink(); ?>">
						<span class="service-card__media" aria-hidden="true">
							<?php if ( has_post_thumbnail() ) : ?>
								<?php the_post_thumbnail( 'almicahealing-card' ); ?>
							<?php endif; ?>
						</span>
						<span class="service-card__body">
							<span class="service-card__title"><?php the_title(); ?></span>
							<span class="button button--gold service-card__cta"><?php esc_html_e( 'Ver más', 'almicahealing' ); ?></span>
						</span>
					</a>
				</article>
			<?php endwhile; ?>
		</div>
	</div>
</section>
<?php
wp_reset_postdata();

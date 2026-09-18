<?php
/**
 * Services teaser grid (Figma "Services" frame, node-id 146-34). Pulls
 * from the `servicio` CPT registered in almicahealing-core; falls back to
 * nothing if that plugin isn't active or no services exist yet.
 *
 * Only services with the `_almicahealing_featured` custom field set to
 * `1` are shown here — the full catalog lives on the Servicios page
 * (see page-servicios.php). Toggle it from a servicio's Custom Fields
 * panel to control what appears in this teaser.
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
		'posts_per_page' => 6,
		'orderby'        => 'menu_order',
		'order'          => 'ASC',
		'meta_key'       => '_almicahealing_featured',
		'meta_value'     => '1',
	)
);

if ( ! $almicahealing_services->have_posts() ) {
	return;
}
?>
<section class="services" id="servicios">
	<div class="services__inner">
		<p class="section-eyebrow"><?php esc_html_e( 'Servicios', 'almicahealing' ); ?></p>
		<h2 class="services__title"><?php esc_html_e( 'Distintos caminos. Un mismo propósito: volver a ti.', 'almicahealing' ); ?></h2>
		<p class="section-subtitle"><?php esc_html_e( 'Explora distintas herramientas de acompañamiento y encuentra la que conecta con el momento que estás viviendo.', 'almicahealing' ); ?></p>

		<div class="services__grid">
			<?php
			while ( $almicahealing_services->have_posts() ) :
				$almicahealing_services->the_post();
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

		<?php $almicahealing_services_page = get_page_by_path( 'servicios' ); ?>
		<a class="button button--dark services__all" href="<?php echo esc_url( $almicahealing_services_page ? get_permalink( $almicahealing_services_page ) : home_url( '/servicios/' ) ); ?>"><?php esc_html_e( 'Ver todos los servicios', 'almicahealing' ); ?></a>
	</div>
</section>
<?php
wp_reset_postdata();

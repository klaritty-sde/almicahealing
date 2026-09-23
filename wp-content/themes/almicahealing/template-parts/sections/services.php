<?php
/**
 * Services teaser grid (Figma "Services" frame, node-id 146-34). Shows
 * the services flagged `is_featured`; the full catalog lives on the
 * Servicios page.
 *
 * Section copy comes from the `services_intro` group on the Home page,
 * falling back to the copy the design shipped with.
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
		'meta_key'       => 'is_featured',
		'meta_value'     => '1',
	)
);

if ( ! $almicahealing_services->have_posts() ) {
	return;
}

$almicahealing_intro = almicahealing_field( 'services_intro', get_the_ID(), array() );
$almicahealing_intro = is_array( $almicahealing_intro ) ? $almicahealing_intro : array();
?>
<section class="services" id="servicios">
	<div class="services__inner">
		<p class="section-eyebrow"><?php echo esc_html( $almicahealing_intro['eyebrow'] ?? __( 'Servicios', 'almicahealing' ) ); ?></p>
		<h2 class="services__title"><?php echo esc_html( $almicahealing_intro['title'] ?? __( 'Distintos caminos. Un mismo propósito: volver a ti.', 'almicahealing' ) ); ?></h2>
		<p class="section-subtitle"><?php echo esc_html( $almicahealing_intro['subtitle'] ?? __( 'Explora distintas herramientas de acompañamiento y encuentra la que conecta con el momento que estás viviendo.', 'almicahealing' ) ); ?></p>

		<div class="services__grid">
			<?php
			while ( $almicahealing_services->have_posts() ) :
				$almicahealing_services->the_post();

				get_template_part(
					'template-parts/cards/servicio',
					null,
					array( 'post_id' => get_the_ID() )
				);
			endwhile;
			wp_reset_postdata();
			?>
		</div>

		<a class="button button--dark services__all" href="<?php echo esc_url( almicahealing_page_url( 'servicios' ) ); ?>"><?php esc_html_e( 'Ver todos los servicios', 'almicahealing' ); ?></a>
	</div>
</section>

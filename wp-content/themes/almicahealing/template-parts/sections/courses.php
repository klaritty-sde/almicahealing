<?php
/**
 * "El conocimiento también transforma" — teaser grid for the three
 * courses (Clantarra, Riutunmi, Lo Que Nadie Nos Enseñó). Pulls from the
 * `curso` CPT registered in almicahealing-core once that plugin exists;
 * falls back to nothing if it isn't active yet.
 *
 * @package AlmicaHealing
 */

defined( 'ABSPATH' ) || exit;

if ( ! post_type_exists( 'curso' ) ) {
	return;
}

$almicahealing_courses = new WP_Query(
	array(
		'post_type'      => 'curso',
		'posts_per_page' => 3,
		'orderby'        => 'menu_order',
		'order'          => 'ASC',
	)
);

if ( ! $almicahealing_courses->have_posts() ) {
	return;
}
?>
<section class="courses" id="cursos">
	<div class="courses__inner">
		<h2 class="courses__title"><?php esc_html_e( 'El conocimiento también transforma.', 'almicahealing' ); ?></h2>
		<p class="courses__intro"><?php esc_html_e( 'Creemos que comprender es parte del proceso de sanar. Por eso compartimos reflexiones, recursos y contenido pensado para acompañar tu camino de autoconocimiento.', 'almicahealing' ); ?></p>

		<div class="courses__grid">
			<?php
			while ( $almicahealing_courses->have_posts() ) :
				$almicahealing_courses->the_post();
				?>
				<article class="course-card">
					<?php if ( has_post_thumbnail() ) : ?>
						<div class="course-card__media">
							<?php the_post_thumbnail( 'almicahealing-card' ); ?>
						</div>
					<?php endif; ?>
					<h3 class="course-card__title"><?php the_title(); ?></h3>
					<p class="course-card__excerpt"><?php the_excerpt(); ?></p>
					<a class="button button--gold" href="<?php the_permalink(); ?>"><?php esc_html_e( 'Ver más', 'almicahealing' ); ?></a>
				</article>
			<?php endwhile; ?>
		</div>
	</div>
</section>
<?php
wp_reset_postdata();

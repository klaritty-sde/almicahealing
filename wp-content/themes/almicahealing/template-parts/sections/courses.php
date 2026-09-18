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
		<div class="courses__header">
			<div>
				<p class="section-eyebrow"><?php esc_html_e( 'Aprende · Profundiza · Transforma', 'almicahealing' ); ?></p>
				<h2 class="courses__title"><?php esc_html_e( 'El conocimiento también transforma.', 'almicahealing' ); ?></h2>
			</div>
			<p class="courses__intro"><?php esc_html_e( 'Creemos que comprender es parte del proceso de sanar. Por eso compartimos reflexiones, recursos y contenido pensado para acompañar tu camino de autoconocimiento, más allá de cada sesión. Porque la claridad también se construye con lo que aprendemos en el camino.', 'almicahealing' ); ?></p>
		</div>

		<div class="courses__grid">
			<?php
			$almicahealing_course_index = 0;
			while ( $almicahealing_courses->have_posts() ) :
				$almicahealing_courses->the_post();
				++$almicahealing_course_index;
				?>
				<article class="course-card">
					<?php if ( has_post_thumbnail() ) : ?>
						<div class="course-card__media">
							<?php the_post_thumbnail( 'almicahealing-card' ); ?>
						</div>
					<?php endif; ?>
					<span class="course-card__number"><?php echo esc_html( sprintf( '%02d', $almicahealing_course_index ) ); ?></span>
					<h3 class="course-card__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
					<p class="course-card__excerpt"><?php the_excerpt(); ?></p>
				</article>
			<?php endwhile; ?>
		</div>
	</div>
</section>
<?php
wp_reset_postdata();

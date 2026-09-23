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

$almicahealing_intro = almicahealing_field( 'courses_intro', get_the_ID(), array() );
$almicahealing_intro = is_array( $almicahealing_intro ) ? $almicahealing_intro : array();
?>
<section class="courses" id="cursos">
	<div class="courses__inner">
		<div class="courses__header">
			<div>
				<p class="section-eyebrow"><?php echo esc_html( $almicahealing_intro['eyebrow'] ?? __( 'Aprende · Profundiza · Transforma', 'almicahealing' ) ); ?></p>
				<h2 class="courses__title"><?php echo esc_html( $almicahealing_intro['title'] ?? __( 'El conocimiento también transforma.', 'almicahealing' ) ); ?></h2>
			</div>
			<p class="courses__intro"><?php echo esc_html( $almicahealing_intro['body'] ?? __( 'Espacios de aprendizaje creados para profundizar en distintas herramientas de bienestar, consciencia y desarrollo personal.', 'almicahealing' ) ); ?></p>
		</div>

		<div class="courses__grid">
			<?php
			$almicahealing_course_index = 0;
			while ( $almicahealing_courses->have_posts() ) :
				$almicahealing_courses->the_post();
				++$almicahealing_course_index;

				get_template_part(
					'template-parts/cards/curso',
					null,
					array(
						'post_id' => get_the_ID(),
						'index'   => $almicahealing_course_index,
					)
				);
			endwhile;
			?>
		</div>
	</div>
</section>
<?php
wp_reset_postdata();

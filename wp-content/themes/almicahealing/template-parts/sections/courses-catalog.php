<?php
/**
 * Full course listing for the Cursos page — every published `curso` by
 * `menu_order`.
 *
 * @package AlmicaHealing
 */

defined( 'ABSPATH' ) || exit;

if ( ! post_type_exists( 'curso' ) ) {
	return;
}

$almicahealing_catalog = new WP_Query(
	array(
		'post_type'      => 'curso',
		'posts_per_page' => -1,
		'orderby'        => 'menu_order',
		'order'          => 'ASC',
	)
);

if ( ! $almicahealing_catalog->have_posts() ) {
	return;
}
?>
<section class="courses-catalog">
	<div class="courses-catalog__inner">
		<div class="courses__grid">
			<?php
			$almicahealing_index = 0;
			while ( $almicahealing_catalog->have_posts() ) :
				$almicahealing_catalog->the_post();
				++$almicahealing_index;

				get_template_part(
					'template-parts/cards/curso',
					null,
					array(
						'post_id' => get_the_ID(),
						'index'   => $almicahealing_index,
					)
				);
			endwhile;
			?>
		</div>
	</div>
</section>
<?php
wp_reset_postdata();

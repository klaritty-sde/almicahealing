<?php
/**
 * Single servicio/curso/post. `servicio` and `curso` share this template;
 * almicahealing-core registers both post types with `template` pointing here
 * implicitly via WordPress's single-{post_type}.php fallback to single.php.
 *
 * @package AlmicaHealing
 */

defined( 'ABSPATH' ) || exit;

get_header();

while ( have_posts() ) :
	the_post();
	?>
	<article <?php post_class( 'single-content' ); ?>>
		<?php if ( has_post_thumbnail() ) : ?>
			<div class="single-content__media">
				<?php the_post_thumbnail( 'almicahealing-hero' ); ?>
			</div>
		<?php endif; ?>
		<h1 class="single-content__title"><?php the_title(); ?></h1>
		<div class="single-content__body">
			<?php the_content(); ?>
		</div>
	</article>
	<?php
endwhile;

get_template_part( 'template-parts/sections/contact' );

get_footer();

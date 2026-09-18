<?php
/**
 * Generic page (Acerca de, etc.).
 *
 * @package AlmicaHealing
 */

defined( 'ABSPATH' ) || exit;

get_header();

while ( have_posts() ) :
	the_post();
	?>
	<article <?php post_class( 'page-content' ); ?>>
		<h1 class="page-content__title"><?php the_title(); ?></h1>
		<div class="page-content__body">
			<?php the_content(); ?>
		</div>
	</article>
	<?php
endwhile;

get_footer();

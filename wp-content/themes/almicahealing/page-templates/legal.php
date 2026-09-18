<?php
/**
 * Template Name: Legal
 *
 * For Términos y condiciones / Aviso de privacidad. Structure only —
 * legal copy must come from the client, not be ported from Klaritty.
 *
 * @package AlmicaHealing
 */

defined( 'ABSPATH' ) || exit;

get_header();

while ( have_posts() ) :
	the_post();
	?>
	<article <?php post_class( 'legal-content' ); ?>>
		<h1 class="legal-content__title"><?php the_title(); ?></h1>
		<div class="legal-content__body">
			<?php the_content(); ?>
		</div>
	</article>
	<?php
endwhile;

get_footer();

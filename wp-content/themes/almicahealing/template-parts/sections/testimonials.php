<?php
/**
 * "Experiencias que dejan huella" testimonial slider (Figma
 * "Testimonials" frame, node-id 146-279). Pulls from the `testimonio`
 * CPT registered in almicahealing-core; falls back to nothing if that
 * plugin isn't active or no testimonials exist yet.
 *
 * @package AlmicaHealing
 */

defined( 'ABSPATH' ) || exit;

if ( ! post_type_exists( 'testimonio' ) ) {
	return;
}

$almicahealing_testimonials = new WP_Query(
	array(
		'post_type'      => 'testimonio',
		'posts_per_page' => -1,
		'orderby'        => 'menu_order',
		'order'          => 'ASC',
	)
);

if ( ! $almicahealing_testimonials->have_posts() ) {
	return;
}
?>
<section class="testimonials" data-almicahealing-slider>
	<div class="testimonials__inner">
		<h2 class="testimonials__title"><?php esc_html_e( 'Experiencias que dejan huella.', 'almicahealing' ); ?></h2>

		<div class="testimonials__track">
			<?php
			$almicahealing_testimonial_index = 0;
			while ( $almicahealing_testimonials->have_posts() ) :
				$almicahealing_testimonials->the_post();
				?>
				<blockquote class="testimonial-slide" <?php echo 0 === $almicahealing_testimonial_index ? '' : 'hidden'; ?>>
					<p class="testimonial-slide__quote">&ldquo;<?php the_content(); ?>&rdquo;</p>
					<footer class="testimonial-slide__meta">
						<cite class="testimonial-slide__name"><?php the_title(); ?></cite>
						<?php if ( has_excerpt() ) : ?>
							<span class="testimonial-slide__label"><?php the_excerpt(); ?></span>
						<?php endif; ?>
					</footer>
				</blockquote>
				<?php
				++$almicahealing_testimonial_index;
			endwhile;
			?>
		</div>

		<?php if ( $almicahealing_testimonials->post_count > 1 ) : ?>
			<div class="testimonials__dots" role="tablist" aria-label="<?php esc_attr_e( 'Testimonios', 'almicahealing' ); ?>">
				<?php for ( $almicahealing_dot = 0; $almicahealing_dot < $almicahealing_testimonials->post_count; $almicahealing_dot++ ) : ?>
					<button type="button" class="testimonials__dot" data-index="<?php echo esc_attr( $almicahealing_dot ); ?>" aria-label="<?php echo esc_attr( sprintf( /* translators: %d: slide number. */ __( 'Testimonio %d', 'almicahealing' ), $almicahealing_dot + 1 ) ); ?>"></button>
				<?php endfor; ?>
			</div>
		<?php endif; ?>
	</div>
</section>
<?php
wp_reset_postdata();

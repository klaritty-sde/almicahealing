<?php
/**
 * "Experiencias que dejan huella" testimonial slider (Figma
 * "Testimonials" frame, node-id 146-279). Pulls from the `testimonio`
 * CPT registered in almicahealing-core; falls back to nothing if that
 * plugin isn't active or no testimonials exist yet.
 *
 * The label under each name is the title of the related servicio/curso
 * (`about`), not free text, so renaming a service updates it here.
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
		<h2 class="testimonials__title"><?php echo esc_html( almicahealing_field( 'testimonials_title', get_the_ID(), __( 'Experiencias que dejan huella.', 'almicahealing' ) ) ); ?></h2>

		<div class="testimonials__track">
			<?php
			$almicahealing_testimonial_index = 0;
			while ( $almicahealing_testimonials->have_posts() ) :
				$almicahealing_testimonials->the_post();
				?>
				<blockquote class="testimonial-slide" <?php echo 0 === $almicahealing_testimonial_index ? '' : 'hidden'; ?>>
					<span class="testimonial-slide__mark" aria-hidden="true">&ldquo;</span>
					<?php
					/*
					 * Not the_content(): it runs wpautop, which wraps the
					 * quote in its own <p>. Nested inside this <p> the
					 * browser closed the outer one early, stranding the
					 * quotation marks and dropping the class off the text
					 * altogether. A testimonial is a single plain sentence,
					 * so print it as text.
					 */
					?>
					<p class="testimonial-slide__quote"><?php echo esc_html( wp_strip_all_tags( get_the_content() ) ); ?></p>
					<footer class="testimonial-slide__meta">
						<cite class="testimonial-slide__name"><?php the_title(); ?></cite>
						<?php
						$almicahealing_about = almicahealing_field( 'about', get_the_ID() );
						$almicahealing_label = $almicahealing_about ? get_the_title( (int) $almicahealing_about ) : '';
						?>
						<?php if ( $almicahealing_label ) : ?>
							<span class="testimonial-slide__label"><?php echo esc_html( $almicahealing_label ); ?></span>
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

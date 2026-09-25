<?php
/**
 * Course card — Home teaser, the Cursos listing and "Otros programas".
 *
 * $args:
 * - post_id (int)    — course to render; defaults to the current post.
 * - index (int)      — 1-based position, shown as the "01" counter.
 * - compact (bool)   — the "Otros programas" variant (Figma node-id
 *                      177-848): just the photo at 4:3, with the level
 *                      and the title sitting ON it over a gradient
 *                      scrim. No summary, price or counter.
 *
 * @package AlmicaHealing
 */

defined( 'ABSPATH' ) || exit;

$almicahealing_course_id = isset( $args['post_id'] ) ? (int) $args['post_id'] : get_the_ID();

if ( ! $almicahealing_course_id ) {
	return;
}

$almicahealing_course_index   = isset( $args['index'] ) ? (int) $args['index'] : 0;
$almicahealing_course_compact = ! empty( $args['compact'] );
$almicahealing_course_price   = almicahealing_field( 'price', $almicahealing_course_id );
$almicahealing_course_url     = get_permalink( $almicahealing_course_id );

if ( $almicahealing_course_compact ) {
	$almicahealing_course_level  = almicahealing_field( 'level', $almicahealing_course_id );
	$almicahealing_course_levels = function_exists( 'almicahealing_level_choices' ) ? almicahealing_level_choices() : array();
	$almicahealing_course_label  = $almicahealing_course_levels[ $almicahealing_course_level ] ?? '';
	?>
	<article class="course-card course-card--compact">
		<a class="course-card__media" href="<?php echo esc_url( $almicahealing_course_url ); ?>">
			<?php if ( has_post_thumbnail( $almicahealing_course_id ) ) : ?>
				<?php echo get_the_post_thumbnail( $almicahealing_course_id, 'almicahealing-card' ); ?>
			<?php endif; ?>
			<span class="course-card__scrim" aria-hidden="true"></span>
			<span class="course-card__overlay">
				<?php if ( $almicahealing_course_label ) : ?>
					<span class="course-card__level"><?php echo esc_html( $almicahealing_course_label ); ?></span>
				<?php endif; ?>
				<span class="course-card__overlay-title"><?php echo esc_html( get_the_title( $almicahealing_course_id ) ); ?></span>
			</span>
		</a>
	</article>
	<?php
	return;
}
?>
<article class="course-card">
	<a class="course-card__media" href="<?php echo esc_url( $almicahealing_course_url ); ?>">
		<?php if ( has_post_thumbnail( $almicahealing_course_id ) ) : ?>
			<?php echo get_the_post_thumbnail( $almicahealing_course_id, 'almicahealing-card' ); ?>
		<?php endif; ?>
	</a>

	<?php if ( $almicahealing_course_index ) : ?>
		<span class="course-card__number"><?php echo esc_html( sprintf( '%02d', $almicahealing_course_index ) ); ?></span>
	<?php endif; ?>

	<h3 class="course-card__title">
		<a href="<?php echo esc_url( $almicahealing_course_url ); ?>"><?php echo esc_html( get_the_title( $almicahealing_course_id ) ); ?></a>
	</h3>

	<?php $almicahealing_course_summary = get_the_excerpt( $almicahealing_course_id ); ?>
	<?php if ( $almicahealing_course_summary ) : ?>
		<p class="course-card__excerpt"><?php echo esc_html( $almicahealing_course_summary ); ?></p>
	<?php endif; ?>

	<p class="course-card__price">
		<?php
		echo esc_html(
			'' !== $almicahealing_course_price
				? almicahealing_price( $almicahealing_course_price, 0 )
				: almicahealing_setting( 'price_on_request_text' )
		);
		?>
	</p>
</article>

<?php
/**
 * Course card — Home teaser, the Cursos listing and "Otros programas".
 *
 * $args:
 * - post_id (int)    — course to render; defaults to the current post.
 * - index (int)      — 1-based position, shown as the "01" counter.
 * - compact (bool)   — drops the summary, for "Otros programas".
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
?>
<article class="course-card<?php echo $almicahealing_course_compact ? ' course-card--compact' : ''; ?>">
	<a class="course-card__media" href="<?php echo esc_url( get_permalink( $almicahealing_course_id ) ); ?>">
		<?php if ( has_post_thumbnail( $almicahealing_course_id ) ) : ?>
			<?php echo get_the_post_thumbnail( $almicahealing_course_id, 'almicahealing-card' ); ?>
		<?php endif; ?>
	</a>

	<?php if ( $almicahealing_course_index ) : ?>
		<span class="course-card__number"><?php echo esc_html( sprintf( '%02d', $almicahealing_course_index ) ); ?></span>
	<?php endif; ?>

	<h3 class="course-card__title">
		<a href="<?php echo esc_url( get_permalink( $almicahealing_course_id ) ); ?>"><?php echo esc_html( get_the_title( $almicahealing_course_id ) ); ?></a>
	</h3>

	<?php if ( ! $almicahealing_course_compact ) : ?>
		<?php $almicahealing_course_summary = get_the_excerpt( $almicahealing_course_id ); ?>
		<?php if ( $almicahealing_course_summary ) : ?>
			<p class="course-card__excerpt"><?php echo esc_html( $almicahealing_course_summary ); ?></p>
		<?php endif; ?>
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

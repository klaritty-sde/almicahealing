<?php
/**
 * Professional block — "Quién imparte" on a service, "Facilitador/a" on
 * a course, and the founder on Acerca de. Circular portrait beside the
 * name, gold role line and bio.
 *
 * $args:
 * - post_id (int) — the `profesional` post.
 * - compact (bool) — smaller portrait, used in the course sidebar.
 *
 * @package AlmicaHealing
 */

defined( 'ABSPATH' ) || exit;

$almicahealing_pro_id = isset( $args['post_id'] ) ? (int) $args['post_id'] : 0;

if ( ! $almicahealing_pro_id || 'profesional' !== get_post_type( $almicahealing_pro_id ) ) {
	return;
}

$almicahealing_pro_compact = ! empty( $args['compact'] );
$almicahealing_pro_role    = almicahealing_field( 'role', $almicahealing_pro_id );
$almicahealing_pro_photo   = get_the_post_thumbnail_url( $almicahealing_pro_id, 'almicahealing-portrait' );
$almicahealing_pro_bio     = get_post_field( 'post_content', $almicahealing_pro_id );
?>
<div class="profesional<?php echo $almicahealing_pro_compact ? ' profesional--compact' : ''; ?>">
	<?php if ( $almicahealing_pro_photo ) : ?>
		<div class="profesional__photo" style="background-image: url(<?php echo esc_url( $almicahealing_pro_photo ); ?>);" role="img" aria-label="<?php echo esc_attr( get_the_title( $almicahealing_pro_id ) ); ?>"></div>
	<?php else : ?>
		<div class="profesional__photo profesional__photo--empty" aria-hidden="true"></div>
	<?php endif; ?>

	<div class="profesional__body">
		<h3 class="profesional__name"><?php echo esc_html( get_the_title( $almicahealing_pro_id ) ); ?></h3>

		<?php if ( $almicahealing_pro_role ) : ?>
			<p class="profesional__role"><?php echo esc_html( $almicahealing_pro_role ); ?></p>
		<?php endif; ?>

		<?php if ( ! $almicahealing_pro_compact && $almicahealing_pro_bio ) : ?>
			<div class="profesional__bio"><?php echo wp_kses_post( wpautop( $almicahealing_pro_bio ) ); ?></div>
		<?php endif; ?>
	</div>
</div>

<?php
/**
 * Service card — used by the Home teaser, the Servicios catalog and
 * "Otros servicios". Expects the loop to be set to a `servicio` post,
 * or $args['post_id'].
 *
 * @package AlmicaHealing
 */

defined( 'ABSPATH' ) || exit;

$almicahealing_card_id = isset( $args['post_id'] ) ? (int) $args['post_id'] : get_the_ID();

if ( ! $almicahealing_card_id ) {
	return;
}
?>
<article class="service-card">
	<a class="service-card__link" href="<?php echo esc_url( get_permalink( $almicahealing_card_id ) ); ?>">
		<span class="service-card__media" aria-hidden="true">
			<?php if ( has_post_thumbnail( $almicahealing_card_id ) ) : ?>
				<?php echo get_the_post_thumbnail( $almicahealing_card_id, 'almicahealing-card' ); ?>
			<?php endif; ?>
		</span>
		<span class="service-card__body">
			<span class="service-card__title"><?php echo esc_html( get_the_title( $almicahealing_card_id ) ); ?></span>
			<span class="button button--gold service-card__cta"><?php esc_html_e( 'Ver más', 'almicahealing' ); ?></span>
		</span>
	</a>
</article>

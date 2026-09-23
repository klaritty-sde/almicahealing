<?php
/**
 * "Formación" credentials list (Figma "Formacion" frame).
 *
 * Read from the founder's `credentials` repeater rather than a hard-
 * coded array, so her training history is edited in one place.
 *
 * @package AlmicaHealing
 */

defined( 'ABSPATH' ) || exit;

$almicahealing_founder = (int) almicahealing_field( 'founder', get_the_ID() );

if ( ! $almicahealing_founder ) {
	return;
}

$almicahealing_credentials = almicahealing_rows( 'credentials', $almicahealing_founder );

if ( ! $almicahealing_credentials ) {
	return;
}
?>
<section class="formacion">
	<div class="formacion__inner">
		<h2 class="formacion__title"><?php esc_html_e( 'Formación', 'almicahealing' ); ?></h2>

		<div class="formacion__list">
			<?php foreach ( $almicahealing_credentials as $almicahealing_credential ) : ?>
				<div class="formacion-item">
					<div class="formacion-item__head">
						<h3 class="formacion-item__title"><?php echo esc_html( $almicahealing_credential['title'] ?? '' ); ?></h3>
						<?php if ( ! empty( $almicahealing_credential['year'] ) ) : ?>
							<span class="formacion-item__year"><?php echo esc_html( $almicahealing_credential['year'] ); ?></span>
						<?php endif; ?>
					</div>
					<?php if ( ! empty( $almicahealing_credential['institution'] ) ) : ?>
						<p class="formacion-item__institution"><?php echo esc_html( $almicahealing_credential['institution'] ); ?></p>
					<?php endif; ?>
					<?php if ( ! empty( $almicahealing_credential['description'] ) ) : ?>
						<p class="formacion-item__body"><?php echo esc_html( $almicahealing_credential['description'] ); ?></p>
					<?php endif; ?>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

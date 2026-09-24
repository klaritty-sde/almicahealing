<?php
/**
 * "Tu proceso comienza aquí" — 3-step process (Figma "HowItWorks" frame,
 * node-id 146-142). Step copy comes from the `process_steps` repeater
 * on the front page; the icons and numbering stay with the theme.
 *
 * @package AlmicaHealing
 */

defined( 'ABSPATH' ) || exit;

$almicahealing_icons = array( 'proceso-elige.svg', 'proceso-reserva.svg', 'proceso-conecta.svg' );

$almicahealing_steps = array(
	array(
		'title' => __( 'Elige lo que necesitas trabajar', 'almicahealing' ),
		'body'  => __( 'Explora nuestros servicios y encuentra el acompañamiento que mejor responde a tu momento.', 'almicahealing' ),
	),
	array(
		'title' => __( 'Reserva tu sesión', 'almicahealing' ),
		'body'  => __( 'Selecciona disponibilidad y completa tu reserva de forma sencilla.', 'almicahealing' ),
	),
	array(
		'title' => __( 'Conecta con tu experiencia', 'almicahealing' ),
		'body'  => __( 'Un terapeuta especializado en ese servicio te acompañará durante tu sesión.', 'almicahealing' ),
	),
);

$almicahealing_rows = almicahealing_rows( 'process_steps', get_the_ID() );

if ( $almicahealing_rows ) {
	$almicahealing_steps = $almicahealing_rows;
}
?>
<section class="how-it-works">
	<div class="how-it-works__inner">
		<p class="section-eyebrow"><?php esc_html_e( 'Procesos', 'almicahealing' ); ?></p>
		<h2 class="how-it-works__title"><?php esc_html_e( 'Tu proceso comienza aquí', 'almicahealing' ); ?></h2>

		<div class="how-it-works__grid">
			<?php foreach ( $almicahealing_steps as $almicahealing_index => $almicahealing_step ) : ?>
				<div class="step-card">
					<span class="step-card__number"><?php echo esc_html( sprintf( '%02d', $almicahealing_index + 1 ) ); ?></span>
					<img class="step-card__icon" src="<?php echo esc_url( get_theme_file_uri( 'assets/img/icons/' . ( $almicahealing_icons[ $almicahealing_index ] ?? $almicahealing_icons[0] ) ) ); ?>" alt="" width="40" height="40">
					<h3 class="step-card__title"><?php echo esc_html( $almicahealing_step['title'] ?? '' ); ?></h3>
					<p class="step-card__body"><?php echo esc_html( $almicahealing_step['body'] ?? '' ); ?></p>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

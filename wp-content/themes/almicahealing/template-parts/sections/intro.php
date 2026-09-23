<?php
/**
 * "Todo comienza cuando volvemos a conectar" intro (Figma "Intro" frame,
 * node-id 146-32). Copy comes from the `intro` group on the front page.
 *
 * @package AlmicaHealing
 */

defined( 'ABSPATH' ) || exit;

$almicahealing_intro = almicahealing_field( 'intro', get_the_ID(), array() );
$almicahealing_intro = is_array( $almicahealing_intro ) ? $almicahealing_intro : array();

$almicahealing_body = $almicahealing_intro['body'] ?? '';

if ( ! $almicahealing_body ) {
	$almicahealing_body = sprintf(
		'<p>%1$s</p><p>%2$s</p>',
		esc_html__( 'Álmica Healing es un espacio de bienestar integral que reúne distintas herramientas y terapias para acompañar procesos de conexión, claridad y transformación.', 'almicahealing' ),
		sprintf(
			/* translators: %s: emphasized phrase. */
			esc_html__( 'La experiencia no debe girar alrededor de elegir a una persona específica, sino de encontrar %s.', 'almicahealing' ),
			'<em>' . esc_html__( 'el servicio adecuado para lo que cada persona necesita trabajar', 'almicahealing' ) . '</em>'
		)
	);
}

$almicahealing_image_id = $almicahealing_intro['image'] ?? 0;
$almicahealing_image    = $almicahealing_image_id
	? wp_get_attachment_image_url( (int) $almicahealing_image_id, 'almicahealing-hero' )
	: get_theme_file_uri( 'assets/img/home-intro.jpg' );

$almicahealing_cta_label = $almicahealing_intro['cta_label'] ?? __( 'Conoce Álmica', 'almicahealing' );
$almicahealing_cta_url   = $almicahealing_intro['cta_url'] ?? home_url( '/acerca-de/' );
?>
<section class="intro">
	<div class="intro__inner">
		<div class="intro__copy">
			<span class="intro__rule" aria-hidden="true"></span>
			<h2 class="intro__title"><?php echo esc_html( $almicahealing_intro['title'] ?? __( 'Todo comienza cuando volvemos a conectar.', 'almicahealing' ) ); ?></h2>
			<?php echo wp_kses_post( $almicahealing_body ); ?>

			<?php if ( $almicahealing_cta_label ) : ?>
				<a class="button button--outline" href="<?php echo esc_url( $almicahealing_cta_url ); ?>"><?php echo esc_html( $almicahealing_cta_label ); ?></a>
			<?php endif; ?>
		</div>
		<div
			class="intro__media"
			aria-hidden="true"
			style="background-image: url(<?php echo esc_url( $almicahealing_image ); ?>);"
		></div>
	</div>
</section>

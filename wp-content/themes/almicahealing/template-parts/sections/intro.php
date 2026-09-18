<?php
/**
 * "Todo comienza cuando volvemos a conectar" intro (Figma "Intro" frame,
 * node-id 146-32).
 *
 * @package AlmicaHealing
 */

defined( 'ABSPATH' ) || exit;
?>
<section class="intro">
	<div class="intro__inner">
		<div class="intro__copy">
			<h2 class="intro__title"><?php esc_html_e( 'Todo comienza cuando volvemos a conectar.', 'almicahealing' ); ?></h2>
			<p><?php esc_html_e( 'Álmica Healing es un espacio de bienestar integral que reúne distintas herramientas y terapias para acompañar procesos de conexión, claridad y transformación.', 'almicahealing' ); ?></p>
			<p>
				<?php
				printf(
					/* translators: %s: emphasized phrase. */
					esc_html__( 'La experiencia no debe girar alrededor de elegir a una persona específica, sino de encontrar %s.', 'almicahealing' ),
					'<em>' . esc_html__( 'el servicio adecuado para lo que cada persona necesita trabajar', 'almicahealing' ) . '</em>'
				);
				?>
			</p>
			<a class="button button--outline" href="<?php echo esc_url( home_url( '/acerca-de/' ) ); ?>"><?php esc_html_e( 'Conoce Álmica', 'almicahealing' ); ?></a>
		</div>
		<div
			class="intro__media"
			aria-hidden="true"
			style="background-image: url(<?php echo esc_url( get_theme_file_uri( 'assets/img/home-intro.jpg' ) ); ?>);"
		></div>
	</div>
</section>

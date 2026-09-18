<?php
/**
 * Home hero (Figma "Hero" frame, node-id 146-377).
 *
 * @package AlmicaHealing
 */

defined( 'ABSPATH' ) || exit;
?>
<section class="hero">
	<div
		class="hero__media"
		aria-hidden="true"
		style="background-image: linear-gradient(to bottom right, rgba(38,59,51,.88), rgba(38,59,51,.7)), url(<?php echo esc_url( get_theme_file_uri( 'assets/img/home-hero.jpg' ) ); ?>);"
	></div>
	<div class="hero__inner">
		<p class="hero__eyebrow"><?php esc_html_e( 'Álmica Healing', 'almicahealing' ); ?></p>
		<h1 class="hero__title"><?php esc_html_e( 'Ecosistema que conecta tu bienestar', 'almicahealing' ); ?></h1>
		<p class="hero__subtitle"><?php esc_html_e( 'Un espacio donde la energía, la mente y los vínculos familiares se abordan como un mismo proceso guiado por profesionales, pensado para un cambio que realmente perdura.', 'almicahealing' ); ?></p>
		<a class="button button--gold" href="#servicios"><?php esc_html_e( 'Conoce Álmica Healing', 'almicahealing' ); ?></a>
	</div>
</section>

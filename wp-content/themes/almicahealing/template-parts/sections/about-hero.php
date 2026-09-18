<?php
/**
 * "Acerca de Álmica" hero (Figma "Hero" frame, node-id 146-436).
 *
 * @package AlmicaHealing
 */

defined( 'ABSPATH' ) || exit;
?>
<section class="hero hero--short">
	<div
		class="hero__media"
		aria-hidden="true"
		style="background-image: linear-gradient(to bottom right, rgba(38,59,51,.85), rgba(38,59,51,.65)), url(<?php echo esc_url( get_theme_file_uri( 'assets/img/acerca-de-hero.jpg' ) ); ?>);"
	></div>
	<div class="hero__inner hero__inner--center">
		<p class="hero__eyebrow"><?php esc_html_e( 'Álmica Healing', 'almicahealing' ); ?></p>
		<h1 class="hero__title"><?php esc_html_e( 'Acerca de Álmica', 'almicahealing' ); ?></h1>
		<p class="hero__subtitle"><?php esc_html_e( 'Somos un espacio que te brinda Terapias de sanación en donde unes pasado y presente para un futuro equilibrado.', 'almicahealing' ); ?></p>
	</div>
</section>

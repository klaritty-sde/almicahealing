<?php
/**
 * Founder profile — Alma Solís (Figma "Fundadora" frame, node-id
 * 146-513).
 *
 * @package AlmicaHealing
 */

defined( 'ABSPATH' ) || exit;
?>
<section class="fundadora">
	<div class="fundadora__inner">
		<div
			class="fundadora__photo"
			aria-hidden="true"
			style="background-image: url(<?php echo esc_url( get_theme_file_uri( 'assets/img/acerca-de-fundadora.jpg' ) ); ?>);"
		></div>
		<div class="fundadora__bio">
			<h3 class="fundadora__name"><?php esc_html_e( 'Alma Solís', 'almicahealing' ); ?></h3>
			<p class="fundadora__role"><?php esc_html_e( 'Fundadora y Directora', 'almicahealing' ); ?></p>

			<p><?php esc_html_e( 'Alma Solís es una profesional comprometida con el desarrollo humano y el bienestar integral de las personas. Inició su formación académica en Ciencias de la Comunicación, disciplina que le permitió desarrollar una comprensión profunda de los procesos de interacción y expresión humana. En paralelo, comenzó su preparación como Consteladora Familiar, lo que despertó en ella un interés creciente por el acompañamiento terapéutico y el crecimiento personal.', 'almicahealing' ); ?></p>
			<p><?php esc_html_e( 'Impulsada por su vocación de servicio, cursó la Licenciatura en Psicología y continuó su especialización con una Maestría en Psicología Clínica y de la Salud. Su formación se ha enriquecido además con estudios complementarios en Bioneuroemoción con Enric Corbera, Canalización y Defensa Psíquica con Sol Ahimsa, y el programa Sana Tu Alma impartido por Abril Méndez.', 'almicahealing' ); ?></p>
			<p><?php esc_html_e( 'A lo largo de varios años de consulta privada, Alma ha acompañado a personas en procesos de transformación personal, autoconocimiento y fortalecimiento emocional, integrando herramientas psicológicas y sistémicas. Su trabajo se distingue por una visión humana, ética e integral, orientada a generar espacios seguros que favorezcan el desarrollo de recursos internos y la construcción de una vida con mayor equilibrio y plenitud.', 'almicahealing' ); ?></p>
		</div>
	</div>
</section>

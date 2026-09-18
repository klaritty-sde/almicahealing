<?php
/**
 * "Formación" credentials list (Figma "Formacion" frame, node-id
 * 146-…). Static content — the founder's training history, not a CPT.
 *
 * @package AlmicaHealing
 */

defined( 'ABSPATH' ) || exit;

$almicahealing_credentials = array(
	array(
		'title'       => __( 'Especialidad en Constelaciones Familiares', 'almicahealing' ),
		'year'        => '2021',
		'institution' => __( 'Instituto de Constelaciones Familiares de Monterrey', 'almicahealing' ),
		'body'        => __( 'Con un enfoque en dinámicas familiares, esta especialidad ayuda a identificar en el presente, tanto en sesiones grupales como individuales y de pareja, los patrones disfuncionales y guiar hacia soluciones mediante el acceso al inconsciente para sanar y liberar emociones bloqueadas.', 'almicahealing' ),
	),
	array(
		'title'       => __( 'Canalización con Guías y seres Espirituales', 'almicahealing' ),
		'year'        => '2024',
		'institution' => __( 'Escuela Sol Ahimsa', 'almicahealing' ),
		'body'        => __( 'Como canalizadora espiritual identificas mensajes auténticos para expandir la conciencia hacia dimensiones superiores que disminuyen el ruido mental y conectan con la luz interior para ayudar a otros. Así como mantener el estado de trance, bloqueando los propios pensamientos y solicitar la conexión con el guía.', 'almicahealing' ),
	),
	array(
		'title'       => __( 'Limpieza Energética y Autodefensa Psíquica', 'almicahealing' ),
		'year'        => '2024',
		'institution' => __( 'Paduka con la Astrología Paola Michel (2024)', 'almicahealing' ),
		'body'        => __( 'Esta formación permite fortalecer el sistema energético y conectar con la luz interior. Explora técnicas de visualización guiada y generación de energía renovada para equilibrar el campo áurico, junto con técnicas de limpieza energética y autodefensa psíquica.', 'almicahealing' ),
	),
);
?>
<section class="formacion">
	<div class="formacion__inner">
		<h2 class="formacion__title"><?php esc_html_e( 'Formación', 'almicahealing' ); ?></h2>

		<div class="formacion__list">
			<?php foreach ( $almicahealing_credentials as $almicahealing_credential ) : ?>
				<div class="formacion-item">
					<div class="formacion-item__head">
						<h3 class="formacion-item__title"><?php echo esc_html( $almicahealing_credential['title'] ); ?></h3>
						<span class="formacion-item__year"><?php echo esc_html( $almicahealing_credential['year'] ); ?></span>
					</div>
					<p class="formacion-item__institution"><?php echo esc_html( $almicahealing_credential['institution'] ); ?></p>
					<p class="formacion-item__body"><?php echo esc_html( $almicahealing_credential['body'] ); ?></p>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

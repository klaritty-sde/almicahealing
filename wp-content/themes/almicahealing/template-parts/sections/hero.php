<?php
/**
 * Home hero (Figma "Hero" frame, node-id 146-377).
 *
 * Copy and image come from the shared `group_page_hero` fields on the
 * front page, falling back to the copy the design shipped with.
 *
 * @package AlmicaHealing
 */

defined( 'ABSPATH' ) || exit;

$almicahealing_image_id = almicahealing_field( 'hero_image' );
$almicahealing_image    = $almicahealing_image_id
	? wp_get_attachment_image_url( (int) $almicahealing_image_id, 'almicahealing-hero' )
	: get_theme_file_uri( 'assets/img/home-hero.jpg' );

$almicahealing_cta_label = almicahealing_hero_field( 'hero_cta_label', __( 'Conoce Álmica Healing', 'almicahealing' ) );
$almicahealing_cta_url   = almicahealing_hero_field( 'hero_cta_url', '#servicios' );
?>
<section class="hero">
	<div
		class="hero__media"
		aria-hidden="true"
		style="background-image: linear-gradient(to bottom right, rgba(38,59,51,.88), rgba(38,59,51,.7)), url(<?php echo esc_url( $almicahealing_image ); ?>);"
	></div>
	<div class="hero__inner hero__inner--half">
		<div class="hero__content">
			<p class="hero__eyebrow"><?php echo esc_html( almicahealing_hero_field( 'hero_eyebrow', __( 'Álmica Healing', 'almicahealing' ) ) ); ?></p>
			<h1 class="hero__title"><?php echo esc_html( almicahealing_hero_field( 'hero_title', __( 'Ecosistema que conecta tu bienestar', 'almicahealing' ) ) ); ?></h1>
			<p class="hero__subtitle"><?php echo esc_html( almicahealing_hero_field( 'hero_subtitle', __( 'Un espacio donde la energía, la mente y los vínculos familiares se abordan como un mismo proceso guiado por profesionales, pensado para un cambio que realmente perdura.', 'almicahealing' ) ) ); ?></p>

			<?php if ( $almicahealing_cta_label ) : ?>
				<a class="button button--gold" href="<?php echo esc_url( $almicahealing_cta_url ); ?>"><?php echo esc_html( $almicahealing_cta_label ); ?></a>
			<?php endif; ?>
		</div>
	</div>
</section>

<?php
/**
 * Template Name: Legal
 *
 * Shared by Aviso de privacidad and Términos y condiciones (Figma
 * frames 8–9): one hero, a tab bar linking the two documents with the
 * current one marked active, and the document itself.
 *
 * The body is plain `post_content` — an H2 per section, numbered by
 * CSS. A repeater would add nothing for long legal prose and would make
 * text from a lawyer harder to paste in.
 *
 * @package AlmicaHealing
 */

defined( 'ABSPATH' ) || exit;

get_header();

$almicahealing_legal_pages = array(
	'aviso-de-privacidad'    => __( 'Aviso de Privacidad', 'almicahealing' ),
	'terminos-y-condiciones' => __( 'Términos y Condiciones', 'almicahealing' ),
);

while ( have_posts() ) :
	the_post();

	$almicahealing_current = get_post_field( 'post_name', get_the_ID() );
	$almicahealing_note    = almicahealing_setting( 'legal_contact_note' );
	$almicahealing_email   = almicahealing_setting( 'contact_email' );
	?>

	<section class="legal-hero">
		<div class="legal-hero__inner">
			<h1 class="legal-hero__title"><?php esc_html_e( 'Información legal y de privacidad.', 'almicahealing' ); ?></h1>

			<nav class="legal-tabs" aria-label="<?php esc_attr_e( 'Documentos legales', 'almicahealing' ); ?>">
				<?php foreach ( $almicahealing_legal_pages as $almicahealing_slug => $almicahealing_label ) : ?>
					<?php
					$almicahealing_page = get_page_by_path( $almicahealing_slug );

					if ( ! $almicahealing_page ) {
						continue;
					}

					$almicahealing_is_current = ( $almicahealing_slug === $almicahealing_current );
					?>
					<a
						class="legal-tabs__tab<?php echo $almicahealing_is_current ? ' is-active' : ''; ?>"
						href="<?php echo esc_url( get_permalink( $almicahealing_page ) ); ?>"
						<?php echo $almicahealing_is_current ? 'aria-current="page"' : ''; ?>
					><?php echo esc_html( $almicahealing_label ); ?></a>
				<?php endforeach; ?>
			</nav>
		</div>
	</section>

	<article <?php post_class( 'legal-content' ); ?>>
		<div class="legal-content__inner">
			<div class="legal-content__body"><?php the_content(); ?></div>

			<?php if ( $almicahealing_note ) : ?>
				<aside class="legal-note">
					<p>
						<?php echo esc_html( $almicahealing_note ); ?>
						<?php if ( $almicahealing_email ) : ?>
							<a href="mailto:<?php echo esc_attr( $almicahealing_email ); ?>"><?php echo esc_html( $almicahealing_email ); ?></a>
						<?php endif; ?>
					</p>
				</aside>
			<?php endif; ?>
		</div>
	</article>

	<?php
endwhile;

get_footer();

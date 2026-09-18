<?php
/**
 * Footer: brand block, nav columns, contact/social — mirrors the Figma
 * footer (Navegación / Legal / Contacto).
 *
 * @package AlmicaHealing
 */

defined( 'ABSPATH' ) || exit;
?>
<footer class="site-footer">
	<div class="site-footer__inner">
		<div class="site-footer__brand">
			<p class="site-footer__logo"><?php bloginfo( 'name' ); ?></p>
			<p><?php esc_html_e( 'Bienestar integral para un proceso de conexión, claridad y transformación.', 'almicahealing' ); ?></p>
		</div>

		<nav class="site-footer__col" aria-label="<?php esc_attr_e( 'Navegación', 'almicahealing' ); ?>">
			<h2><?php esc_html_e( 'Navegación', 'almicahealing' ); ?></h2>
			<?php
			if ( has_nav_menu( 'footer' ) ) {
				wp_nav_menu(
					array(
						'theme_location' => 'footer',
						'container'      => false,
						'menu_class'     => 'site-footer__list',
						'depth'          => 1,
					)
				);
			}
			?>
		</nav>

		<div class="site-footer__col">
			<h2><?php esc_html_e( 'Legal', 'almicahealing' ); ?></h2>
			<ul class="site-footer__list">
				<?php
				$almicahealing_terms   = get_page_by_path( 'terminos-y-condiciones' );
				$almicahealing_privacy = get_privacy_policy_url();
				?>
				<?php if ( $almicahealing_terms ) : ?>
					<li><a href="<?php echo esc_url( get_permalink( $almicahealing_terms ) ); ?>"><?php esc_html_e( 'Términos y condiciones', 'almicahealing' ); ?></a></li>
				<?php endif; ?>
				<?php if ( $almicahealing_privacy ) : ?>
					<li><a href="<?php echo esc_url( $almicahealing_privacy ); ?>"><?php esc_html_e( 'Aviso de privacidad', 'almicahealing' ); ?></a></li>
				<?php endif; ?>
			</ul>
		</div>

		<div class="site-footer__col">
			<h2><?php esc_html_e( 'Contacto', 'almicahealing' ); ?></h2>
			<ul class="site-footer__list">
				<li><a href="mailto:<?php echo esc_attr( almicahealing_brand( 'email' ) ); ?>"><?php echo esc_html( almicahealing_brand( 'email' ) ); ?></a></li>
				<li><?php echo esc_html( almicahealing_brand( 'phone' ) ); ?></li>
				<li><?php echo esc_html( almicahealing_brand( 'location' ) ); ?></li>
			</ul>

			<?php
			$almicahealing_social = array_filter( almicahealing_brand( 'social' ) );
			?>
			<?php if ( $almicahealing_social ) : ?>
				<ul class="site-footer__social">
					<?php foreach ( $almicahealing_social as $almicahealing_network => $almicahealing_url ) : ?>
						<li>
							<a href="<?php echo esc_url( $almicahealing_url ); ?>" aria-label="<?php echo esc_attr( ucfirst( $almicahealing_network ) ); ?>" target="_blank" rel="noopener noreferrer">
								<?php echo esc_html( strtoupper( substr( $almicahealing_network, 0, 2 ) ) ); ?>
							</a>
						</li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
		</div>
	</div>

	<div class="site-footer__bottom">
		<p>&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>. <?php esc_html_e( 'Todos los derechos reservados.', 'almicahealing' ); ?></p>
		<p class="site-footer__tagline"><?php esc_html_e( 'El equilibrio que da origen a todo', 'almicahealing' ); ?></p>
	</div>
</footer>

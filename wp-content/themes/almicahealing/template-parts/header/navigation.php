<?php
/**
 * Site navigation. Uses wp_nav_menu() against the 'primary' location
 * registered in inc/setup.php — build the menu under Apariencia > Menús.
 *
 * @package AlmicaHealing
 */

defined( 'ABSPATH' ) || exit;
?>
<header class="site-header">
	<div class="site-header__inner">
		<a class="site-header__logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
			<img src="<?php echo esc_url( get_theme_file_uri( 'assets/img/logo_almica.svg' ) ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" width="80" height="49">
		</a>

		<?php
		if ( has_nav_menu( 'primary' ) ) {
			wp_nav_menu(
				array(
					'theme_location'  => 'primary',
					'container'       => 'nav',
					'container_class' => 'site-nav',
					'menu_class'      => 'site-nav__list',
					'depth'           => 1,
				)
			);
		}
		?>
	</div>
</header>

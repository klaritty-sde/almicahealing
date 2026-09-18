<?php
/**
 * 404 template.
 *
 * @package AlmicaHealing
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>
<section class="not-found">
	<h1><?php esc_html_e( 'Página no encontrada', 'almicahealing' ); ?></h1>
	<p><?php esc_html_e( 'El contenido que buscas no existe o fue movido.', 'almicahealing' ); ?></p>
	<a class="button button--gold" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Volver al inicio', 'almicahealing' ); ?></a>
</section>
<?php
get_footer();

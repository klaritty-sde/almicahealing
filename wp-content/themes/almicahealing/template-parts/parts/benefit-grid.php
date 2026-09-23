<?php
/**
 * Benefit tiles — "Lo que esta sesión puede ofrecerte". A plain
 * 3-column auto-flow grid: 1 to 6 tiles all lay out from the same rule,
 * and a tile without a description still works (Figma frames 18–20).
 *
 * $args: rows (array) — the `benefits` repeater rows.
 *
 * @package AlmicaHealing
 */

defined( 'ABSPATH' ) || exit;

$almicahealing_benefits = isset( $args['rows'] ) && is_array( $args['rows'] ) ? $args['rows'] : array();

if ( ! $almicahealing_benefits ) {
	return;
}
?>
<ul class="benefit-grid">
	<?php foreach ( $almicahealing_benefits as $almicahealing_benefit ) : ?>
		<?php
		$almicahealing_benefit = wp_parse_args(
			$almicahealing_benefit,
			array(
				'icon'        => '',
				'title'       => '',
				'description' => '',
			)
		);

		if ( ! $almicahealing_benefit['title'] ) {
			continue;
		}
		?>
		<li class="benefit-tile">
			<?php if ( $almicahealing_benefit['icon'] ) : ?>
				<span class="benefit-tile__icon"><?php almicahealing_benefit_icon( $almicahealing_benefit['icon'] ); ?></span>
			<?php endif; ?>
			<h3 class="benefit-tile__title"><?php echo esc_html( $almicahealing_benefit['title'] ); ?></h3>
			<?php if ( $almicahealing_benefit['description'] ) : ?>
				<p class="benefit-tile__body"><?php echo esc_html( $almicahealing_benefit['description'] ); ?></p>
			<?php endif; ?>
		</li>
	<?php endforeach; ?>
</ul>

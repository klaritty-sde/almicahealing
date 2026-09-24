<?php
/**
 * Founder profile (Figma "Fundadora" frame, node-id 146-513).
 *
 * The name, role, portrait and bio come from the `profesional` post
 * linked in the page's "Fundadora" field, so the same record feeds the
 * founder here and any service or course she appears on.
 *
 * @package AlmicaHealing
 */

defined( 'ABSPATH' ) || exit;

$almicahealing_founder = (int) almicahealing_field( 'founder', get_the_ID() );

if ( ! $almicahealing_founder ) {
	return;
}
?>
<section class="fundadora">
	<div class="fundadora__inner">
		<hr class="fundadora__rule">
		<?php
		get_template_part(
			'template-parts/parts/profesional',
			null,
			array( 'post_id' => $almicahealing_founder )
		);
		?>
	</div>
</section>

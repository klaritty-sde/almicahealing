<?php
/**
 * Small template helpers shared across template-parts.
 *
 * @package AlmicaHealing
 */

defined( 'ABSPATH' ) || exit;

/**
 * Renders the contact form via the site plugin, if it's active.
 * Guarded so the theme doesn't fatal when almicahealing-core is off.
 */
function almicahealing_render_contact_form() {
	if ( function_exists( 'almicahealing_contact_form' ) ) {
		almicahealing_contact_form();
		return;
	}

	if ( WP_DEBUG ) {
		echo '<!-- almicahealing-core is not active: contact form not rendered -->';
	}
}

/**
 * Prints one of the theme's benefit icons by slug.
 *
 * Icons are a closed set shipped in the theme (content model Q8) so the
 * line style stays consistent; an unknown slug renders nothing rather
 * than a broken image.
 *
 * @param string $slug Icon slug, e.g. 'corazon'.
 */
function almicahealing_benefit_icon( $slug ) {
	$slug = sanitize_key( $slug );
	$file = ALMICAHEALING_DIR . '/assets/img/icons/beneficio-' . $slug . '.svg';

	if ( ! $slug || ! file_exists( $file ) ) {
		return;
	}

	// The files are theme-authored SVGs, not user input.
	echo wp_kses(
		file_get_contents( $file ), // phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents
		array(
			'svg'    => array(
				'xmlns'           => true,
				'viewbox'         => true,
				'fill'            => true,
				'stroke'          => true,
				'stroke-width'    => true,
				'stroke-linecap'  => true,
				'stroke-linejoin' => true,
				'aria-hidden'     => true,
				'focusable'       => true,
				'class'           => true,
			),
			'path'   => array( 'd' => true ),
			'circle' => array(
				'cx' => true,
				'cy' => true,
				'r'  => true,
			),
		)
	);
}

/**
 * The services shown in "Otros servicios" on a service detail page.
 *
 * Uses the manual `related_services` override when set; otherwise takes
 * the next services by `menu_order`, wrapping around, so every service
 * gets a different trio (content model Q5 — the design shows the same
 * three everywhere, which is a Figma defect, not the intent).
 *
 * @param int $post_id Current service.
 * @param int $count   How many to return.
 * @return int[] Service post IDs.
 */
function almicahealing_related_services( $post_id, $count = 3 ) {
	$manual = almicahealing_field( 'related_services', $post_id, array() );

	if ( $manual ) {
		return array_slice( array_map( 'intval', (array) $manual ), 0, $count );
	}

	$all = get_posts(
		array(
			'post_type'      => 'servicio',
			'posts_per_page' => -1,
			'orderby'        => 'menu_order',
			'order'          => 'ASC',
			'fields'         => 'ids',
		)
	);

	$position = array_search( (int) $post_id, $all, true );

	if ( false === $position ) {
		return array_slice( $all, 0, $count );
	}

	// Rotate the list so it starts just after the current service, then
	// drop the current one and take the next few.
	$rotated = array_merge( array_slice( $all, $position + 1 ), array_slice( $all, 0, $position ) );

	return array_slice( $rotated, 0, $count );
}

/**
 * Renders a "Volver a…" link above a detail-page hero.
 *
 * @param string $url   Destination.
 * @param string $label Link text.
 */
function almicahealing_back_link( $url, $label ) {
	printf(
		'<a class="detail-hero__back" href="%1$s"><span aria-hidden="true">&larr;</span> %2$s</a>',
		esc_url( $url ),
		esc_html( $label )
	);
}

/**
 * URL of a listing page, falling back to a permalink-style path when
 * the page hasn't been created yet.
 *
 * @param string $slug Page slug, e.g. 'servicios'.
 * @return string
 */
function almicahealing_page_url( $slug ) {
	$page = get_page_by_path( $slug );

	return $page ? get_permalink( $page ) : home_url( '/' . $slug . '/' );
}

/**
 * Does this text open with a lower-case letter?
 *
 * Tells a benefit description that *continues* the title's sentence
 * from one that starts a new sentence of its own — the two are drawn
 * differently in Figma. Accented Spanish initials («énergetico») mean
 * this has to be multibyte-aware, and the second comparison keeps
 * digits and punctuation from counting as lower case.
 *
 * @param string $text Text to test.
 * @return bool
 */
function almicahealing_starts_lowercase( $text ) {
	$text = ltrim( (string) $text );

	if ( '' === $text ) {
		return false;
	}

	$first = mb_substr( $text, 0, 1 );

	return mb_strtolower( $first ) === $first && mb_strtoupper( $first ) !== $first;
}

/**
 * Resolves the image to use for a detail-page hero: the explicit
 * `hero_image` field when set, otherwise the featured image.
 *
 * @param int $post_id Post to read from.
 * @return string Image URL, or an empty string.
 */
function almicahealing_hero_image_url( $post_id ) {
	$hero = almicahealing_field( 'hero_image', $post_id );

	if ( $hero ) {
		$url = wp_get_attachment_image_url( (int) $hero, 'almicahealing-hero' );

		if ( $url ) {
			return $url;
		}
	}

	return (string) get_the_post_thumbnail_url( $post_id, 'almicahealing-hero' );
}

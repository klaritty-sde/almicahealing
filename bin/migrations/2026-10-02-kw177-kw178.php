<?php
/**
 * KW-177 + KW-178 — renames, catalog order and service hero photos.
 *
 * Usage (from the WordPress root):
 *
 *     wp eval-file bin/migrations/2026-10-02-kw177-kw178.php <images-dir> [dry-run]
 *
 * <images-dir> holds the ten `servicio-*-hero.jpg` files. With `dry-run`
 * it reports what it would do and writes nothing.
 *
 * Posts are found by slug, never by ID, because IDs differ between
 * environments, and old or new slugs are both accepted. That makes it safe
 * to re-run: a second run finds everything already in place and changes
 * nothing.
 *
 * The workbook import cannot do this job. It matches rows by slug-based
 * seed key and falls back to the title, so on a database that still has
 * "Escaneo…" the renamed row matches nothing and is inserted as a second
 * service instead of renaming the first.
 *
 * @package AlmicaHealing
 */

defined( 'ABSPATH' ) || exit;

if ( ! defined( 'WP_CLI' ) || ! WP_CLI ) {
	return;
}

require_once ABSPATH . 'wp-admin/includes/media.php';
require_once ABSPATH . 'wp-admin/includes/file.php';
require_once ABSPATH . 'wp-admin/includes/image.php';

$almicahealing_images_dir = isset( $args[0] ) ? rtrim( $args[0], '/' ) : '';
$almicahealing_dry_run    = in_array( 'dry-run', $args, true );

if ( ! function_exists( 'update_field' ) ) {
	WP_CLI::error( 'Secure Custom Fields is not active; hero_image cannot be written.' );
}

if ( '' === $almicahealing_images_dir || ! is_dir( $almicahealing_images_dir ) ) {
	WP_CLI::error( 'Pass the directory that holds the servicio-*-hero.jpg files.' );
}

/**
 * Finds a post by its current slug or by any of the alternatives.
 *
 * @param string   $post_type Post type.
 * @param string[] $slugs     Slugs to try, preferred first.
 * @return WP_Post|null
 */
function almicahealing_migration_find( $post_type, array $slugs ) {
	foreach ( $slugs as $slug ) {
		$found = get_posts(
			array(
				'post_type'      => $post_type,
				'post_status'    => 'any',
				'name'           => $slug,
				'posts_per_page' => 1,
			)
		);

		if ( $found ) {
			return $found[0];
		}
	}

	return null;
}

// Renames: new slug first, so a re-run finds the already-renamed post.
$almicahealing_renames = array(
	array( 'servicio', array( 'terapia-y-armonizacion-energetica', 'escaneo-y-balance-energetico-en-personas' ), 'Terapia y Armonización Energética' ),
	array( 'curso', array( 'kriutunmi', 'riutunmi' ), 'Kriutunmi' ),
);

// Order: the client's featured six first (2026-09-29), then the rest in
// their previous relative order. Slugs are the post-rename ones.
$almicahealing_order = array(
	'curso'    => array( 'kriutunmi', 'clantanra', 'lo-que-nadie-nos-enseno' ),
	'servicio' => array(
		'terapia-y-armonizacion-energetica',
		'biodescodificacion',
		'armonizacion-energetica-laboral-y-bloqueos-relacionados',
		'constelacion-familiar-para-el-trabajo',
		'conexion-con-registros',
		'arteterapia',
		'limpieza-energetica-de-lugares',
		'conexion-con-seres-trascendidos',
		'futuros-posibles',
		'limpieza-y-conexion-con-personas',
		'limpieza-y-conexion-emocional-con-personas',
	),
);

// Figma hero photo per service. Arteterapia's hero is its card photo, so
// it keeps the featured-image fallback.
$almicahealing_heroes = array(
	'biodescodificacion'                         => 'servicio-biodescodificacion-hero.jpg',
	'constelacion-familiar-para-el-trabajo'      => 'servicio-constelacion-familiar-hero.jpg',
	'armonizacion-energetica-laboral-y-bloqueos-relacionados' => 'servicio-armonizacion-energetica-hero.jpg',
	'limpieza-energetica-de-lugares'             => 'servicio-limpieza-energetica-lugares-hero.jpg',
	'terapia-y-armonizacion-energetica'          => 'servicio-terapia-armonizacion-energetica-hero.jpg',
	'conexion-con-seres-trascendidos'            => 'servicio-conexion-seres-trascendidos-hero.jpg',
	'conexion-con-registros'                     => 'servicio-conexion-registros-hero.jpg',
	'futuros-posibles'                           => 'servicio-futuros-posibles-hero.jpg',
	'limpieza-y-conexion-con-personas'           => 'servicio-limpieza-conexion-personas-hero.jpg',
	'limpieza-y-conexion-emocional-con-personas' => 'servicio-limpieza-conexion-emocional-personas-hero.jpg',
);

// --- 1. Validate everything before writing anything. ---------------------

$almicahealing_problems = array();

foreach ( $almicahealing_renames as list( $almicahealing_type, $almicahealing_slugs ) ) {
	if ( ! almicahealing_migration_find( $almicahealing_type, $almicahealing_slugs ) ) {
		$almicahealing_problems[] = "{$almicahealing_type} not found under any of: " . implode( ', ', $almicahealing_slugs );
	}
}

foreach ( $almicahealing_order as $almicahealing_type => $almicahealing_slugs ) {
	foreach ( $almicahealing_slugs as $almicahealing_slug ) {
		$almicahealing_lookup = array( $almicahealing_slug );

		foreach ( $almicahealing_renames as list( $almicahealing_rtype, $almicahealing_rslugs ) ) {
			if ( $almicahealing_rtype === $almicahealing_type && $almicahealing_rslugs[0] === $almicahealing_slug ) {
				$almicahealing_lookup = $almicahealing_rslugs;
			}
		}

		if ( ! almicahealing_migration_find( $almicahealing_type, $almicahealing_lookup ) ) {
			$almicahealing_problems[] = "{$almicahealing_type} \"{$almicahealing_slug}\" not found";
		}
	}
}

foreach ( $almicahealing_heroes as $almicahealing_file ) {
	if ( ! is_readable( "{$almicahealing_images_dir}/{$almicahealing_file}" ) ) {
		$almicahealing_problems[] = "missing image {$almicahealing_images_dir}/{$almicahealing_file}";
	}
}

if ( $almicahealing_problems ) {
	foreach ( $almicahealing_problems as $almicahealing_problem ) {
		WP_CLI::warning( $almicahealing_problem );
	}
	WP_CLI::error( 'Nothing was written.' );
}

$almicahealing_changes = 0;

/**
 * Logs a change and reports whether to perform it.
 *
 * @param string $message What would change.
 * @return bool True when the change should be written.
 */
$almicahealing_change = function ( $message ) use ( $almicahealing_dry_run, &$almicahealing_changes ) {
	++$almicahealing_changes;
	WP_CLI::log( ( $almicahealing_dry_run ? '[dry-run] ' : '' ) . $message );

	return ! $almicahealing_dry_run;
};

// --- 2. Renames. WordPress keeps the old slug and redirects it. -----------

foreach ( $almicahealing_renames as list( $almicahealing_type, $almicahealing_slugs, $almicahealing_title ) ) {
	$almicahealing_post = almicahealing_migration_find( $almicahealing_type, $almicahealing_slugs );
	$almicahealing_slug = $almicahealing_slugs[0];
	$almicahealing_key  = "{$almicahealing_type}-{$almicahealing_slug}";

	if ( $almicahealing_post->post_title !== $almicahealing_title || $almicahealing_post->post_name !== $almicahealing_slug ) {
		if ( $almicahealing_change( "rename {$almicahealing_type} {$almicahealing_post->ID} \"{$almicahealing_post->post_title}\" ({$almicahealing_post->post_name}) -> \"{$almicahealing_title}\" ({$almicahealing_slug})" ) ) {
			wp_update_post(
				array(
					'ID'         => $almicahealing_post->ID,
					'post_title' => $almicahealing_title,
					'post_name'  => $almicahealing_slug,
				)
			);
		}
	}

	// The workbook import matches rows by this key; keep it on the new slug.
	if ( get_post_meta( $almicahealing_post->ID, '_almicahealing_seed_key', true ) !== $almicahealing_key ) {
		if ( $almicahealing_change( "seed key of {$almicahealing_post->ID} -> {$almicahealing_key}" ) ) {
			update_post_meta( $almicahealing_post->ID, '_almicahealing_seed_key', $almicahealing_key );
		}
	}
}

// --- 3. Order. In a dry run the renames above did not happen, so look the
// renamed posts up under their old slugs too. ------------------------------

foreach ( $almicahealing_order as $almicahealing_type => $almicahealing_slugs ) {
	foreach ( $almicahealing_slugs as $almicahealing_i => $almicahealing_slug ) {
		$almicahealing_lookup = array( $almicahealing_slug );

		foreach ( $almicahealing_renames as list( $almicahealing_rtype, $almicahealing_rslugs ) ) {
			if ( $almicahealing_rtype === $almicahealing_type && $almicahealing_rslugs[0] === $almicahealing_slug ) {
				$almicahealing_lookup = $almicahealing_rslugs;
			}
		}

		$almicahealing_post        = almicahealing_migration_find( $almicahealing_type, $almicahealing_lookup );
		$almicahealing_order_value = $almicahealing_i + 1;

		if ( (int) $almicahealing_post->menu_order !== $almicahealing_order_value ) {
			if ( $almicahealing_change( "order {$almicahealing_type} {$almicahealing_slug}: {$almicahealing_post->menu_order} -> {$almicahealing_order_value}" ) ) {
				wp_update_post(
					array(
						'ID'         => $almicahealing_post->ID,
						'menu_order' => $almicahealing_order_value,
					)
				);
			}
		}
	}
}

// --- 4. Hero photos: reuse an attachment already holding the file, or
// upload it. ---------------------------------------------------------------

global $wpdb;

foreach ( $almicahealing_heroes as $almicahealing_slug => $almicahealing_file ) {
	$almicahealing_lookup = 'terapia-y-armonizacion-energetica' === $almicahealing_slug
		? array( $almicahealing_slug, 'escaneo-y-balance-energetico-en-personas' )
		: array( $almicahealing_slug );
	$almicahealing_post   = almicahealing_migration_find( 'servicio', $almicahealing_lookup );
	$almicahealing_base   = pathinfo( $almicahealing_file, PATHINFO_FILENAME );
	$almicahealing_hero   = (int) get_post_meta( $almicahealing_post->ID, 'hero_image', true );

	// WordPress appends -1, -2… when the file name is already taken, so
	// "the same photo" is the base name with an optional numeric suffix.
	$almicahealing_pattern = '/^' . preg_quote( $almicahealing_base, '/' ) . '(-\d+)?\.jpg$/';

	if ( $almicahealing_hero && preg_match( $almicahealing_pattern, basename( (string) get_attached_file( $almicahealing_hero ) ) ) ) {
		continue;
	}

	// Reuse an upload of this photo if one exists, preferring one already
	// attached to this service.
	// phpcs:ignore WordPress.DB.DirectDatabaseQuery -- one-off lookup by file name.
	$almicahealing_candidates = $wpdb->get_results(
		$wpdb->prepare(
			"SELECT m.post_id, m.meta_value, p.post_parent FROM {$wpdb->postmeta} m JOIN {$wpdb->posts} p ON p.ID = m.post_id WHERE m.meta_key = '_wp_attached_file' AND m.meta_value LIKE %s ORDER BY m.post_id",
			'%/' . $wpdb->esc_like( $almicahealing_base ) . '%'
		)
	);
	$almicahealing_attachment = 0;

	foreach ( $almicahealing_candidates as $almicahealing_candidate ) {
		if ( ! preg_match( $almicahealing_pattern, basename( $almicahealing_candidate->meta_value ) ) ) {
			continue;
		}

		if ( ! $almicahealing_attachment || (int) $almicahealing_candidate->post_parent === $almicahealing_post->ID ) {
			$almicahealing_attachment = (int) $almicahealing_candidate->post_id;
		}
	}

	if ( ! $almicahealing_change( "hero_image of {$almicahealing_slug} -> " . ( $almicahealing_attachment ? "existing attachment {$almicahealing_attachment}" : "upload {$almicahealing_file}" ) ) ) {
		continue;
	}

	if ( ! $almicahealing_attachment ) {
		$almicahealing_tmp = wp_tempnam( $almicahealing_file );
		copy( "{$almicahealing_images_dir}/{$almicahealing_file}", $almicahealing_tmp );

		$almicahealing_attachment = media_handle_sideload(
			array(
				'name'     => $almicahealing_file,
				'tmp_name' => $almicahealing_tmp,
			),
			$almicahealing_post->ID,
			get_the_title( $almicahealing_post->ID )
		);

		if ( is_wp_error( $almicahealing_attachment ) ) {
			WP_CLI::error( "{$almicahealing_file}: " . $almicahealing_attachment->get_error_message() );
		}

		// The photo is decorative behind the title.
		update_post_meta( $almicahealing_attachment, '_wp_attachment_image_alt', '' );
	}

	update_field( 'hero_image', $almicahealing_attachment, $almicahealing_post->ID );
}

if ( 0 === $almicahealing_changes ) {
	WP_CLI::success( 'Already applied; nothing to do.' );
} elseif ( $almicahealing_dry_run ) {
	WP_CLI::success( "{$almicahealing_changes} change(s) would be made. Nothing was written." );
} else {
	WP_CLI::success( "{$almicahealing_changes} change(s) made." );
}

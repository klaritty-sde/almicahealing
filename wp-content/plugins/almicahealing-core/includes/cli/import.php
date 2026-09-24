<?php
/**
 * `wp almicahealing import <archivo.xlsx>` — loads the content workbook
 * (KW-155).
 *
 * Two phases, always in this order:
 *
 * 1. **Validate.** Every sheet, column, enum and cross-sheet reference is
 *    checked and *all* problems are collected. Nothing is written.
 * 2. **Import.** Only runs when validation is clean, in dependency order
 *    so a relationship's target always exists before the post that points
 *    at it.
 *
 * A bad slug therefore stops the run with a report instead of importing
 * half the site, which is the behaviour the content model specifies.
 *
 * Re-running is safe: rows are matched by the same `_almicahealing_seed_key`
 * convention the seeders use, so an import updates in place.
 *
 * @package AlmicaHealingCore
 */

defined( 'ABSPATH' ) || exit;

if ( ! defined( 'WP_CLI' ) || ! WP_CLI ) {
	return;
}

require_once __DIR__ . '/class-almicahealing-xlsx-reader.php';
require_once __DIR__ . '/class-almicahealing-import-report.php';

/**
 * Columns each sheet must provide. Extra columns are ignored, so the
 * editors' own notes don't break the import.
 */
const ALMICAHEALING_IMPORT_SCHEMA = array(
	'profesionales'         => array( 'slug', 'name', 'role', 'bio', 'photo', 'order' ),
	'profesional_formacion' => array( 'profesional_slug', 'position', 'title', 'year', 'institution', 'description' ),
	'servicios'             => array( 'slug', 'title', 'order', 'is_featured', 'summary', 'tagline', 'description', 'price', 'price_basis', 'duration_minutes', 'modality', 'professionals', 'card_image', 'hero_image', 'includes_workbook', 'status' ),
	'servicio_beneficios'   => array( 'servicio_slug', 'position', 'icon', 'title', 'description' ),
	'cursos'                => array( 'slug', 'title', 'order', 'level', 'program_label', 'summary', 'tagline', 'description', 'price', 'duration', 'outcomes_heading', 'facilitators', 'image', 'status' ),
	'curso_puntos'          => array( 'curso_slug', 'position', 'text' ),
	'testimonios'           => array( 'slug', 'client_name', 'quote', 'about_type', 'about_slug', 'order' ),
	'ajustes'               => array( 'key', 'value' ),
	'paginas'               => array( 'pagina', 'campo', 'texto' ),
);

/**
 * Normalises a single-line field: collapses the hard line breaks that
 * come from copying wrapped text out of a design tool.
 *
 * @param string $value Raw cell value.
 * @return string
 */
function almicahealing_import_line( $value ) {
	return trim( preg_replace( '/\s+/u', ' ', (string) $value ) );
}

/**
 * Normalises a rich-text field: keeps paragraph breaks (a blank line),
 * collapses everything else.
 *
 * @param string $value Raw cell value.
 * @return string
 */
function almicahealing_import_rich( $value ) {
	$value      = str_replace( array( "\r\n", "\r" ), "\n", (string) $value );
	$paragraphs = preg_split( '/\n\s*\n/u', $value );
	$clean      = array();

	foreach ( $paragraphs as $paragraph ) {
		$paragraph = almicahealing_import_line( $paragraph );

		if ( '' !== $paragraph ) {
			$clean[] = $paragraph;
		}
	}

	return implode( "\n\n", $clean );
}

/**
 * Reads a `sí`/`no` cell.
 *
 * @param string $value Raw cell value.
 * @return bool
 */
function almicahealing_import_bool( $value ) {
	$value = strtolower( almicahealing_import_line( $value ) );

	return in_array( $value, array( 'sí', 'si', 'yes', 'true', '1', 'x' ), true );
}

/**
 * Splits a pipe-separated slug list.
 *
 * @param string $value Raw cell value.
 * @return string[]
 */
function almicahealing_import_slugs( $value ) {
	$parts = explode( '|', (string) $value );
	$slugs = array();

	foreach ( $parts as $part ) {
		$part = almicahealing_import_line( $part );

		if ( '' !== $part ) {
			$slugs[] = $part;
		}
	}

	return $slugs;
}

/**
 * Finds an attachment by file name, so the sheet can reference images by
 * name without the importer uploading anything.
 *
 * @param string $filename File name, e.g. 'arteterapia.jpg'.
 * @return int Attachment ID, or 0.
 */
function almicahealing_import_attachment( $filename ) {
	global $wpdb;

	$filename = almicahealing_import_line( $filename );

	if ( '' === $filename ) {
		return 0;
	}

	$id = $wpdb->get_var(
		$wpdb->prepare(
			"SELECT post_id FROM {$wpdb->postmeta} WHERE meta_key = '_wp_attached_file' AND meta_value LIKE %s LIMIT 1",
			'%' . $wpdb->esc_like( $filename )
		)
	);

	return (int) $id;
}

/**
 * Validates the whole workbook before anything is written.
 *
 * @param array                       $data   Sheet name => rows.
 * @param Almicahealing_Import_Report $report Collector.
 */
function almicahealing_import_validate( array $data, Almicahealing_Import_Report $report ) {
	$modalities = array_keys( almicahealing_modality_choices() );
	$levels     = array_keys( almicahealing_level_choices() );
	$headings   = array_keys( almicahealing_outcomes_heading_choices() );
	$icons      = array_keys( almicahealing_benefit_icon_choices() );

	// --- collect the slugs every cross-reference is checked against ---
	$pro_slugs     = array();
	$servicio_slug = array();
	$curso_slugs   = array();

	foreach ( $data['profesionales'] as $row ) {
		$pro_slugs[] = almicahealing_import_line( $row['slug'] );
	}
	foreach ( $data['servicios'] as $row ) {
		$servicio_slug[] = almicahealing_import_line( $row['slug'] );
	}
	foreach ( $data['cursos'] as $row ) {
		$curso_slugs[] = almicahealing_import_line( $row['slug'] );
	}

	foreach ( array(
		'profesionales' => $pro_slugs,
		'servicios'     => $servicio_slug,
		'cursos'        => $curso_slugs,
	) as $sheet => $slugs ) {
		$dupes = array_diff_assoc( $slugs, array_unique( $slugs ) );

		foreach ( array_unique( $dupes ) as $dupe ) {
			$report->error( $sheet, 0, sprintf( 'el slug «%s» está repetido.', $dupe ) );
		}

		foreach ( $slugs as $slug ) {
			if ( '' === $slug ) {
				$report->error( $sheet, 0, 'hay una fila sin slug.' );
			}
		}
	}

	// --- profesionales ---
	foreach ( $data['profesionales'] as $row ) {
		if ( '' === almicahealing_import_line( $row['name'] ) ) {
			$report->error( 'profesionales', $row['__row'], 'falta «name».' );
		}
		if ( '' === almicahealing_import_line( $row['role'] ) ) {
			$report->warn( 'profesionales', $row['__row'], 'sin «role»: la línea dorada saldrá vacía.' );
		}
		if ( '' === almicahealing_import_line( $row['bio'] ) ) {
			$report->warn( 'profesionales', $row['__row'], 'sin biografía.' );
		}
		if ( '' === almicahealing_import_line( $row['photo'] ) ) {
			$report->warn( 'profesionales', $row['__row'], 'sin foto: se mostrará un círculo vacío.' );
		}
	}

	// --- servicios ---
	foreach ( $data['servicios'] as $row ) {
		$line = $row['__row'];

		if ( '' === almicahealing_import_line( $row['title'] ) ) {
			$report->error( 'servicios', $line, 'falta «title».' );
		}

		$price = almicahealing_import_line( $row['price'] );

		if ( '' === $price || ! is_numeric( $price ) ) {
			$report->error( 'servicios', $line, sprintf( '«price» debe ser un número, llegó «%s».', $price ) );
		}

		$minutes = almicahealing_import_line( $row['duration_minutes'] );

		if ( ! is_numeric( $minutes ) || (int) $minutes < 15 || (int) $minutes > 480 ) {
			$report->error( 'servicios', $line, sprintf( '«duration_minutes» debe ir entre 15 y 480, llegó «%s».', $minutes ) );
		}

		$modality = almicahealing_import_line( $row['modality'] );

		if ( ! in_array( $modality, $modalities, true ) ) {
			$report->error( 'servicios', $line, sprintf( '«modality» debe ser uno de %s, llegó «%s».', implode( ', ', $modalities ), $modality ) );
		}

		$status = almicahealing_import_line( $row['status'] );

		if ( ! in_array( $status, array( 'publish', 'draft' ), true ) ) {
			$report->error( 'servicios', $line, sprintf( '«status» debe ser publish o draft, llegó «%s».', $status ) );
		}

		foreach ( almicahealing_import_slugs( $row['professionals'] ) as $slug ) {
			if ( ! in_array( $slug, $pro_slugs, true ) ) {
				$report->error( 'servicios', $line, sprintf( '«professionals» apunta a «%s», que no existe en la hoja profesionales.', $slug ) );
			}
		}

		if ( '' === almicahealing_import_line( $row['professionals'] ) ) {
			$report->warn( 'servicios', $line, 'sin terapeuta: la sección «Quién imparte» quedará oculta.' );
		}

		if ( '' === almicahealing_import_line( $row['description'] ) ) {
			$report->warn( 'servicios', $line, 'sin descripción: la página se verá casi vacía.' );
		}
	}

	// --- servicio_beneficios ---
	foreach ( $data['servicio_beneficios'] as $row ) {
		$line = $row['__row'];
		$slug = almicahealing_import_line( $row['servicio_slug'] );

		if ( ! in_array( $slug, $servicio_slug, true ) ) {
			$report->error( 'servicio_beneficios', $line, sprintf( 'apunta al servicio «%s», que no existe.', $slug ) );
		}

		$icon = almicahealing_import_line( $row['icon'] );

		if ( '' !== $icon && ! in_array( $icon, $icons, true ) ) {
			$report->error( 'servicio_beneficios', $line, sprintf( 'el icono «%s» no está en el set del tema.', $icon ) );
		}

		if ( '' === almicahealing_import_line( $row['title'] ) ) {
			$report->error( 'servicio_beneficios', $line, 'falta «title»: una tarjeta sin título no se puede mostrar.' );
		}
	}

	// --- cursos ---
	foreach ( $data['cursos'] as $row ) {
		$line = $row['__row'];

		if ( '' === almicahealing_import_line( $row['title'] ) ) {
			$report->error( 'cursos', $line, 'falta «title».' );
		}

		$level = almicahealing_import_line( $row['level'] );

		if ( ! in_array( $level, $levels, true ) ) {
			$report->error( 'cursos', $line, sprintf( '«level» debe ser uno de %s, llegó «%s».', implode( ', ', $levels ), $level ) );
		}

		$heading = almicahealing_import_line( $row['outcomes_heading'] );

		if ( ! in_array( $heading, $headings, true ) ) {
			$report->error( 'cursos', $line, sprintf( '«outcomes_heading» debe ser uno de %s, llegó «%s».', implode( ', ', $headings ), $heading ) );
		}

		$price = almicahealing_import_line( $row['price'] );

		if ( '' !== $price && ! is_numeric( $price ) ) {
			$report->error( 'cursos', $line, sprintf( '«price» debe ser un número o quedar vacío, llegó «%s».', $price ) );
		}

		if ( '' !== $price && '' === almicahealing_import_line( $row['duration'] ) ) {
			$report->warn( 'cursos', $line, 'tiene precio pero no duración.' );
		}

		$facilitators = almicahealing_import_slugs( $row['facilitators'] );

		if ( ! $facilitators ) {
			$report->error( 'cursos', $line, '«facilitators» es obligatorio.' );
		}

		foreach ( $facilitators as $slug ) {
			if ( ! in_array( $slug, $pro_slugs, true ) ) {
				$report->error( 'cursos', $line, sprintf( '«facilitators» apunta a «%s», que no existe en la hoja profesionales.', $slug ) );
			}
		}
	}

	// --- curso_puntos ---
	foreach ( $data['curso_puntos'] as $row ) {
		$slug = almicahealing_import_line( $row['curso_slug'] );

		if ( ! in_array( $slug, $curso_slugs, true ) ) {
			$report->error( 'curso_puntos', $row['__row'], sprintf( 'apunta al curso «%s», que no existe.', $slug ) );
		}

		if ( '' === almicahealing_import_line( $row['text'] ) ) {
			$report->error( 'curso_puntos', $row['__row'], 'falta «text».' );
		}
	}

	// --- testimonios ---
	foreach ( $data['testimonios'] as $row ) {
		$line = $row['__row'];
		$type = almicahealing_import_line( $row['about_type'] );
		$slug = almicahealing_import_line( $row['about_slug'] );

		if ( '' === almicahealing_import_line( $row['quote'] ) ) {
			$report->error( 'testimonios', $line, 'falta «quote».' );
		}

		if ( '' !== $type && ! in_array( $type, array( 'servicio', 'curso' ), true ) ) {
			$report->error( 'testimonios', $line, sprintf( '«about_type» debe ser servicio o curso, llegó «%s».', $type ) );
		}

		if ( '' !== $slug ) {
			$pool = ( 'curso' === $type ) ? $curso_slugs : $servicio_slug;

			if ( ! in_array( $slug, $pool, true ) ) {
				$report->error( 'testimonios', $line, sprintf( '«about_slug» apunta a «%s», que no existe.', $slug ) );
			}
		}
	}

	// --- profesional_formacion ---
	foreach ( $data['profesional_formacion'] as $row ) {
		$slug = almicahealing_import_line( $row['profesional_slug'] );

		if ( ! in_array( $slug, $pro_slugs, true ) ) {
			$report->error( 'profesional_formacion', $row['__row'], sprintf( 'apunta a «%s», que no existe.', $slug ) );
		}
	}

	// --- ajustes ---
	$known = array_keys( almicahealing_setting_defaults() );

	foreach ( $data['ajustes'] as $row ) {
		$key = almicahealing_import_line( $row['key'] );

		if ( ! in_array( $key, $known, true ) ) {
			$report->error( 'ajustes', $row['__row'], sprintf( 'el ajuste «%s» no existe.', $key ) );
		}
	}
}

/**
 * Where each `paginas` row lands. Keys are "pagina|campo".
 *
 * Values are [page slug, kind, target], where kind is:
 *  - `field`   : a top-level field,
 *  - `group`   : "group/subfield",
 *  - `content` : the page's own post_content,
 *  - `step`    : "index/subfield" inside the process_steps repeater.
 *
 * @return array<string,array>
 */
function almicahealing_import_page_map() {
	$map = array(
		'Inicio|hero_eyebrow'       => array( 'inicio', 'field', 'hero_eyebrow' ),
		'Inicio|hero_title'         => array( 'inicio', 'field', 'hero_title' ),
		'Inicio|hero_subtitle'      => array( 'inicio', 'field', 'hero_subtitle' ),
		'Inicio|intro_title'        => array( 'inicio', 'group', 'intro/title' ),
		'Inicio|intro_body'         => array( 'inicio', 'group', 'intro/body' ),
		'Inicio|services_eyebrow'   => array( 'inicio', 'group', 'services_intro/eyebrow' ),
		'Inicio|services_title'     => array( 'inicio', 'group', 'services_intro/title' ),
		'Inicio|services_subtitle'  => array( 'inicio', 'group', 'services_intro/subtitle' ),
		'Inicio|process_1_title'    => array( 'inicio', 'step', '0/title' ),
		'Inicio|process_1_body'     => array( 'inicio', 'step', '0/body' ),
		'Inicio|process_2_title'    => array( 'inicio', 'step', '1/title' ),
		'Inicio|process_2_body'     => array( 'inicio', 'step', '1/body' ),
		'Inicio|process_3_title'    => array( 'inicio', 'step', '2/title' ),
		'Inicio|process_3_body'     => array( 'inicio', 'step', '2/body' ),
		'Inicio|quote_line_1'       => array( 'inicio', 'group', 'quote/line_1' ),
		'Inicio|quote_line_2'       => array( 'inicio', 'group', 'quote/line_2' ),
		'Inicio|courses_eyebrow'    => array( 'inicio', 'group', 'courses_intro/eyebrow' ),
		'Inicio|courses_title'      => array( 'inicio', 'group', 'courses_intro/title' ),
		'Inicio|courses_body'       => array( 'inicio', 'group', 'courses_intro/body' ),
		'Inicio|testimonials_title' => array( 'inicio', 'field', 'testimonials_title' ),
		'Acerca de|hero_eyebrow'    => array( 'acerca-de', 'field', 'hero_eyebrow' ),
		'Acerca de|hero_title'      => array( 'acerca-de', 'field', 'hero_title' ),
		'Acerca de|hero_subtitle'   => array( 'acerca-de', 'field', 'hero_subtitle' ),
		'Acerca de|nosotros'        => array( 'acerca-de', 'content', '' ),
		'Servicios|hero_eyebrow'    => array( 'servicios', 'field', 'hero_eyebrow' ),
		'Servicios|hero_title'      => array( 'servicios', 'field', 'hero_title' ),
		'Servicios|hero_subtitle'   => array( 'servicios', 'field', 'hero_subtitle' ),
		'Cursos|hero_eyebrow'       => array( 'cursos', 'field', 'hero_eyebrow' ),
		'Cursos|hero_title'         => array( 'cursos', 'field', 'hero_title' ),
		'Cursos|hero_subtitle'      => array( 'cursos', 'field', 'hero_subtitle' ),
	);

	return $map;
}

/**
 * Writes the workbook to the database. Only called after validation passes.
 *
 * @param array                       $data   Sheet name => rows.
 * @param Almicahealing_Import_Report $report Collector, for image warnings.
 * @return array<string,int> Counts per entity, for the summary.
 */
function almicahealing_import_write( array $data, Almicahealing_Import_Report $report ) {
	$counts = array_fill_keys( array_keys( ALMICAHEALING_IMPORT_SCHEMA ), 0 );
	$ids    = array(
		'profesional' => array(),
		'servicio'    => array(),
		'curso'       => array(),
	);

	// 1. profesionales — relationship targets go in before anything points at them.
	foreach ( $data['profesionales'] as $row ) {
		$slug    = almicahealing_import_line( $row['slug'] );
		$post_id = almicahealing_seed_post(
			"profesional-{$slug}",
			array(
				'post_type'    => 'profesional',
				'post_title'   => almicahealing_import_line( $row['name'] ),
				'post_name'    => $slug,
				'post_content' => almicahealing_import_rich( $row['bio'] ),
				'post_status'  => 'publish',
				'menu_order'   => (int) $row['order'],
			)
		);

		almicahealing_seed_field( 'role', almicahealing_import_line( $row['role'] ), $post_id );
		almicahealing_import_set_thumbnail( $post_id, $row['photo'], 'profesionales', $row['__row'], $report );

		$ids['profesional'][ $slug ] = $post_id;
		++$counts['profesionales'];
	}

	// 2. profesional_formacion — grouped by parent, then written once each.
	$formacion = array();

	foreach ( $data['profesional_formacion'] as $row ) {
		$slug = almicahealing_import_line( $row['profesional_slug'] );

		$formacion[ $slug ][] = array(
			'position'    => (int) $row['position'],
			'title'       => almicahealing_import_line( $row['title'] ),
			'year'        => almicahealing_import_line( $row['year'] ),
			'institution' => almicahealing_import_line( $row['institution'] ),
			'description' => almicahealing_import_rich( $row['description'] ),
		);
	}

	foreach ( $formacion as $slug => $rows ) {
		usort(
			$rows,
			function ( $a, $b ) {
				return $a['position'] <=> $b['position'];
			}
		);

		foreach ( $rows as &$entry ) {
			unset( $entry['position'] );
		}
		unset( $entry );

		almicahealing_seed_field( 'credentials', $rows, $ids['profesional'][ $slug ] );
		$counts['profesional_formacion'] += count( $rows );
	}

	// 3. servicios.
	foreach ( $data['servicios'] as $row ) {
		$slug    = almicahealing_import_line( $row['slug'] );
		$post_id = almicahealing_seed_post(
			"servicio-{$slug}",
			array(
				'post_type'    => 'servicio',
				'post_title'   => almicahealing_import_line( $row['title'] ),
				'post_name'    => $slug,
				'post_excerpt' => almicahealing_import_line( $row['summary'] ),
				'post_content' => almicahealing_import_rich( $row['description'] ),
				'post_status'  => almicahealing_import_line( $row['status'] ),
				'menu_order'   => (int) $row['order'],
			)
		);

		almicahealing_seed_field( 'tagline', almicahealing_import_line( $row['tagline'] ), $post_id );
		almicahealing_seed_field( 'price', (float) $row['price'], $post_id );
		almicahealing_seed_field( 'price_basis', almicahealing_import_line( $row['price_basis'] ), $post_id );
		almicahealing_seed_field( 'duration_minutes', (int) $row['duration_minutes'], $post_id );
		almicahealing_seed_field( 'modality', almicahealing_import_line( $row['modality'] ), $post_id );
		almicahealing_seed_field( 'is_featured', almicahealing_import_bool( $row['is_featured'] ) ? 1 : 0, $post_id );
		almicahealing_seed_field( 'includes_workbook', almicahealing_import_bool( $row['includes_workbook'] ) ? 1 : 0, $post_id );

		$pros = array();

		foreach ( almicahealing_import_slugs( $row['professionals'] ) as $pro_slug ) {
			$pros[] = $ids['profesional'][ $pro_slug ];
		}

		almicahealing_seed_field( 'professionals', $pros, $post_id );

		almicahealing_import_set_thumbnail( $post_id, $row['card_image'], 'servicios', $row['__row'], $report );

		$hero = almicahealing_import_attachment( $row['hero_image'] );

		if ( $hero ) {
			almicahealing_seed_field( 'hero_image', $hero, $post_id );
		}

		$ids['servicio'][ $slug ] = $post_id;
		++$counts['servicios'];
	}

	// 4. servicio_beneficios.
	$benefits = array();

	foreach ( $data['servicio_beneficios'] as $row ) {
		$slug = almicahealing_import_line( $row['servicio_slug'] );

		$benefits[ $slug ][] = array(
			'position'    => (int) $row['position'],
			'icon'        => almicahealing_import_line( $row['icon'] ),
			'title'       => almicahealing_import_line( $row['title'] ),
			'description' => almicahealing_import_line( $row['description'] ),
		);
	}

	foreach ( $benefits as $slug => $rows ) {
		usort(
			$rows,
			function ( $a, $b ) {
				return $a['position'] <=> $b['position'];
			}
		);

		foreach ( $rows as &$entry ) {
			unset( $entry['position'] );
		}
		unset( $entry );

		almicahealing_seed_field( 'benefits', $rows, $ids['servicio'][ $slug ] );
		$counts['servicio_beneficios'] += count( $rows );
	}

	// 5. cursos.
	foreach ( $data['cursos'] as $row ) {
		$slug    = almicahealing_import_line( $row['slug'] );
		$price   = almicahealing_import_line( $row['price'] );
		$post_id = almicahealing_seed_post(
			"curso-{$slug}",
			array(
				'post_type'    => 'curso',
				'post_title'   => almicahealing_import_line( $row['title'] ),
				'post_name'    => $slug,
				'post_excerpt' => almicahealing_import_line( $row['summary'] ),
				'post_content' => almicahealing_import_rich( $row['description'] ),
				'post_status'  => almicahealing_import_line( $row['status'] ),
				'menu_order'   => (int) $row['order'],
			)
		);

		almicahealing_seed_field( 'tagline', almicahealing_import_line( $row['tagline'] ), $post_id );
		almicahealing_seed_field( 'program_label', almicahealing_import_line( $row['program_label'] ), $post_id );
		almicahealing_seed_field( 'level', almicahealing_import_line( $row['level'] ), $post_id );
		almicahealing_seed_field( 'duration', almicahealing_import_line( $row['duration'] ), $post_id );
		almicahealing_seed_field( 'outcomes_heading', almicahealing_import_line( $row['outcomes_heading'] ), $post_id );
		// An empty price is meaningful: it switches the page to "price on request".
		almicahealing_seed_field( 'price', '' === $price ? '' : (float) $price, $post_id );

		$facilitators = array();

		foreach ( almicahealing_import_slugs( $row['facilitators'] ) as $pro_slug ) {
			$facilitators[] = $ids['profesional'][ $pro_slug ];
		}

		almicahealing_seed_field( 'facilitators', $facilitators, $post_id );
		almicahealing_import_set_thumbnail( $post_id, $row['image'], 'cursos', $row['__row'], $report );

		$ids['curso'][ $slug ] = $post_id;
		++$counts['cursos'];
	}

	// 6. curso_puntos.
	$points = array();

	foreach ( $data['curso_puntos'] as $row ) {
		$slug = almicahealing_import_line( $row['curso_slug'] );

		$points[ $slug ][] = array(
			'position' => (int) $row['position'],
			'text'     => almicahealing_import_line( $row['text'] ),
		);
	}

	foreach ( $points as $slug => $rows ) {
		usort(
			$rows,
			function ( $a, $b ) {
				return $a['position'] <=> $b['position'];
			}
		);

		$clean = array();

		foreach ( $rows as $entry ) {
			$clean[] = array( 'text' => $entry['text'] );
		}

		almicahealing_seed_field( 'outcomes', $clean, $ids['curso'][ $slug ] );
		$counts['curso_puntos'] += count( $clean );
	}

	// 7. testimonios.
	foreach ( $data['testimonios'] as $row ) {
		$slug    = almicahealing_import_line( $row['slug'] );
		$post_id = almicahealing_seed_post(
			"testimonio-{$slug}",
			array(
				'post_type'    => 'testimonio',
				'post_title'   => almicahealing_import_line( $row['client_name'] ),
				'post_name'    => $slug,
				'post_content' => almicahealing_import_rich( $row['quote'] ),
				'post_status'  => 'publish',
				'menu_order'   => (int) $row['order'],
			)
		);

		$about_slug = almicahealing_import_line( $row['about_slug'] );
		$about_type = almicahealing_import_line( $row['about_type'] );

		if ( '' !== $about_slug ) {
			$pool  = ( 'curso' === $about_type ) ? $ids['curso'] : $ids['servicio'];
			$about = $pool[ $about_slug ] ?? 0;

			if ( $about ) {
				almicahealing_seed_field( 'about', $about, $post_id );
			}
		}

		++$counts['testimonios'];
	}

	// 8. ajustes.
	foreach ( $data['ajustes'] as $row ) {
		$key = almicahealing_import_line( $row['key'] );

		if ( function_exists( 'update_field' ) ) {
			update_field( $key, trim( (string) $row['value'] ), 'option' );
		}

		++$counts['ajustes'];
	}

	// 9. paginas.
	$counts['paginas'] = almicahealing_import_pages( $data['paginas'], $report );

	return $counts;
}

/**
 * Sets a post's featured image from a file name already in the media
 * library. The importer never uploads: the sheet only carries names, and
 * the files arrive separately.
 *
 * @param int                         $post_id  Post to set the image on.
 * @param string                      $filename File name from the sheet.
 * @param string                      $sheet    Sheet name, for the warning.
 * @param int                         $row      Row number, for the warning.
 * @param Almicahealing_Import_Report $report   Collector.
 */
function almicahealing_import_set_thumbnail( $post_id, $filename, $sheet, $row, Almicahealing_Import_Report $report ) {
	$filename = almicahealing_import_line( $filename );

	if ( '' === $filename ) {
		return;
	}

	$attachment = almicahealing_import_attachment( $filename );

	if ( $attachment ) {
		set_post_thumbnail( $post_id, $attachment );
		return;
	}

	// Don't clear an image that's already there just because the named
	// file hasn't been uploaded yet.
	if ( ! has_post_thumbnail( $post_id ) ) {
		$report->warn( $sheet, $row, sprintf( 'la imagen «%s» no está en la biblioteca de medios; se dejó sin imagen.', $filename ) );
	}
}

/**
 * Writes the `paginas` sheet onto the page each row names.
 *
 * @param array                       $rows   Rows from the sheet.
 * @param Almicahealing_Import_Report $report Collector.
 * @return int Number of values written.
 */
function almicahealing_import_pages( array $rows, Almicahealing_Import_Report $report ) {
	$map     = almicahealing_import_page_map();
	$written = 0;
	$steps   = array();
	$pages   = array();

	foreach ( $rows as $row ) {
		$pagina = almicahealing_import_line( $row['pagina'] );
		$campo  = almicahealing_import_line( $row['campo'] );
		$texto  = almicahealing_import_rich( $row['texto'] );
		$key    = "{$pagina}|{$campo}";

		if ( ! isset( $map[ $key ] ) ) {
			$report->warn( 'paginas', $row['__row'], sprintf( '«%s / %s» no corresponde a ningún campo del sitio; se omitió.', $pagina, $campo ) );
			continue;
		}

		list( $slug, $kind, $target ) = $map[ $key ];

		if ( ! isset( $pages[ $slug ] ) ) {
			$page = get_page_by_path( $slug );

			if ( ! $page ) {
				$report->warn( 'paginas', $row['__row'], sprintf( 'la página «%s» no existe todavía; se omitió.', $slug ) );
				continue;
			}

			$pages[ $slug ] = $page->ID;
		}

		$page_id = $pages[ $slug ];

		if ( 'content' === $kind ) {
			wp_update_post(
				array(
					'ID'           => $page_id,
					'post_content' => $texto,
				)
			);
			++$written;
			continue;
		}

		if ( 'step' === $kind ) {
			list( $index, $sub )           = explode( '/', $target );
			$steps[ (int) $index ][ $sub ] = $texto;
			++$written;
			continue;
		}

		if ( 'group' === $kind ) {
			list( $group, $sub ) = explode( '/', $target );

			$current = almicahealing_field( $group, $page_id, array() );
			$current = is_array( $current ) ? $current : array();

			$current[ $sub ] = $texto;

			almicahealing_seed_field( $group, $current, $page_id );
			++$written;
			continue;
		}

		almicahealing_seed_field( $target, $texto, $page_id );
		++$written;
	}

	if ( $steps && isset( $pages['inicio'] ) ) {
		ksort( $steps );
		almicahealing_seed_field( 'process_steps', array_values( $steps ), $pages['inicio'] );
	}

	return $written;
}

/**
 * Runs the import.
 *
 * ## OPTIONS
 *
 * <archivo>
 * : Ruta al archivo .xlsx.
 *
 * [--dry-run]
 * : Sólo valida y muestra el reporte; no escribe nada.
 *
 * @param array $args       Positional args.
 * @param array $assoc_args Flags.
 */
function almicahealing_import_run( $args, $assoc_args ) {
	$path    = $args[0];
	$dry_run = isset( $assoc_args['dry-run'] );

	if ( ! function_exists( 'update_field' ) ) {
		WP_CLI::error( 'Secure Custom Fields no está activo: sin él no se pueden escribir los campos.' );
	}

	try {
		$reader = new Almicahealing_Xlsx_Reader( $path );
	} catch ( RuntimeException $e ) {
		WP_CLI::error( $e->getMessage() );
		return;
	}

	$sheets = $reader->sheet_map();
	$report = new Almicahealing_Import_Report();
	$data   = array();

	foreach ( ALMICAHEALING_IMPORT_SCHEMA as $name => $columns ) {
		if ( ! isset( $sheets[ $name ] ) ) {
			$report->error( $name, 0, 'falta esta pestaña en el archivo.' );
			$data[ $name ] = array();
			continue;
		}

		$sheet   = $reader->read_sheet( $sheets[ $name ] );
		$missing = array_diff( $columns, $sheet['headers'] );

		foreach ( $missing as $column ) {
			$report->error( $name, 0, sprintf( 'falta la columna «%s».', $column ) );
		}

		$data[ $name ] = $sheet['rows'];
	}

	$reader->close();

	if ( ! $report->errors ) {
		almicahealing_import_validate( $data, $report );
	}

	foreach ( $report->warnings as $warning ) {
		WP_CLI::log( WP_CLI::colorize( '%yAviso:%n ' ) . $warning );
	}

	if ( $report->errors ) {
		WP_CLI::log( '' );

		foreach ( $report->errors as $error ) {
			WP_CLI::log( WP_CLI::colorize( '%rError:%n ' ) . $error );
		}

		WP_CLI::error(
			sprintf(
				'%d error(es). No se importó nada: corrige el archivo y vuelve a ejecutar.',
				count( $report->errors )
			)
		);
		return;
	}

	if ( $dry_run ) {
		WP_CLI::success(
			sprintf(
				'Validación correcta (%d aviso(s)). No se escribió nada porque es --dry-run.',
				count( $report->warnings )
			)
		);
		return;
	}

	$before = count( $report->warnings );
	$counts = almicahealing_import_write( $data, $report );

	foreach ( array_slice( $report->warnings, $before ) as $warning ) {
		WP_CLI::log( WP_CLI::colorize( '%yAviso:%n ' ) . $warning );
	}

	WP_CLI::log( '' );

	foreach ( $counts as $name => $count ) {
		WP_CLI::log( sprintf( '  %-24s %d', $name, $count ) );
	}

	WP_CLI::success( 'Importación completa.' );
}

WP_CLI::add_command(
	'almicahealing import',
	'almicahealing_import_run',
	array(
		'shortdesc' => 'Importa el libro de contenido (.xlsx) del equipo de copy.',
		'synopsis'  => array(
			array(
				'type'        => 'positional',
				'name'        => 'archivo',
				'description' => 'Ruta al archivo .xlsx.',
			),
			array(
				'type'        => 'flag',
				'name'        => 'dry-run',
				'description' => 'Sólo valida; no escribe nada.',
				'optional'    => true,
			),
		),
	)
);

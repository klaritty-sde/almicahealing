<?php
/**
 * `wp almicahealing seed-fields` — seeds the `profesional` posts and the
 * structured field data transcribed from the Figma frames, and migrates
 * the meta the earlier implementation used.
 *
 * Split from seed.php because this half depends on Secure Custom Fields
 * being active, while the base seeder (posts, pages, menus) does not.
 *
 * Safe to re-run: posts are matched by `_almicahealing_seed_key` exactly
 * as in seed.php, and field writes are idempotent.
 *
 * Usage: wp almicahealing seed-fields
 *
 * @package AlmicaHealingCore
 */

defined( 'ABSPATH' ) || exit;

if ( ! defined( 'WP_CLI' ) || ! WP_CLI ) {
	return;
}

/**
 * Finds a seeded post by its stable seed key.
 *
 * @param string $seed_key  Seed key, e.g. 'servicio-arteterapia'.
 * @param string $post_type Post type to search.
 * @return int Post ID, or 0 when it hasn't been seeded yet.
 */
function almicahealing_seeded_id( $seed_key, $post_type ) {
	$found = get_posts(
		array(
			'post_type'      => $post_type,
			'post_status'    => 'any',
			'posts_per_page' => 1,
			'meta_key'       => '_almicahealing_seed_key',
			'meta_value'     => $seed_key,
			'fields'         => 'ids',
		)
	);

	return $found ? (int) $found[0] : 0;
}

/**
 * Writes a field through SCF when available, falling back to plain post
 * meta so the seeder still does something useful without the plugin.
 *
 * @param string $name    Field name.
 * @param mixed  $value   Value.
 * @param int    $post_id Post to write to.
 */
function almicahealing_seed_field( $name, $value, $post_id ) {
	if ( function_exists( 'update_field' ) ) {
		update_field( $name, $value, $post_id );
		return;
	}

	update_post_meta( $post_id, $name, $value );
}

/**
 * Seeds the four professionals named in the design.
 *
 * Perla Berrones is deliberately absent: she appears on one frame with
 * another therapist's photo and bio, so decision D4 leaves that service
 * without a professional rather than seeding bad data.
 *
 * @return array<string,int> Seed key suffix => post ID.
 */
function almicahealing_seed_profesionales() {
	$profesionales = array(
		'alma-solis'             => array(
			'name'        => 'Alma Solís',
			'role'        => 'Fundadora y Directora',
			'order'       => 1,
			'image'       => get_template_directory() . '/assets/img/acerca-de-fundadora.jpg',
			'bio'         => "Alma Solís es una profesional comprometida con el desarrollo humano y el bienestar integral de las personas. Inició su formación académica en Ciencias de la Comunicación, disciplina que le permitió desarrollar una comprensión profunda de los procesos de interacción y expresión humana. En paralelo, comenzó su preparación como Consteladora Familiar, lo que despertó en ella un interés creciente por el acompañamiento terapéutico y el crecimiento personal.\n\nImpulsada por su vocación de servicio, cursó la Licenciatura en Psicología y continuó su especialización con una Maestría en Psicología Clínica y de la Salud. Su formación se ha enriquecido además con estudios complementarios en Bioneuroemoción con Enric Corbera, Canalización y Defensa Psíquica con Sol Ahimsa, y el programa Sana Tu Alma impartido por Abril Méndez.\n\nA lo largo de varios años de consulta privada, Alma ha acompañado a personas en procesos de transformación personal, autoconocimiento y fortalecimiento emocional, integrando herramientas psicológicas y sistémicas. Su trabajo se distingue por una visión humana, ética e integral, orientada a generar espacios seguros que favorezcan el desarrollo de recursos internos y la construcción de una vida con mayor equilibrio y plenitud.",
			'credentials' => array(
				array(
					'title'       => 'Especialidad en Constelaciones Familiares',
					'year'        => 2021,
					'institution' => 'Instituto de Constelaciones Familiares de Monterrey',
					'description' => 'Con un enfoque en dinámicas familiares, esta especialidad ayuda a identificar en el presente, tanto en sesiones grupales como individuales y de pareja, los patrones disfuncionales y guiar hacia soluciones mediante el acceso al inconsciente para sanar y liberar emociones bloqueadas.',
				),
				array(
					'title'       => 'Canalización con Guías y seres Espirituales',
					'year'        => 2024,
					'institution' => 'Escuela Sol Ahimsa',
					'description' => 'Como canalizadora espiritual identificas mensajes auténticos para expandir la conciencia hacia dimensiones superiores que disminuyen el ruido mental y conectan con la luz interior para ayudar a otros. Así como mantener el estado de trance, bloqueando los propios pensamientos y solicitar la conexión con el guía.',
				),
				array(
					'title'       => 'Limpieza Energética y Autodefensa Psíquica',
					'year'        => 2024,
					'institution' => 'Paduka con la Astrología Paola Michel',
					'description' => 'Esta formación permite fortalecer el sistema energético y conectar con la luz interior. Explora técnicas de visualización guiada y generación de energía renovada para equilibrar el campo áurico, junto con técnicas de limpieza energética y autodefensa psíquica.',
				),
			),
		),
		'elizabeth-de-las-casas' => array(
			'name'        => 'Elizabeth de las Casas',
			'role'        => 'Arte Terapeuta Antroposófica',
			'order'       => 2,
			'image'       => '',
			'bio'         => "Elizabeth estudió Psicología y Arte, y es Arte Terapeuta Antroposófica por la escuela El Puente, en Barcelona, España. Es también Educadora Waldorf del primer septenio, Terapeuta en Polaridad y Craneosacral, y Terapeuta Floral certificada por CRISOL. Nació en la Ciudad de México y actualmente vive en Coatepec, Veracruz; su formación se ha enriquecido con maestros de India, Nepal, Inglaterra, Canadá, España y México.\n\nEs fundadora de El Arrullo, casa para la Antroposofía, A.C., y coordinadora del grupo de Arte Terapia Antroposófica de Hispanoamérica. Desde hace más de veinte años acompaña procesos de desarrollo humano y crecimiento personal a través de cursos, talleres y terapias grupales e individuales en México, Chile y Brasil. Practicante de budismo, Qi Gong y Chi Kung, mantiene una búsqueda constante por reconocer y expresar su propia verdad, acompañando a otros en el camino hacia su encuentro.",
			'credentials' => array(),
		),
		'gabriela-dominguez'     => array(
			'name'        => 'Gabriela Domínguez',
			'role'        => 'Terapeuta Holística',
			'order'       => 3,
			'image'       => '',
			'bio'         => '',
			'credentials' => array(),
		),
		'tonathiu-munoz'         => array(
			'name'        => 'Tonathiu Muñoz',
			'role'        => 'Acompañante Terapéutico',
			'order'       => 4,
			'image'       => '',
			'bio'         => '',
			'credentials' => array(),
		),
	);

	$ids = array();

	foreach ( $profesionales as $key => $pro ) {
		$post_id = almicahealing_seed_post(
			"profesional-{$key}",
			array(
				'post_type'    => 'profesional',
				'post_title'   => $pro['name'],
				'post_name'    => $key,
				'post_content' => $pro['bio'],
				'post_status'  => 'publish',
				'menu_order'   => $pro['order'],
			)
		);

		almicahealing_seed_field( 'role', $pro['role'], $post_id );

		if ( $pro['credentials'] ) {
			almicahealing_seed_field( 'credentials', $pro['credentials'], $post_id );
		}

		if ( $pro['image'] ) {
			almicahealing_seed_thumbnail( $post_id, $pro['image'], $pro['name'] );
		}

		$ids[ $key ] = $post_id;
	}

	return $ids;
}

/**
 * Seeds the reference service instance, Arteterapia (Figma frame 10).
 *
 * @param array<string,int> $pros Professional IDs by slug.
 */
function almicahealing_seed_servicio_fields( array $pros ) {
	$arteterapia = almicahealing_seeded_id( 'servicio-arteterapia', 'servicio' );

	if ( ! $arteterapia ) {
		WP_CLI::warning( 'Arteterapia not found — run `wp almicahealing seed` first.' );
		return;
	}

	wp_update_post(
		array(
			'ID'           => $arteterapia,
			'post_excerpt' => 'Un puente hacia lo que no siempre encuentra palabras, a través de la creación artística.',
			'post_content' => "Es una forma distinta de acceder a lo que no siempre encuentra palabras. A través de técnicas como el dibujo, la pintura, el collage y el modelado, este proceso permite explorar emociones, pensamientos y experiencias personales desde la expresión simbólica. El arte se convierte en un puente hacia aspectos internos que, en ocasiones, resultan difíciles de nombrar directamente.\n\nA través de diversas técnicas creativas como dibujo, pintura, collage, modelado y expresión simbólica, la persona puede acceder a aspectos profundos de sí misma que a veces son difíciles de expresar con palabras.",
		)
	);

	almicahealing_seed_field( 'price', 850, $arteterapia );
	almicahealing_seed_field( 'duration_minutes', 60, $arteterapia );
	almicahealing_seed_field( 'modality', 'presencial', $arteterapia );
	almicahealing_seed_field( 'is_featured', 1, $arteterapia );
	almicahealing_seed_field(
		'benefits',
		array(
			array(
				'icon'        => 'corazon',
				'title'       => 'Favorece la expresión emocional',
				'description' => 'Da forma a lo que resulta difícil de nombrar directamente.',
			),
			array(
				'icon'        => 'ondas',
				'title'       => 'Reduce el estrés y la ansiedad',
				'description' => 'El proceso creativo ofrece un espacio de calma y descarga.',
			),
			array(
				'icon'        => 'brote',
				'title'       => 'Incrementa el autoconocimiento',
				'description' => 'Revela patrones y emociones desde la simbología del arte.',
			),
			array(
				'icon'        => 'chispa',
				'title'       => 'Fortalece la autoestima',
				'description' => 'Reconecta con la capacidad propia de crear y expresarse.',
			),
			array(
				'icon'        => 'manos',
				'title'       => 'Facilita procesos de duelo y sanación emocional',
				'description' => 'Acompaña con delicadeza momentos de pérdida o transición.',
			),
		),
		$arteterapia
	);

	if ( ! empty( $pros['elizabeth-de-las-casas'] ) ) {
		almicahealing_seed_field( 'professionals', array( $pros['elizabeth-de-las-casas'] ), $arteterapia );
	}

	WP_CLI::log( 'Seeded Arteterapia (reference service instance).' );
}

/**
 * Seeds the reference course instance, Clantanra (Figma frame 5): the
 * "price on request" variation, which hides the Inversión card.
 *
 * @param array<string,int> $pros Professional IDs by slug.
 */
function almicahealing_seed_curso_fields( array $pros ) {
	$clantanra = almicahealing_seeded_id( 'curso-clantanra', 'curso' );

	if ( ! $clantanra ) {
		WP_CLI::warning( 'Clantanra not found — run `wp almicahealing seed` first.' );
		return;
	}

	wp_update_post(
		array(
			'ID'           => $clantanra,
			'post_excerpt' => 'Un programa enfocado en el desarrollo del autoconocimiento profundo y la conexión con el propósito personal.',
			'post_content' => "Un programa enfocado en el desarrollo del autoconocimiento profundo y la conexión con el propósito personal, que integra herramientas de crecimiento interior y técnicas de sanación.\n\nSe exploran herramientas de crecimiento interior que permiten integrar aprendizajes profundos y aplicarlos en la vida cotidiana, así como técnicas de limpieza y sanación dirigidas a personas, lugares, objetos, animales y plantas. Un programa de alta conexión interior, pensado para quienes buscan ampliar su percepción e intuición.",
		)
	);

	almicahealing_seed_field( 'tagline', 'Un programa de alta conexión interior para quienes buscan ampliar su percepción e intuición.', $clantanra );
	almicahealing_seed_field( 'program_label', 'Curso intermedio de canalización y sanación', $clantanra );
	almicahealing_seed_field( 'level', 'intermedio', $clantanra );
	almicahealing_seed_field( 'outcomes_heading', 'objetivos', $clantanra );
	almicahealing_seed_field(
		'outcomes',
		array(
			array( 'text' => 'Fortalecer la conexión interior.' ),
			array( 'text' => 'Comprender procesos energéticos.' ),
			array( 'text' => 'Sentar bases teóricas y prácticas para la sanación y la conexión.' ),
			array( 'text' => 'Desarrollar herramientas prácticas para el bienestar integral.' ),
			array( 'text' => 'Integrar aprendizajes de limpieza y sanación hacia personas, lugares, objetos, animales y plantas.' ),
		),
		$clantanra
	);

	if ( ! empty( $pros['alma-solis'] ) ) {
		almicahealing_seed_field( 'facilitators', array( $pros['alma-solis'] ), $clantanra );
	}

	// The other two courses: their headings and pricing differ, which is
	// exactly the variation the shared template has to absorb.
	$others = array(
		'curso-riutunmi'                => array(
			'tagline'          => 'Un espacio de formación para el desarrollo de la conciencia y la conexión con dimensiones más profundas del ser.',
			'program_label'    => 'Curso básico de canalización',
			'level'            => 'basico',
			'price'            => 5900,
			'duration'         => '2 meses',
			'outcomes_heading' => 'beneficios',
		),
		'curso-lo-que-nadie-nos-enseno' => array(
			'tagline'          => 'Herramientas prácticas para afrontar los desafíos cotidianos con mayor conciencia y equilibrio.',
			'program_label'    => 'Curso básico de canalización',
			'level'            => 'abierto',
			'price'            => 4700,
			'duration'         => '3 meses',
			'outcomes_heading' => 'temas',
		),
	);

	foreach ( $others as $seed_key => $fields ) {
		$curso_id = almicahealing_seeded_id( $seed_key, 'curso' );

		if ( ! $curso_id ) {
			continue;
		}

		foreach ( $fields as $name => $value ) {
			almicahealing_seed_field( $name, $value, $curso_id );
		}

		if ( ! empty( $pros['alma-solis'] ) ) {
			almicahealing_seed_field( 'facilitators', array( $pros['alma-solis'] ), $curso_id );
		}
	}

	WP_CLI::log( 'Seeded Clantanra (reference course instance) and the other two courses.' );
}

/**
 * Migrates the meta the first implementation used onto the new fields.
 *
 * - `_almicahealing_featured` → `is_featured`
 * - `testimonio.post_excerpt` (free text) → `about` (a real relationship)
 */
function almicahealing_migrate_legacy_meta() {
	$migrated = 0;

	foreach ( get_posts(
		array(
			'post_type'      => 'servicio',
			'posts_per_page' => -1,
			'post_status'    => 'any',
			'fields'         => 'ids',
		)
	) as $servicio_id ) {
		$legacy = get_post_meta( $servicio_id, '_almicahealing_featured', true );

		if ( '' === $legacy ) {
			continue;
		}

		almicahealing_seed_field( 'is_featured', '1' === $legacy ? 1 : 0, $servicio_id );
		++$migrated;
	}

	WP_CLI::log( "Migrated _almicahealing_featured on {$migrated} services." );

	// The testimonial label was a free-text excerpt that drifts when a
	// service is renamed; point it at the actual post instead.
	$relinked = 0;

	foreach ( get_posts(
		array(
			'post_type'      => 'testimonio',
			'posts_per_page' => -1,
			'post_status'    => 'any',
			'fields'         => 'ids',
		)
	) as $testimonio_id ) {
		$label = get_post_field( 'post_excerpt', $testimonio_id );

		if ( ! $label ) {
			continue;
		}

		$match = get_posts(
			array(
				'post_type'      => array( 'servicio', 'curso' ),
				'posts_per_page' => 1,
				'title'          => $label,
				'fields'         => 'ids',
			)
		);

		if ( ! $match ) {
			WP_CLI::warning( "Testimonio {$testimonio_id}: no servicio/curso titled \"{$label}\" — left unlinked." );
			continue;
		}

		almicahealing_seed_field( 'about', (int) $match[0], $testimonio_id );
		++$relinked;
	}

	WP_CLI::log( "Linked {$relinked} testimonials to a service or course." );
}


/**
 * Repoints the menus at the pages that now exist (KW-116).
 *
 * The base seeder only fills a menu location when it's empty, so it
 * never touches menus that already have items — this migration makes
 * the one correction phase 1 needs: "Cursos" moves from the Home anchor
 * to the real Cursos page. The legal links are not added here — the
 * footer template renders its own "Legal" column from the pages — and
 * Tienda and Contáctanos stay out, both deferred.
 */
function almicahealing_migrate_menus() {
	$cursos = get_page_by_path( 'cursos' );

	if ( ! $cursos ) {
		return;
	}

	foreach ( array( 'primary', 'footer' ) as $location ) {
		$locations = get_nav_menu_locations();

		if ( empty( $locations[ $location ] ) ) {
			continue;
		}

		$menu_id = $locations[ $location ];
		$items   = wp_get_nav_menu_items( $menu_id );

		if ( ! $items ) {
			continue;
		}

		foreach ( $items as $item ) {
			// The old item was a custom link to /#cursos.
			if ( 'custom' !== $item->type || 'Cursos' !== $item->title ) {
				continue;
			}

			wp_update_nav_menu_item(
				$menu_id,
				$item->ID,
				array(
					'menu-item-title'     => 'Cursos',
					'menu-item-object'    => 'page',
					'menu-item-object-id' => $cursos->ID,
					'menu-item-type'      => 'post_type',
					'menu-item-status'    => 'publish',
				)
			);

			WP_CLI::log( "Repointed the \"Cursos\" item in the {$location} menu at the Cursos page." );
		}
	}
}

/**
 * Runs the field seed.
 */
function almicahealing_seed_fields_run() {
	if ( ! function_exists( 'update_field' ) ) {
		WP_CLI::warning( 'Secure Custom Fields is not active — writing plain post meta, which the repeater fields cannot round-trip.' );
	}

	$pros = almicahealing_seed_profesionales();
	WP_CLI::log( 'Seeded ' . count( $pros ) . ' profesionales.' );

	// Acerca de renders the founder's bio, portrait and "Formación" from
	// this one link rather than its own copy of them.
	$acerca_de = get_page_by_path( 'acerca-de' );

	if ( $acerca_de && ! empty( $pros['alma-solis'] ) ) {
		almicahealing_seed_field( 'founder', $pros['alma-solis'], $acerca_de->ID );
		WP_CLI::log( 'Linked Alma Solís as the founder on Acerca de.' );
	}

	almicahealing_seed_servicio_fields( $pros );
	almicahealing_seed_curso_fields( $pros );
	almicahealing_migrate_legacy_meta();
	almicahealing_migrate_menus();

	WP_CLI::success( 'Field seed complete.' );
}

WP_CLI::add_command( 'almicahealing seed-fields', 'almicahealing_seed_fields_run' );

<?php
/**
 * Admin record ("Contactos") of every contact-form submission, plus a
 * CSV export and a retention cron — the leads CPT stores names/emails/
 * phones, so it shouldn't accumulate forever.
 *
 * @package AlmicaHealingCore
 */

defined( 'ABSPATH' ) || exit;

const ALMICAHEALING_LEADS_RETENTION_MONTHS = 18;

// WordPress caps post type names at 20 characters — "almicahealing_contacto" (22) doesn't fit.
const ALMICAHEALING_LEADS_POST_TYPE = 'almica_contacto';

/**
 * Registers the leads post type (see ALMICAHEALING_LEADS_POST_TYPE for why
 * it isn't `almicahealing_contacto`).
 */
function almicahealing_register_leads_post_type() {
	register_post_type(
		ALMICAHEALING_LEADS_POST_TYPE,
		array(
			'labels'          => array(
				'name'               => __( 'Contactos', 'almicahealing' ),
				'singular_name'      => __( 'Contacto', 'almicahealing' ),
				'all_items'          => __( 'Todos los contactos', 'almicahealing' ),
				'edit_item'          => __( 'Contacto', 'almicahealing' ),
				'search_items'       => __( 'Buscar contactos', 'almicahealing' ),
				'not_found'          => __( 'Todavía no hay contactos.', 'almicahealing' ),
				'not_found_in_trash' => __( 'No hay contactos en la papelera.', 'almicahealing' ),
			),
			'public'          => false,
			'show_ui'         => true,
			'menu_position'   => 26,
			'menu_icon'       => 'dashicons-email-alt',
			'supports'        => array( 'title' ),
			'capability_type' => 'page',
			'map_meta_cap'    => true,
			'capabilities'    => array( 'create_posts' => 'do_not_allow' ),
		)
	);
}
add_action( 'init', 'almicahealing_register_leads_post_type' );

/**
 * Saves a submission as a "Contactos" entry.
 *
 * @param array $data Validated form data.
 * @return bool
 */
function almicahealing_contact_save_lead( array $data ) {
	$post_id = wp_insert_post(
		wp_slash(
			array(
				'post_type'   => ALMICAHEALING_LEADS_POST_TYPE,
				'post_status' => 'publish',
				'post_title'  => $data['nombre'] . ' — ' . $data['email'],
				'meta_input'  => array( '_almicahealing_contacto' => $data ),
			)
		),
		true
	);

	return ! is_wp_error( $post_id );
}

/**
 * Registers the meta box showing a lead's submitted data.
 */
function almicahealing_leads_add_meta_box() {
	add_meta_box(
		'almicahealing-contacto-datos',
		__( 'Datos del contacto', 'almicahealing' ),
		'almicahealing_leads_render_meta_box',
		ALMICAHEALING_LEADS_POST_TYPE,
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes_' . ALMICAHEALING_LEADS_POST_TYPE, 'almicahealing_leads_add_meta_box' );

/**
 * Renders the lead-data meta box.
 *
 * @param WP_Post $post The lead being edited.
 */
function almicahealing_leads_render_meta_box( $post ) {
	$data = get_post_meta( $post->ID, '_almicahealing_contacto', true );
	if ( ! is_array( $data ) ) {
		return;
	}

	echo '<table class="widefat striped"><tbody>';
	foreach ( almicahealing_contact_display_values( $data ) as $label => $value ) {
		printf(
			'<tr><th scope="row" style="width:30%%;">%1$s</th><td>%2$s</td></tr>',
			esc_html( $label ),
			nl2br( esc_html( $value ) )
		);
	}
	echo '</tbody></table>';
}

/**
 * Adds email/phone columns to the leads list table.
 *
 * @param array $columns Existing columns.
 * @return array
 */
function almicahealing_leads_admin_columns( $columns ) {
	return array(
		'cb'       => $columns['cb'],
		'title'    => __( 'Contacto', 'almicahealing' ),
		'email'    => __( 'Correo', 'almicahealing' ),
		'telefono' => __( 'Teléfono', 'almicahealing' ),
		'date'     => $columns['date'],
	);
}
add_filter( 'manage_' . ALMICAHEALING_LEADS_POST_TYPE . '_posts_columns', 'almicahealing_leads_admin_columns' );

/**
 * Renders the email/phone list-table columns.
 *
 * @param string $column  Column key.
 * @param int    $post_id Lead post ID.
 */
function almicahealing_leads_admin_column_content( $column, $post_id ) {
	$data = get_post_meta( $post_id, '_almicahealing_contacto', true );
	if ( ! is_array( $data ) || empty( $data[ $column ] ) ) {
		return;
	}

	if ( 'email' === $column ) {
		printf( '<a href="%1$s">%2$s</a>', esc_url( 'mailto:' . $data['email'] ), esc_html( $data['email'] ) );
	} elseif ( 'telefono' === $column ) {
		echo esc_html( $data['telefono'] );
	}
}
add_action( 'manage_' . ALMICAHEALING_LEADS_POST_TYPE . '_posts_custom_column', 'almicahealing_leads_admin_column_content', 10, 2 );

/**
 * Adds an "Exportar CSV" button above the leads list table.
 */
function almicahealing_leads_export_button() {
	$screen = get_current_screen();
	if ( ! $screen || ALMICAHEALING_LEADS_POST_TYPE !== $screen->post_type || 'edit' !== $screen->base ) {
		return;
	}

	$url = wp_nonce_url( admin_url( 'admin-post.php?action=almicahealing_export_leads' ), 'almicahealing_export_leads' );
	printf( '<a href="%s" class="page-title-action">%s</a>', esc_url( $url ), esc_html__( 'Exportar CSV', 'almicahealing' ) );
}
add_action( 'admin_notices', 'almicahealing_leads_export_button' );

/**
 * Streams all leads as a CSV download.
 */
function almicahealing_export_leads() {
	if ( ! current_user_can( 'edit_posts' ) || ! check_admin_referer( 'almicahealing_export_leads' ) ) {
		wp_die( esc_html__( 'No autorizado.', 'almicahealing' ), '', array( 'response' => 403 ) );
	}

	$fields = almicahealing_contact_fields();
	$leads  = get_posts(
		array(
			'post_type'      => ALMICAHEALING_LEADS_POST_TYPE,
			'posts_per_page' => -1,
			'orderby'        => 'date',
			'order'          => 'DESC',
		)
	);

	nocache_headers();
	header( 'Content-Type: text/csv; charset=utf-8' );
	header( 'Content-Disposition: attachment; filename=almicahealing-contactos.csv' );

	$out = fopen( 'php://output', 'w' );
	fputcsv( $out, array_merge( array( 'Fecha' ), wp_list_pluck( $fields, 'label' ) ) );

	foreach ( $leads as $lead ) {
		$data = get_post_meta( $lead->ID, '_almicahealing_contacto', true );
		$row  = array( get_the_date( 'Y-m-d H:i', $lead ) );
		foreach ( array_keys( $fields ) as $key ) {
			$row[] = is_array( $data ) ? ( $data[ $key ] ?? '' ) : '';
		}
		fputcsv( $out, $row );
	}

	fclose( $out ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_operations_fclose -- streaming a CSV directly to php://output; WP_Filesystem doesn't support that.
	exit;
}
add_action( 'admin_post_almicahealing_export_leads', 'almicahealing_export_leads' );

/**
 * Trashes leads older than the retention window (privacy: the CPT stores
 * names, emails and phone numbers).
 */
function almicahealing_prune_old_leads() {
	$old_leads = get_posts(
		array(
			'post_type'      => ALMICAHEALING_LEADS_POST_TYPE,
			'posts_per_page' => -1,
			'fields'         => 'ids',
			'date_query'     => array(
				array(
					'before' => '-' . ALMICAHEALING_LEADS_RETENTION_MONTHS . ' months',
				),
			),
		)
	);

	foreach ( $old_leads as $lead_id ) {
		wp_trash_post( $lead_id );
	}
}
add_action( 'almicahealing_prune_leads', 'almicahealing_prune_old_leads' );

/**
 * Schedules the retention cron on plugin activation.
 */
function almicahealing_schedule_leads_pruning() {
	if ( ! wp_next_scheduled( 'almicahealing_prune_leads' ) ) {
		wp_schedule_event( time(), 'weekly', 'almicahealing_prune_leads' );
	}
}
register_activation_hook( ALMICAHEALING_CORE_DIR . 'almicahealing-core.php', 'almicahealing_schedule_leads_pruning' );

/**
 * Clears the retention cron on plugin deactivation.
 */
function almicahealing_unschedule_leads_pruning() {
	wp_clear_scheduled_hook( 'almicahealing_prune_leads' );
}
register_deactivation_hook( ALMICAHEALING_CORE_DIR . 'almicahealing-core.php', 'almicahealing_unschedule_leads_pruning' );

<?php

/**
 * Registers the `poi` post type.
 */
function poi_init() {
	register_post_type(
		'poi',
		[
			'labels'                => [
				'name'                  => __( 'Points of interest', 'ojapon_plugin' ),
				'singular_name'         => __( 'Point of interest', 'ojapon_plugin' ),
				'all_items'             => __( 'All Points of interest', 'ojapon_plugin' ),
				'archives'              => __( 'Point of interest Archives', 'ojapon_plugin' ),
				'attributes'            => __( 'Point of interest Attributes', 'ojapon_plugin' ),
				'insert_into_item'      => __( 'Insert into Point of interest', 'ojapon_plugin' ),
				'uploaded_to_this_item' => __( 'Uploaded to this Point of interest', 'ojapon_plugin' ),
				'featured_image'        => _x( 'Featured Image', 'poi', 'ojapon_plugin' ),
				'set_featured_image'    => _x( 'Set featured image', 'poi', 'ojapon_plugin' ),
				'remove_featured_image' => _x( 'Remove featured image', 'poi', 'ojapon_plugin' ),
				'use_featured_image'    => _x( 'Use as featured image', 'poi', 'ojapon_plugin' ),
				'filter_items_list'     => __( 'Filter Points of interest list', 'ojapon_plugin' ),
				'items_list_navigation' => __( 'Points of interest list navigation', 'ojapon_plugin' ),
				'items_list'            => __( 'Points of interest list', 'ojapon_plugin' ),
				'new_item'              => __( 'New Point of interest', 'ojapon_plugin' ),
				'add_new'               => __( 'Add New', 'ojapon_plugin' ),
				'add_new_item'          => __( 'Add New Point of interest', 'ojapon_plugin' ),
				'edit_item'             => __( 'Edit Point of interest', 'ojapon_plugin' ),
				'view_item'             => __( 'View Point of interest', 'ojapon_plugin' ),
				'view_items'            => __( 'View Points of interest', 'ojapon_plugin' ),
				'search_items'          => __( 'Search Points of interest', 'ojapon_plugin' ),
				'not_found'             => __( 'No Points of interest found', 'ojapon_plugin' ),
				'not_found_in_trash'    => __( 'No Points of interest found in trash', 'ojapon_plugin' ),
				'parent_item_colon'     => __( 'Parent Point of interest:', 'ojapon_plugin' ),
				'menu_name'             => __( 'Points of interest', 'ojapon_plugin' ),
			],
			'public'                => true,
			'hierarchical'          => false,
			'show_ui'               => true,
			'show_in_menu'			=> true,
			'show_in_nav_menus'     => true,
			'supports'              => [ 'title', 'editor', 'thumbnail', 'comments' ],
			// adding custom capabilities to map with custom user role
			//'capability_type'		=> array ( 'poi', 'pois' ),
			'capabilities'			=> array(
				'read_post'				=> 'read_poi',
				'read_private_posts'	=> 'read_private_pois',
				'edit_post'          	=> 'edit_poi',
				'edit_posts'         	=> 'edit_pois',
				'create_posts'       	=> 'edit_pois',
				'edit_others_posts'		=> 'edit_others_pois',
				'edit_published_posts'	=> 'edit_published_pois',
				'publish_posts'      	=> 'publish_pois',
				'delete_post'        	=> 'delete_poi', 
				'delete_others_posts' 	=> 'delete_others_pois',
				'delete_private_posts' 	=> 'delete_private_pois',
				'delete_published_posts' => 'delete_published_pois'
			),
			// mapping custom capabilities to WordPress’ primitive capabilities
			'map_meta_cap'			=> true,
			'has_archive'           => true,
			'rewrite'               => array( 'slug' => 'poi' ),
			'query_var'             => true,
			'menu_position'         => null,
			'menu_icon'             => 'dashicons-location',
			'show_in_rest'          => true,
			'rest_base'             => 'poi',
			'rest_controller_class' => 'WP_REST_Posts_Controller',
		]
	);

}

add_action( 'init', 'poi_init' );

/**
 * Sets the post updated messages for the `poi` post type.
 *
 * @param  array $messages Post updated messages.
 * @return array Messages for the `poi` post type.
 */
function poi_updated_messages( $messages ) {
	global $post;

	$permalink = get_permalink( $post );

	$messages['poi'] = [
		0  => '', // Unused. Messages start at index 1.
		/* translators: %s: post permalink */
		1  => sprintf( __( 'Point of interest updated. <a target="_blank" href="%s">View Point of interest</a>', 'ojapon_plugin' ), esc_url( $permalink ) ),
		2  => __( 'Custom field updated.', 'ojapon_plugin' ),
		3  => __( 'Custom field deleted.', 'ojapon_plugin' ),
		4  => __( 'Point of interest updated.', 'ojapon_plugin' ),
		/* translators: %s: date and time of the revision */
		5  => isset( $_GET['revision'] ) ? sprintf( __( 'Point of interest restored to revision from %s', 'ojapon_plugin' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false, // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		/* translators: %s: post permalink */
		6  => sprintf( __( 'Point of interest published. <a href="%s">View Point of interest</a>', 'ojapon_plugin' ), esc_url( $permalink ) ),
		7  => __( 'Point of interest saved.', 'ojapon_plugin' ),
		/* translators: %s: post permalink */
		8  => sprintf( __( 'Point of interest submitted. <a target="_blank" href="%s">Preview Point of interest</a>', 'ojapon_plugin' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
		/* translators: 1: Publish box date format, see https://secure.php.net/date 2: Post permalink */
		9  => sprintf( __( 'Point of interest scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Point of interest</a>', 'ojapon_plugin' ), date_i18n( __( 'M j, Y @ G:i', 'ojapon_plugin' ), strtotime( $post->post_date ) ), esc_url( $permalink ) ),
		/* translators: %s: post permalink */
		10 => sprintf( __( 'Point of interest draft updated. <a target="_blank" href="%s">Preview Point of interest</a>', 'ojapon_plugin' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
	];

	return $messages;
}

add_filter( 'post_updated_messages', 'poi_updated_messages' );

/**
 * Sets the bulk post updated messages for the `poi` post type.
 *
 * @param  array $bulk_messages Arrays of messages, each keyed by the corresponding post type. Messages are
 *                              keyed with 'updated', 'locked', 'deleted', 'trashed', and 'untrashed'.
 * @param  int[] $bulk_counts   Array of item counts for each message, used to build internationalized strings.
 * @return array Bulk messages for the `poi` post type.
 */
function poi_bulk_updated_messages( $bulk_messages, $bulk_counts ) {
	global $post;

	$bulk_messages['poi'] = [
		/* translators: %s: Number of Points of interest. */
		'updated'   => _n( '%s Point of interest updated.', '%s Points of interest updated.', $bulk_counts['updated'], 'ojapon_plugin' ),
		'locked'    => ( 1 === $bulk_counts['locked'] ) ? __( '1 Point of interest not updated, somebody is editing it.', 'ojapon_plugin' ) :
						/* translators: %s: Number of Points of interest. */
						_n( '%s Point of interest not updated, somebody is editing it.', '%s Points of interest not updated, somebody is editing them.', $bulk_counts['locked'], 'ojapon_plugin' ),
		/* translators: %s: Number of Points of interest. */
		'deleted'   => _n( '%s Point of interest permanently deleted.', '%s Points of interest permanently deleted.', $bulk_counts['deleted'], 'ojapon_plugin' ),
		/* translators: %s: Number of Points of interest. */
		'trashed'   => _n( '%s Point of interest moved to the Trash.', '%s Points of interest moved to the Trash.', $bulk_counts['trashed'], 'ojapon_plugin' ),
		/* translators: %s: Number of Points of interest. */
		'untrashed' => _n( '%s Point of interest restored from the Trash.', '%s Points of interest restored from the Trash.', $bulk_counts['untrashed'], 'ojapon_plugin' ),
	];

	return $bulk_messages;
}

add_filter( 'bulk_post_updated_messages', 'poi_bulk_updated_messages', 10, 2 );

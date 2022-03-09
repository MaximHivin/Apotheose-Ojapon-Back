<?php

/**
 * Registers the `travel_guide` post type.
 */
function travel_guide_init() {
	register_post_type(
		'travelguide',
		[
			'labels'                => [
				'name'                  => __( 'Travel Guides', 'ojapon_plugin' ),
				'singular_name'         => __( 'Travel Guide', 'ojapon_plugin' ),
				'all_items'             => __( 'All Travel Guides', 'ojapon_plugin' ),
				'archives'              => __( 'Travel Guide Archives', 'ojapon_plugin' ),
				'attributes'            => __( 'Travel Guide Attributes', 'ojapon_plugin' ),
				'insert_into_item'      => __( 'Insert into Travel Guide', 'ojapon_plugin' ),
				'uploaded_to_this_item' => __( 'Uploaded to this Travel Guide', 'ojapon_plugin' ),
				'featured_image'        => _x( 'Featured Image', 'travelguide', 'ojapon_plugin' ),
				'set_featured_image'    => _x( 'Set featured image', 'travelguide', 'ojapon_plugin' ),
				'remove_featured_image' => _x( 'Remove featured image', 'travelguide', 'ojapon_plugin' ),
				'use_featured_image'    => _x( 'Use as featured image', 'travelguide', 'ojapon_plugin' ),
				'filter_items_list'     => __( 'Filter Travel Guides list', 'ojapon_plugin' ),
				'items_list_navigation' => __( 'Travel Guides list navigation', 'ojapon_plugin' ),
				'items_list'            => __( 'Travel Guides list', 'ojapon_plugin' ),
				'new_item'              => __( 'New Travel Guide', 'ojapon_plugin' ),
				'add_new'               => __( 'Add New', 'ojapon_plugin' ),
				'add_new_item'          => __( 'Add New Travel Guide', 'ojapon_plugin' ),
				'edit_item'             => __( 'Edit Travel Guide', 'ojapon_plugin' ),
				'view_item'             => __( 'View Travel Guide', 'ojapon_plugin' ),
				'view_items'            => __( 'View Travel Guides', 'ojapon_plugin' ),
				'search_items'          => __( 'Search Travel Guides', 'ojapon_plugin' ),
				'not_found'             => __( 'No Travel Guides found', 'ojapon_plugin' ),
				'not_found_in_trash'    => __( 'No Travel Guides found in trash', 'ojapon_plugin' ),
				'parent_item_colon'     => __( 'Parent Travel Guide:', 'ojapon_plugin' ),
				'menu_name'             => __( 'Travel Guides', 'ojapon_plugin' ),
			],
			'public'                => true,
			'hierarchical'          => false,
			'show_ui'               => true,
			'show_in_nav_menus'     => true,
			'supports'              => [ 'title', 'editor', 'thumbnail', 'author', 'comments', 'custom-fields'],
			'has_archive'           => true,
			'rewrite'               => true,
			'query_var'             => true,
			'menu_position'         => null,
			'menu_icon'             => 'dashicons-admin-site-alt2',
			'show_in_rest'          => true,
			'rest_base'             => 'travelguide',
			'rest_controller_class' => 'WP_REST_Posts_Controller',

			// adding custom capabilities to map with custom user role

			'capabilities'			=> array(
				'read_post'				=> 'read_travelguide',
				'read_private_posts'	=> 'read_private_travelguides',
				'edit_post'          	=> 'edit_travelguide',
				'edit_posts'         	=> 'edit_travelguides',
				'create_posts'       	=> 'edit_travelguides',
				'edit_others_posts'		=> 'edit_others_travelguides',
				'edit_published_posts'	=> 'edit_published_travelguides',
				'publish_posts'      	=> 'publish_travelguides',
				'delete_post'        	=> 'delete_travelguide', 
				'delete_others_posts' 	=> 'delete_others_travelguides',
				'delete_private_posts' 	=> 'delete_private_travelguides',
				'delete_published_posts' => 'delete_published_travelguides'
			),

			// mapping custom capabilities to WordPress’ primitive capabilities
			'map_meta_cap'			=> true,
			
		]
	);

}

add_action( 'init', 'travel_guide_init' );

/**
 * Sets the post updated messages for the `travel_guide` post type.
 *
 * @param  array $messages Post updated messages.
 * @return array Messages for the `travel_guide` post type.
 */
function travel_guide_updated_messages( $messages ) {
	global $post;

	$permalink = get_permalink( $post );

	$messages['travelguide'] = [
		0  => '', // Unused. Messages start at index 1.
		/* translators: %s: post permalink */
		1  => sprintf( __( 'Travel Guide updated. <a target="_blank" href="%s">View Travel Guide</a>', 'ojapon_plugin' ), esc_url( $permalink ) ),
		2  => __( 'Custom field updated.', 'ojapon_plugin' ),
		3  => __( 'Custom field deleted.', 'ojapon_plugin' ),
		4  => __( 'Travel Guide updated.', 'ojapon_plugin' ),
		/* translators: %s: date and time of the revision */
		5  => isset( $_GET['revision'] ) ? sprintf( __( 'Travel Guide restored to revision from %s', 'ojapon_plugin' ), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false, // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		/* translators: %s: post permalink */
		6  => sprintf( __( 'Travel Guide published. <a href="%s">View Travel Guide</a>', 'ojapon_plugin' ), esc_url( $permalink ) ),
		7  => __( 'Travel Guide saved.', 'ojapon_plugin' ),
		/* translators: %s: post permalink */
		8  => sprintf( __( 'Travel Guide submitted. <a target="_blank" href="%s">Preview Travel Guide</a>', 'ojapon_plugin' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
		/* translators: 1: Publish box date format, see https://secure.php.net/date 2: Post permalink */
		9  => sprintf( __( 'Travel Guide scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Travel Guide</a>', 'ojapon_plugin' ), date_i18n( __( 'M j, Y @ G:i', 'ojapon_plugin' ), strtotime( $post->post_date ) ), esc_url( $permalink ) ),
		/* translators: %s: post permalink */
		10 => sprintf( __( 'Travel Guide draft updated. <a target="_blank" href="%s">Preview Travel Guide</a>', 'ojapon_plugin' ), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
	];

	return $messages;
}

add_filter( 'post_updated_messages', 'travel_guide_updated_messages' );

/**
 * Sets the bulk post updated messages for the `travel_guide` post type.
 *
 * @param  array $bulk_messages Arrays of messages, each keyed by the corresponding post type. Messages are
 *                              keyed with 'updated', 'locked', 'deleted', 'trashed', and 'untrashed'.
 * @param  int[] $bulk_counts   Array of item counts for each message, used to build internationalized strings.
 * @return array Bulk messages for the `travel_guide` post type.
 */
function travel_guide_bulk_updated_messages( $bulk_messages, $bulk_counts ) {
	global $post;

	$bulk_messages['travelguide'] = [
		/* translators: %s: Number of Travel Guides. */
		'updated'   => _n( '%s Travel Guide updated.', '%s Travel Guides updated.', $bulk_counts['updated'], 'ojapon_plugin' ),
		'locked'    => ( 1 === $bulk_counts['locked'] ) ? __( '1 Travel Guide not updated, somebody is editing it.', 'ojapon_plugin' ) :
						/* translators: %s: Number of Travel Guides. */
						_n( '%s Travel Guide not updated, somebody is editing it.', '%s Travel Guides not updated, somebody is editing them.', $bulk_counts['locked'], 'ojapon_plugin' ),
		/* translators: %s: Number of Travel Guides. */
		'deleted'   => _n( '%s Travel Guide permanently deleted.', '%s Travel Guides permanently deleted.', $bulk_counts['deleted'], 'ojapon_plugin' ),
		/* translators: %s: Number of Travel Guides. */
		'trashed'   => _n( '%s Travel Guide moved to the Trash.', '%s Travel Guides moved to the Trash.', $bulk_counts['trashed'], 'ojapon_plugin' ),
		/* translators: %s: Number of Travel Guides. */
		'untrashed' => _n( '%s Travel Guide restored from the Trash.', '%s Travel Guides restored from the Trash.', $bulk_counts['untrashed'], 'ojapon_plugin' ),
	];

	return $bulk_messages;
}

add_filter( 'bulk_post_updated_messages', 'travel_guide_bulk_updated_messages', 10, 2 );

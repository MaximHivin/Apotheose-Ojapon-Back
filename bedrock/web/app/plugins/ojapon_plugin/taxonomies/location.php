<?php

/**
 * Registers the `location` taxonomy,
 * for use with 'poi'.
 */
function location_init() {
	register_taxonomy( 'location', [ 'poi' ], [
		'hierarchical'          => true,
		'public'                => true,
		'show_in_nav_menus'     => true,
		'show_ui'               => true,
		'show_admin_column'     => false,
		'query_var'             => true,
		'rewrite'               => true,
		'capabilities'          => [
			'manage_terms' => 'edit_posts',
			'edit_terms'   => 'edit_posts',
			'delete_terms' => 'edit_posts',
			'assign_terms' => 'edit_posts',
		],
		'labels'                => [
			'name'                       => __( 'Locations', 'ojapon_plugin' ),
			'singular_name'              => _x( 'Location', 'taxonomy general name', 'ojapon_plugin' ),
			'search_items'               => __( 'Search Locations', 'ojapon_plugin' ),
			'popular_items'              => __( 'Popular Locations', 'ojapon_plugin' ),
			'all_items'                  => __( 'All Locations', 'ojapon_plugin' ),
			'parent_item'                => __( 'Parent Location', 'ojapon_plugin' ),
			'parent_item_colon'          => __( 'Parent Location:', 'ojapon_plugin' ),
			'edit_item'                  => __( 'Edit Location', 'ojapon_plugin' ),
			'update_item'                => __( 'Update Location', 'ojapon_plugin' ),
			'view_item'                  => __( 'View Location', 'ojapon_plugin' ),
			'add_new_item'               => __( 'Add New Location', 'ojapon_plugin' ),
			'new_item_name'              => __( 'New Location', 'ojapon_plugin' ),
			'separate_items_with_commas' => __( 'Separate locations with commas', 'ojapon_plugin' ),
			'add_or_remove_items'        => __( 'Add or remove locations', 'ojapon_plugin' ),
			'choose_from_most_used'      => __( 'Choose from the most used locations', 'ojapon_plugin' ),
			'not_found'                  => __( 'No locations found.', 'ojapon_plugin' ),
			'no_terms'                   => __( 'No locations', 'ojapon_plugin' ),
			'menu_name'                  => __( 'Locations', 'ojapon_plugin' ),
			'items_list_navigation'      => __( 'Locations list navigation', 'ojapon_plugin' ),
			'items_list'                 => __( 'Locations list', 'ojapon_plugin' ),
			'most_used'                  => _x( 'Most Used', 'location', 'ojapon_plugin' ),
			'back_to_items'              => __( '&larr; Back to Locations', 'ojapon_plugin' ),
		],
		'show_in_rest'          => true,
		'rest_base'             => 'location',
		'rest_controller_class' => 'WP_REST_Terms_Controller',
	] );

	/* From https://developer.wordpress.org/reference/functions/register_taxonomy/ 
	Better be safe than sorry when registering custom taxonomies for custom post types. 
	Use register_taxonomy_for_object_type() right after the function to interconnect them. 
	Else you could run into minetraps where the post type isn’t attached inside filter callback 
	that run during parse_request or pre_get_posts.
	*/ 
	register_taxonomy_for_object_type('location', 'poi');
}

add_action( 'init', 'location_init' );

function insert_initial_locations($taxonomy, $object_type, $args) {
	/* var_dump('here insert_initial_locations for ' .$taxonomy); 
	var_dump($object_type);
	var_dump($args); */
    if ($taxonomy === 'location') {
		require_once(plugin_dir_path(__FILE__) . '../data/taxonomies_data.php');
		foreach($prefectures as $value) {
			wp_insert_term($value, $taxonomy);
		}
    }
	
}

add_action('registered_taxonomy', 'insert_initial_locations', 10, 3 );

/**
 * Sets the post updated messages for the `location` taxonomy.
 *
 * @param  array $messages Post updated messages.
 * @return array Messages for the `location` taxonomy.
 */
function location_updated_messages( $messages ) {

	$messages['location'] = [
		0 => '', // Unused. Messages start at index 1.
		1 => __( 'Location added.', 'ojapon_plugin' ),
		2 => __( 'Location deleted.', 'ojapon_plugin' ),
		3 => __( 'Location updated.', 'ojapon_plugin' ),
		4 => __( 'Location not added.', 'ojapon_plugin' ),
		5 => __( 'Location not updated.', 'ojapon_plugin' ),
		6 => __( 'Locations deleted.', 'ojapon_plugin' ),
	];

	return $messages;
}

add_filter( 'term_updated_messages', 'location_updated_messages' );


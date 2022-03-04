<?php

/**
 * Registers the `season` taxonomy,
 * for use with 'poi'.
 */
function season_init() {
	register_taxonomy( 'season', [ 'poi' ], [
		'hierarchical'          => false,
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
			'name'                       => __( 'Seasons', 'ojapon_plugin' ),
			'singular_name'              => _x( 'Season', 'taxonomy general name', 'ojapon_plugin' ),
			'search_items'               => __( 'Search Seasons', 'ojapon_plugin' ),
			'popular_items'              => __( 'Popular Seasons', 'ojapon_plugin' ),
			'all_items'                  => __( 'All Seasons', 'ojapon_plugin' ),
			'parent_item'                => __( 'Parent Season', 'ojapon_plugin' ),
			'parent_item_colon'          => __( 'Parent Season:', 'ojapon_plugin' ),
			'edit_item'                  => __( 'Edit Season', 'ojapon_plugin' ),
			'update_item'                => __( 'Update Season', 'ojapon_plugin' ),
			'view_item'                  => __( 'View Season', 'ojapon_plugin' ),
			'add_new_item'               => __( 'Add New Season', 'ojapon_plugin' ),
			'new_item_name'              => __( 'New Season', 'ojapon_plugin' ),
			'separate_items_with_commas' => __( 'Separate seasons with commas', 'ojapon_plugin' ),
			'add_or_remove_items'        => __( 'Add or remove seasons', 'ojapon_plugin' ),
			'choose_from_most_used'      => __( 'Choose from the most used seasons', 'ojapon_plugin' ),
			'not_found'                  => __( 'No seasons found.', 'ojapon_plugin' ),
			'no_terms'                   => __( 'No seasons', 'ojapon_plugin' ),
			'menu_name'                  => __( 'Seasons', 'ojapon_plugin' ),
			'items_list_navigation'      => __( 'Seasons list navigation', 'ojapon_plugin' ),
			'items_list'                 => __( 'Seasons list', 'ojapon_plugin' ),
			'most_used'                  => _x( 'Most Used', 'season', 'ojapon_plugin' ),
			'back_to_items'              => __( '&larr; Back to Seasons', 'ojapon_plugin' ),
		],
		'show_in_rest'          => true,
		'rest_base'             => 'season',
		'rest_controller_class' => 'WP_REST_Terms_Controller',
	] );

}

add_action( 'init', 'season_init' );

function insert_initial_season($taxonomy, $object_type, $args) {
	/* var_dump('here insert_initial_locations for ' .$taxonomy); 
	var_dump($object_type);
	var_dump($args); */
    if ($taxonomy === 'season') {
		include(plugin_dir_path(__FILE__) . '../data/taxonomies_data.php');
		foreach($seasons as $value) {
			wp_insert_term($value, $taxonomy);
		}
    }
	
}
add_action('registered_taxonomy', 'insert_initial_season', 10, 3 );

/**
 * Sets the post updated messages for the `season` taxonomy.
 *
 * @param  array $messages Post updated messages.
 * @return array Messages for the `season` taxonomy.
 */
function season_updated_messages( $messages ) {

	$messages['season'] = [
		0 => '', // Unused. Messages start at index 1.
		1 => __( 'Season added.', 'ojapon_plugin' ),
		2 => __( 'Season deleted.', 'ojapon_plugin' ),
		3 => __( 'Season updated.', 'ojapon_plugin' ),
		4 => __( 'Season not added.', 'ojapon_plugin' ),
		5 => __( 'Season not updated.', 'ojapon_plugin' ),
		6 => __( 'Seasons deleted.', 'ojapon_plugin' ),
	];

	return $messages;
}

add_filter( 'term_updated_messages', 'season_updated_messages' );

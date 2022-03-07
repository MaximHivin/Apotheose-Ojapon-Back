<?php

/**
 * Registers the `genre` taxonomy,
 * for use with 'poi'.
 */
function genre_init() {
	register_taxonomy( 'genre', [ 'poi' ], [
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
			'name'                       => __( 'Genres', 'ojapon_plugin' ),
			'singular_name'              => _x( 'Genre', 'taxonomy general name', 'ojapon_plugin' ),
			'search_items'               => __( 'Search Genres', 'ojapon_plugin' ),
			'popular_items'              => __( 'Popular Genres', 'ojapon_plugin' ),
			'all_items'                  => __( 'All Genres', 'ojapon_plugin' ),
			'parent_item'                => __( 'Parent Genre', 'ojapon_plugin' ),
			'parent_item_colon'          => __( 'Parent Genre:', 'ojapon_plugin' ),
			'edit_item'                  => __( 'Edit Genre', 'ojapon_plugin' ),
			'update_item'                => __( 'Update Genre', 'ojapon_plugin' ),
			'view_item'                  => __( 'View Genre', 'ojapon_plugin' ),
			'add_new_item'               => __( 'Add New Genre', 'ojapon_plugin' ),
			'new_item_name'              => __( 'New Genre', 'ojapon_plugin' ),
			'separate_items_with_commas' => __( 'Separate genres with commas', 'ojapon_plugin' ),
			'add_or_remove_items'        => __( 'Add or remove genres', 'ojapon_plugin' ),
			'choose_from_most_used'      => __( 'Choose from the most used genres', 'ojapon_plugin' ),
			'not_found'                  => __( 'No genres found.', 'ojapon_plugin' ),
			'no_terms'                   => __( 'No genres', 'ojapon_plugin' ),
			'menu_name'                  => __( 'Genres', 'ojapon_plugin' ),
			'items_list_navigation'      => __( 'Genres list navigation', 'ojapon_plugin' ),
			'items_list'                 => __( 'Genres list', 'ojapon_plugin' ),
			'most_used'                  => _x( 'Most Used', 'genre', 'ojapon_plugin' ),
			'back_to_items'              => __( '&larr; Back to Genres', 'ojapon_plugin' ),
		],
		'show_in_rest'          => true,
		'rest_base'             => 'genres',
		'rest_controller_class' => 'WP_REST_Terms_Controller',
	] );

}

add_action( 'init', 'genre_init' );

function insert_initial_genres($taxonomy, $object_type, $args) {
	/* var_dump('here insert_initial_locations for ' .$taxonomy); 
	var_dump($object_type);
	var_dump($args); */
    if ($taxonomy === 'genre') {
		include(plugin_dir_path(__FILE__) . '../data/taxonomies_data.php');
		foreach($genres as $value) {
			wp_insert_term($value, $taxonomy);
		}
    }
	
}
add_action('registered_taxonomy', 'insert_initial_genres', 10, 3 );

/**
 * Sets the post updated messages for the `genre` taxonomy.
 *
 * @param  array $messages Post updated messages.
 * @return array Messages for the `genre` taxonomy.
 */
function genre_updated_messages( $messages ) {

	$messages['genre'] = [
		0 => '', // Unused. Messages start at index 1.
		1 => __( 'Genre added.', 'ojapon_plugin' ),
		2 => __( 'Genre deleted.', 'ojapon_plugin' ),
		3 => __( 'Genre updated.', 'ojapon_plugin' ),
		4 => __( 'Genre not added.', 'ojapon_plugin' ),
		5 => __( 'Genre not updated.', 'ojapon_plugin' ),
		6 => __( 'Genres deleted.', 'ojapon_plugin' ),
	];

	return $messages;
}

add_filter( 'term_updated_messages', 'genre_updated_messages' );

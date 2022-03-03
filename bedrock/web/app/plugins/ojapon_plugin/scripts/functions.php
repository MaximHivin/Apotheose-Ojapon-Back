<?php

/**
 * This function inserts into the new taxonomy the provided data from an array
 * This array can be found in data/taxonomies_data.php
 * 
 * @param string $taxonomy
 * @param array $data
 *
 * @return void
 */
function insert_initial_data($taxonomy, $data = [], $args = []) {
    //if (!isset($args['parent'])) $args['parent'] = 0;
	// parse array
		// for each item, add term with wp_insert_term
        foreach($data as $value) {
            /* var_dump($taxonomy);
            var_dump($args);
            var_dump($value); die; */
            wp_insert_term($value, $taxonomy/* , $args */);
            
        }
}

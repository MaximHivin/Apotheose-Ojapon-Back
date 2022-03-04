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

function mod_jwt_auth_valid_credential_response( $response, $user ) {
    $user_info = get_user_by( 'email',  $user->data->user_email );
    $token = $response['data']['token'];
    $response = array(
        'success'    => true,
        'statusCode' => 200,
        'code'       => 'jwt_auth_valid_credential',
        'message'    => __( 'Credential is valid', 'jwt-auth' ),
        'data'       => array(
            'token'       => $token,
            'id'          => $user->ID,
            'email'       => $user->user_email,
            'nicename'    => $user->user_nicename,
            'firstName'   => $user->first_name,
            'lastName'    => $user->last_name,
            'displayName' => $user->display_name,
            'roles'       => $user_info->roles[0],
        ),
    );
    
    return $response;
}
add_filter( 'jwt_auth_valid_credential_response', 'mod_jwt_auth_valid_credential_response', 10, 2 ); 
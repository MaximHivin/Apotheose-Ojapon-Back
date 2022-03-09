<?php

function ojapon_create_custom_table()
{
    
    global $wpdb;
    $table_name = "wp_ojapon_guide_poi";
    $collation = $wpdb->collate;
    $sql = "
    CREATE TABLE `$table_name` (
        `id` mediumint(9) NOT NULL AUTO_INCREMENT PRIMARY KEY,
        `guide_id` mediumint(9) NOT NULL,
        `poi_id` mediumint(9) NOT NULL
        ) COLLATE '" . $collation . "';";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    //dbDelta() is used for everything: insertion, update, etc.
    dbDelta($sql);
}

function ojapon_drop_custom_table() 
{
    global $wpdb;
    $table_name = "wp_ojapon_guide_poi";
    $wpdb->query("DROP TABLE IF EXISTS $table_name");
}




add_action('rest_api_init', 'ojapon_rest_link_poi');

function ojapon_rest_link_poi()
{
    // Defines a new route for our user registration
    register_rest_route('wp/v2', '/travelguide/(?P<idguide>\d+)/poi/(?P<idpoi>\d+)', array(
        'methods' => ['POST', 'DELETE'],
        'callback' => 'ojapon_rest_link_poi_handler',
        'args' => [
            'idguide',
            'idpoi'
        ],
        'permission_callback' => function () {
            return true;
        }
    ));

    /* 
    //? this method receives its parameters via a form or an object
    register_rest_route('ojapon_plugin/v1', 'link_poi', array(
        'methods' => ['POST', 'DELETE'],
        'callback' => 'ojapon_rest_link_poi_handler',
        'permission_callback' => function () {
            return true;
        }
    )); */
}

function ojapon_rest_link_poi_handler($request)
{
    // $request is an instance of WP_REST_Request
    $http_method = $request->get_method();

    global $wpdb;

    // Preparation of errors in case of non-validation of data
    $error = new WP_Error();

    //retrieve query params
    $parameters = $request->get_params();

    // Prepare response HTTP
    // todo example, to modify
    $response = array(
        'parameters'   => $parameters,
        'httpMethod'    => $http_method
    );
    

    //no need to filter, as the regex only accepts digits as argument
    $idguide = $parameters['idguide'];
    $idpoi = $parameters['idpoi'];

    //checks that the ids are strictly greater than zero
    if($idguide <= 0 || $idpoi <= 0) {
        $error->add(400, "IDs should be positive integers", array('status' => 400));
        return $error;
    }

    //! if we chose to use the second route (/link_poi), params must be filtered and an error thrown if digits weren't passed as arguments
    
    /* $response['idguideunfiltered'] = $parameters['idguide'];
    $idguide = filter_var($parameters['idguide'], FILTER_SANITIZE_NUMBER_INT);
    $response['idguidefiltered'] = $idguide;
    $idpoi = filter_var($parameters['idpoi'], FILTER_SANITIZE_NUMBER_INT); */

    // Verification of form content
    //! for example, to modify 
    /* if (empty($idguide)) {
        $error->add(400, "The provided parameter for guide is not an integer", array('status' => 400));
        return $error;
    } */

    // if method = POST --> we make an insertion
    if($http_method == 'POST') {
        // we can check the existence of the guide and the point of interest passed in param
        $query = "SELECT * FROM `wp_ojapon_guide_poi` WHERE `guide_id` =" .$idguide . " AND `poi_id` = " . $idpoi;
        $result = $wpdb->get_row($query);
        
        // if $result is null, the link does not yet exist
        if(is_null($result)) {
            // we make the link between the two CPT travelguide and poi
            $result = $wpdb->insert(
                'wp_ojapon_guide_poi',
                [
                    'guide_id'   => $idguide,
                    'poi_id'   => $idpoi
                ]
            );

            // if insertion ok, we return a 201 Created
            if($result == 1) {
                $response['code'] = 201;
                $response['message'] = "Successfully Linked";
            } 
            // otherwise error message
            else {
                $error->add(400, "Link couldn't be inserted in database", array('status' => 400));
                return $error;
            }
        }
        // otherwise an error is returned
        else {
            $error->add(400, "This Point of interest is already linked to this travel guide", array('status' => 400));
            return $error;
        }
    } 
    
    //if method = DELETE --> we delete the link
    elseif ($http_method == 'DELETE') {
        // we can check in a request that the link exists and delete it if necessary
        // if it exists, we delete the corresponding record in the table, otherwise we return false
        $result = $wpdb->delete( 'wp_ojapon_guide_poi', array( 'guide_id' => $idguide, 'poi_id' => $idpoi ) );

        // if deletion ok, we return a 200 OK
        if($result >= 1) {
            $response['code'] = 200;
            $response['message'] = "Successfully Unlinked";
        } 
        // otherwise error message
        else {
            $error->add(400, "This Point of interest is not linked to this travel guide", array('status' => 400));
            return $error;
        }
    }
    // if neithermethod is correct --> we return an error 
    // this condition should never be checked because we only allow POST and DELETE in the route declaration
    else {
        // error message (méthod not authorized)
        $error->add(405, "This method is not allowed for this route", array('status' => 405));
        return $error;
    }

    return new WP_REST_Response($response, 123);
};

/*
Existent déjà : 
--------------
/wp-json/wp/v2/travelguide --> liste de tous les guides
/wp-json/wp/v2/travelguide/74 --> le guide qui a l'id 74

Param possibles : 
?_embed
?author=1
?_embed&author=1

Sont à créer : 
---------------


/wp-json/wp/v2//travelguide/74/poi/25 --> 
    en POST --> ajoute dans la table le lien entre le guide 74 et le poi 25
    en DELETE --> supprime l'enregistrement qui lie le guide 74 et le poi 25


/wp-json/wp/v2/travelguide/74/poi --> liste tous les POI liés au guide 74

Voir pour créer nouvelle route custom sur le modèle ci-dessus
on peut faire des requêtes internes à l'API : 
https://developer.wordpress.org/rest-api/frequently-asked-questions/#can-i-make-api-requests-from-php-within-a-plugin
https://developer.wordpress.org/reference/functions/rest_do_request/

Puis à partir de l'id du guide, récupérer les poi liés 
? en 2 temps
    - récupérer tous les POI via une requête API interne
    - filtrer cette liste par rapport à la table custom
Ajouter ces POI à la response
Renvoyer la response au front


*/
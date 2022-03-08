<?php

/**
 * Script allowing user registration from Vuejs frontend, without being logged in as admin
 * Source : École O'Clock - february 2022
 * Script itself partially copied and pasted from Stackoverflow
 */

add_action('rest_api_init', 'ojapon_rest_insert_poi');

function ojapon_rest_insert_poi()
{
    // Definit une nouvelle route pour notre inscription d'utilisateur
    register_rest_route('ojapon_plugin/v1', '/poi', array(
        'methods' => 'POST',
        'callback' => 'ojapon_rest_insert_poi_handler',
        'permission_callback' => function () {
            return true;
        }
    ));
}

function ojapon_rest_insert_poi_handler($request)
{
    var_dump("here");
    // Preparation de la réponse HTTP
    $response = array();

    return new WP_REST_Response($response, 123);
}
<?php
/**
 * O'Japon plugin for WordPress
 *
 * Plugin Name:  Voyage O'Japon
 * Description:  A collection of useful features for our collaborative website around trips to Japan
 * Version:      0.1
 * Author:       Aurélie Cuignet
*/

// custom post types
include plugin_dir_path(__FILE__) . 'post-types/travel-guide.php';
include plugin_dir_path(__FILE__) . 'post-types/poi.php';

// custom role
include plugin_dir_path(__FILE__) . 'roles/traveler.php';

// user registration via WP API
include plugin_dir_path(__FILE__) . 'scripts/registration.php';

register_activation_hook(__FILE__, function () {
    ojapon_create_roles();
    ojapon_add_cap_roles();
});
register_deactivation_hook(__FILE__, function () {
    ojapon_remove_roles();
    ojapon_remove_cap_roles();
});
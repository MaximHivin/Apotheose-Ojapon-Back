<?php

function ojapon_create_custom_table()
{
    global $wpdb;
    $table_name = "wp_ojapon_guide_pois";
    $collation = $wpdb->collate;
    $sql = "
    CREATE TABLE `$table_name` (
        `id` mediumint(9) NOT NULL AUTO_INCREMENT PRIMARY KEY,
        `guide_id` PRIMARY KEY mediumint(9) NOT NULL,
        `poi_id` PRIMARY KEY mediumint(9) NOT NULL
        ) COLLATE '" . $collation . "';";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    //dbDelta() sert à tout : insertion, update, etc.
    dbDelta($sql);
}

function ojapon_drop_custom_table() 
{
    global $wpdb;
    $table_name = "wp_ojapon_guide_pois";
    $wpdb->query("DROP TABLE IF EXISTS $table_name");
}
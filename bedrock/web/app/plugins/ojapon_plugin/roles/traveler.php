<?php
function ojapon_create_roles()
{
    // A traveler is a subscriber with specific capabilities on CPT

    // cloning subscriber role
    $role = add_role( 'traveler', 'Traveler', get_role( 'subscriber' )->capabilities );

    // adding custom capabilities for Point of interest
    $role->add_cap( 'read_poi');
    $role->add_cap( 'read_private_pois' );
    $role->add_cap( 'edit_poi' );
    $role->add_cap( 'edit_pois' );
    $role->add_cap( 'delete_private_pois' );

    //todo adding custom capabilities for travel guide
}


function ojapon_remove_roles()
{
    remove_role('traveler');
}

function ojapon_add_cap_roles() {
    $role = get_role('administrator');

    // adding custom capabilities to the admin role on the new CPTs
    $role->add_cap( 'read_poi');
    $role->add_cap( 'read_private_pois' );
    $role->add_cap( 'edit_poi' );
    $role->add_cap( 'edit_pois' );
    $role->add_cap( 'delete_private_pois' );
    $role->add_cap( 'publish_pois' );
    $role->add_cap( 'edit_others_pois' );
    $role->add_cap( 'edit_published_pois' );
    $role->add_cap( 'delete_others_pois' );
    $role->add_cap( 'delete_published_pois' );

    //todo adding custom capabilities for travel guide
}


function ojapon_remove_cap_roles() {
    $role = get_role('administrator');

    // removing custom capabilities

    $role->remove_cap( 'read_poi');
    $role->remove_cap( 'read_private_pois' );
    $role->remove_cap( 'edit_poi' );
    $role->remove_cap( 'edit_pois' );
    $role->remove_cap( 'delete_private_pois' );
    $role->remove_cap( 'publish_pois' );
    $role->remove_cap( 'edit_others_pois' );
    $role->remove_cap( 'edit_published_pois' );
    $role->remove_cap( 'delete_others_pois' );
    $role->remove_cap( 'delete_published_pois' );

    //todo removing custom capabilities for travel guide
}

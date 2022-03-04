<?php
function ojapon_create_roles()
{
    // A traveler is a subscriber with specific capabilities on CPT

    // cloning subscriber role
    $role = add_role( 'traveler', 'Traveler', get_role( 'subscriber' )->capabilities );

    // as remove_role() is not working as intended, I have to check if $role was null (in case it already exists)
    // this is a quick workaround, this must be fixed in a next version
    if(is_null($role)) {
        $role = get_role( 'traveler' );
    }

    // adding custom capabilities for Point of interest
    $role->add_cap( 'read_poi');
    $role->add_cap( 'read_private_pois' );
    $role->add_cap( 'edit_poi' );
    $role->add_cap( 'edit_pois' );
    $role->add_cap( 'delete_private_pois' );

    //adding custom capabilities for travel guide
    $role->add_cap( 'read_travel-guide');
    $role->add_cap( 'read_private_travel-guides' );
    $role->add_cap( 'edit_travel-guide' );
    $role->add_cap( 'edit_travel-guides' );
    $role->add_cap( 'delete_private_travel-guides' );
}

function ojapon_remove_roles()
{
    //!todo this function doesn't seem to do the job, the custom role is NOT removed from WP when deactivating the plugin...
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

    //adding custom capabilities for travel guide
    $role->add_cap( 'read_travel-guide');
    $role->add_cap( 'read_private_travel-guides' );
    $role->add_cap( 'edit_travel-guide' );
    $role->add_cap( 'edit_travel-guides' );
    $role->add_cap( 'delete_private_travel-guides' );
    $role->add_cap( 'publish_travel-guides' );
    $role->add_cap( 'edit_others_travel-guides' );
    $role->add_cap( 'edit_published_travel-guides' );
    $role->add_cap( 'delete_others_travel-guides' );
    $role->add_cap( 'delete_published_travel-guides' );

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

    //removing custom capabilities for travel guide
    $role->remove_cap( 'read_travel-guide');
    $role->remove_cap( 'read_private_travel-guides' );
    $role->remove_cap( 'edit_travel-guide' );
    $role->remove_cap( 'edit_travel-guides' );
    $role->remove_cap( 'delete_private_travel-guides' );
    $role->remove_cap( 'publish_travel-guides' );
    $role->remove_cap( 'edit_others_travel-guides' );
    $role->remove_cap( 'edit_published_travel-guides' );
    $role->remove_cap( 'delete_others_travel-guides' );
    $role->remove_cap( 'delete_published_travel-guides' );

}

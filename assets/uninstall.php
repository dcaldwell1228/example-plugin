<?php
/**
 * @package DillonPlugin
**/
/* trigger this file on plugin uninstall */

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    die();
}

//delete CPT

//delete all the plugin data from database
$books = get_posts( array( 'post_type' => 'book', 'numberposts' => -1 ) );
/* there are two methods to do this*/
/* option 1*/
// foreach( $books as $book ) {
//     wp_delete_post( $book->ID, true );
// }

/* option 2*/
//access the database via SQL
global $wpdb;
$wpdb->query( "DELETE FROM wp_posts WHERE post_type = 'book'" );
$wpdb->query( "DELETE FROM wp_postmeta WHERE post_id NOT IN (SELECT id FROM wp_posts)" );
$wpdb->query( "DELETE FROM wp_term_relationships WHERE object_id NOT IN (SELECT id FROM wp_posts)" );
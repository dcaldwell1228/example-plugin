<?php
/**
 * @package DillonPlugin
 */

namespace Inc\Base;

class Activate
{
    public static function activate() {
        flush_rewrite_rules();
        $default = array();
        if ( ! get_option( 'dillon_plugin' ) ) {
            update_option( 'dillon_plugin', $default );
        }
        if ( ! get_option( 'dillon_plugin_cpt' ) ) {
            update_option( 'dillon_plugin_cpt', $default );
        }
        if ( ! get_option( 'dillon_plugin_tax' ) ) {
            update_option( 'dillon_plugin_tax', $default );
        }
    }
}
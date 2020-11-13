<?php
/**
 * @package DillonPlugin
*/
/*
 * Plugin Name: Dillon's Example Plugin
 * Plugin URI: https://dilloncaldwell.net
 * Description: Example Plugin description
 * Version: 1.0.0
 * Author: Dillon Caldwell
 * Author URI: https://dilloncaldwell.net
 * Text Domain: example-plugin
 * License: GPLv3 or later
    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <https://www.gnu.org/licenses/>.
    */

    /** 
    -----------------------------------------------------
    /////////////// PLUGIN NOTES ////////////////////////
    -----------------------------------------------------
    Plugin Built using OOP following youtube wordpress 
    plugin development tutorials by Alessandro Castellani

    methods or variables can be public, protected, or private
    Public- varible or method can be accessed everywhere- is public by default
    Protected- can be accessed only within the class itself or a class that extends the parent class
    Private- can be accessed only within the class itself

    Our Methods below - $this refers to the class it is inside
    If function is static it does not need to be initialized, instead can DillonPlugin::register();, 
    and instead of $this put the class in the add_action

    There are two ways to regigister the activate and deactvate, 
    use function inside class like activate or keep it seperate like deactivate

    */

/* If this file id called directly, abort!!! */
defined( 'ABSPATH' ) or die( 'Hey, what are you doing here? You silly human!' );

/* Require once the Composer Autoload */
if ( file_exists( dirname(__FILE__) . '/vendor/autoload.php' ) ){
    require_once( dirname(__FILE__) . '/vendor/autoload.php' );
}

/* Activation- Runs during activation*/
function activate_dillon_plugin() {
    Inc\Base\Activate::activate();
}
register_activation_hook( __FILE__, 'activate_dillon_plugin' );

/* Deactivation- runs during deactivation */
function deactivate_dillon_plugin() {
    Inc\Base\Deactivate::deactivate();
}
register_deactivation_hook( __FILE__, 'deactivate_dillon_plugin' );

/* Initialize all the core classes of the plugin */
if ( class_exists( 'Inc\\Init' ) ) {
    Inc\Init::register_services();
}


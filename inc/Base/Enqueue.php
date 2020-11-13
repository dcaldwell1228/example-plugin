<?php
/**
 * @package DillonPlugin
 */
namespace  Inc\Base;

use \Inc\Base\BaseController;

class Enqueue extends BaseController
{
    public function register() {
        //wp_enqueue_scripts for frontend, admin_enqueue_scripts for backend
        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue' ) );

    }
    

    function enqueue() {
        // enqueue all our scripts
        wp_enqueue_script( 'media-upload' );
        wp_enqueue_media();
        wp_enqueue_style( 'mypluginstyle', $this->plugin_url . 'assets/css/mystyle.min.css' );
        wp_enqueue_script( 'mypluginscript', $this->plugin_url . 'assets/js/myscript.min.js' );
    }

}
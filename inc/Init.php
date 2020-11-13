<?php
/**
 * @package DillonPlugin
 */

namespace Inc;

/* Declaring a class as final prevents the class from being extended */
final class Init
{
    /**  
    * Store all the classes inside an array
    * @return array Full list of classes
    */
    public static function get_services() {
        return [ 
            Pages\Dashboard::class,
            Base\Enqueue::class,
            Base\SettingsLinks::class,
            Base\CustomPostTypeController::class,
            Base\CustomTaxonomyController::class,
            Base\WidgetController::class,
            Base\GalleryController::class,
            Base\TestimonialController::class,
            Base\TemplateController::class,
            Base\AuthController::class,
            Base\MembershipController::class,
            Base\ChatController::class
        ];
    }

    /**  
    * Loop through the classes, initialize them,
    * and call the register() method if it exists
    * @return
    */
    public static function register_services() {
        foreach( self:: get_services() as $class ) {
            $service = self::instantiate( $class );
            if ( method_exists( $service, 'register' ) ) {
                $service->register();
            }
        }
    }

    /**  
    * Initialize the class
    * @parm class $class class from the services array
    * @return class instance new instance of the class
    */
    private static function instantiate( $class ) {
        $service = new $class();

        return $service;
    }
    
}




// /* Plugin Built using OOP following youtube wordpress plugin development tutorials by Alessandro Castellani */
// /* Using $this refers to the class DillonPlugin */
// if ( !class_exists( 'DillonPlugin' ) ) 
// {
//     class DillonPlugin 
//     {
//         //methods or variables can be public, protected, or private
//         // Public- varible or method can be accessed everywhere- is public by default
//         // Protected- can be accessed only within the class itself or a class that extends the parent class
//         // Private- can be accessed only within the class itself

//         //Our Methods below - $this refers to the class DillonPlugin
//         //if function is static it does not need to be initialized, instead can DillonPlugin::register();, and instead of $this put the class in the add_action

//         public $plugin;

//         function __construct() {
//             $this->plugin = plugin_basename(__FILE__);
//         }

//         function register() {
//             // wp_enqueue_scripts for frontend, admin_enqueue_scripts for backend
//             add_action( 'admin_enqueue_scripts', array( $this, 'enqueue' ) );

//             add_action( 'admin_menu', array( $this, 'add_admin_pages' ) );

//             add_filter( "plugin_action_links_$this->plugin", array( $this, 'settings_link' ) );
//         }

//         public function settings_link($links) {
//             // add custom settings link to plugin page
//             $settings_link = '<a href="admin.php?page=dillon_plugin">Settings</a>';
//             array_push( $links, $settings_link );
//             return $links;
//         }

//         public function add_admin_pages() {
//             //adds admin menu page, parms(pagetitle, menu title, capability, menu slug, callback, icon, position of link )
//             add_menu_page( 'Dillon Plugin', 'Dillon Settings', 'manage_options', 'dillon_plugin', array( $this, 'admin_index' ), 'dashicons-admin-generic', 110 );
//         }

//         public function admin_index() {
//             // require template admin-page.php
//             require_once plugin_dir_path(__FILE__). 'templates/admin.php';
//         }

//         function create_post_type() {
//             add_action( 'init', array( $this, 'custom_post_type') );
//         }


//         function custom_post_type() {
//             //method to register book CPT
//             register_post_type( 'book', ['public' => true, 'label' => 'Books', 'menu_icon' => 'dashicons-book-alt'] );
//         }

//         function enqueue() {
//             // enqueue all our scripts
//             wp_enqueue_style( 'mypluginstyle', plugins_url( '/assets/mystyle.css', __FILE__ ) );
//             wp_enqueue_script( 'mypluginscript', plugins_url( '/assets/myscript.js', __FILE__ ) );
//         }
//         function activate() {
//             // the require_once is replaced with namspace created by composer and autoload
//             //require_once plugin_dir_path(__FILE__). 'inc/dillon-plugin-activate.php';
//             Activate::activate();
//         }

//     }

//     //Initialize the class
//     $dillonPlugin = new DillonPlugin();
//     $dillonPlugin->register();
//     $dillonPlugin->create_post_type();

//     //There are two ways to regigister the activate and deactvate, use function inside class like activate or keep it seperate like deactivate
//     //activation
//     register_activation_hook( __FILE__, array( $dillonPlugin, 'activate' ) );

//     //deactivation
//     // the require_once is replaced with namspace created by composer and autoload
//     //require_once plugin_dir_path(__FILE__). 'inc/dillon-plugin-deactivate.php';
//     register_deactivation_hook( __FILE__, array( 'Deactivate', 'deactivate' ) );


// }

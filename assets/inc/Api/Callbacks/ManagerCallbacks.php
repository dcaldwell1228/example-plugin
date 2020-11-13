<?php
/**
 * @package DillonPlugin
 */
namespace  Inc\Api\Callbacks;

use \Inc\Base\BaseController;
//test

class ManagerCallbacks extends BaseController
{
    public function checkboxSanitize( $input ) {
        //return filter_var( $input, FILTER_SANITIZE_NUMBER_INT );
        return ( isset( $input ) ? true : false );
    }

    public function adminSectionManager() {
        echo 'Manage the sections and features of this plugin by activating the checkboxes from the following list:';
    }

    public function checkboxField( $args ) {
        $name = $args['label_for'];
        $classes = $args['class'];
        $checkbox = get_option( $name );
        echo '<div class="'.$classes.'">
                <input 
                    type="checkbox" 
                    name="'.$name.'" 
                    id="'.$name.'" value="1" 
                    class="'.$classes.'" '.($checkbox ? 'checked' : '').' 
                >
                <label for="'.$name.'">
                    <div>
                        
                    </div>
                </label>
            </div>';
    }
}

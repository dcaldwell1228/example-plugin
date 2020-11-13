<?php
/**
 * @package DillonPlugin
 */
namespace  Inc\Api\Callbacks;

class CptCallbacks
{
    public function cptSectionManager() {
        echo 'Create as many custom post types as you want';
    }

    public function cptSanitize( $input ) {
        $output = get_option('dillon_plugin_cpt');
        // delete cpt from database, hidden field with name of remove
        if ( isset($_POST["remove"]) ) {
            unset( $output[$_POST["remove"]] );
            return $output;
        }
        // if dillon_plugin_cpt is not already in database, create empty array
        if ( count($output) == 0 ) {
            $output[$input['post_type']] = $input;
            return $output;
        }
        // makes each cpt have its own array with the key the same as the ID
        //if custom post type id already exits update it
        // else create a new array
        foreach ( $output as $key => $value ) {
            if ( $input['post_type'] === $key ) {
                $output[$key] = $input;
            } else {
                $output[$input['post_type']] = $input;
            }
        }
        return $output;
    }

    public function textField( $args ) {
        $name = $args['label_for'];
        $option_name = $args['option_name']; 
        $value = '';

        if ( isset($_POST["edit_post"]) ) {
            $input = get_option( $option_name );
            $value = $input[$_POST["edit_post"]][$name];
        }

        echo '<input type="text" class="regular-text" name="' . $option_name . '[' . $name . ']" 
        id="'.$name.'" value="'.$value.'" placeholder="'.$args['placeholder'].'" required>';
    }

    public function iconField( $args ) {
        $name = $args['label_for'];
        $option_name = $args['option_name']; 
        $value = '';

        if ( isset($_POST["edit_post"]) ) {
            $input = get_option( $option_name );
            $value = $input[$_POST["edit_post"]][$name];
        }

        echo '<input type="text" class="regular-text" name="' . $option_name . '[' . $name . ']" 
        id="'.$name.'" value="'.$value.'" placeholder="'.$args['placeholder'].'">';
    }

    public function numberField( $args ) {
        $name = $args['label_for'];
        $option_name = $args['option_name']; 
        $value = '';

        if ( isset($_POST["edit_post"]) ) {
            $input = get_option( $option_name );
            $value = $input[$_POST["edit_post"]][$name];
        }

        echo '<input type="text" class="regular-text" name="' . $option_name . '[' . $name . ']" 
        id="'.$name.'" value="'.$value.'" placeholder="'.$args['placeholder'].'" >';
    }

    public function checkboxField( $args ) {
        $name = $args['label_for'];
        $classes = $args['class'];
        $option_name = $args['option_name']; 
        $checked = false;
        

        if ( isset( $_POST["edit_post"]) ) {
            $checkbox = get_option( $option_name );
            $checked = isset( $checkbox[$_POST["edit_post"]][$name] ) ?: false;

        }
        echo '<div class="'.$classes.'">
                <input 
                    type="checkbox" 
                    name="' . $option_name . '[' . $name . ']" 
                    id="'.$name.'" 
                    value="1" 
                    class="" 
                    '.( $checked ? 'checked' : '').'
                >
                <label for="'.$name.'">
                    <div>
                        
                    </div>
                </label>
            </div>';
    }
}

<?php
/**
 * @package DillonPlugin
 */
namespace  Inc\Api\Callbacks;

class TaxonomyCallbacks
{
    public function taxSectionManager() {
        echo 'Create as many custom taxonomies as you want';
    }

    public function taxSanitize( $input ) {
        $output = get_option('dillon_plugin_tax');
        // delete taxonomy from database, hidden field with name of remove
        if ( isset($_POST["remove"]) ) {
            unset( $output[$_POST["remove"]] );
            return $output;
        }
        // if dillon_plugin_tax is not already in database, create empty array
        if ( count($output) == 0 ) {
            $output[$input['taxonomy']] = $input;
            return $output;
        }
        // makes each taxonomy have its own array with the key the same as the ID
        //if taxonomy id already exits update it
        // else create a new array
        foreach ( $output as $key => $value ) {
            if ( $input['taxonomy'] === $key ) {
                $output[$key] = $input;
            } else {
                $output[$input['taxonomy']] = $input;
            }
        }
        return $output;
    }

    public function textField( $args ) {
        $name = $args['label_for'];
        $option_name = $args['option_name']; 
        $value = '';

        if ( isset($_POST["edit_taxonomy"]) ) {
            $input = get_option( $option_name );
            $value = $input[$_POST["edit_taxonomy"]][$name];
        }

        echo '<input type="text" class="regular-text" name="' . $option_name . '[' . $name . ']" 
        id="'.$name.'" value="'.$value.'" placeholder="'.$args['placeholder'].'" required>';
    }

    // public function iconField( $args ) {
    //     $name = $args['label_for'];
    //     $option_name = $args['option_name']; 
    //     $value = '';

    //     if ( isset($_POST["edit_post"]) ) {
    //         $input = get_option( $option_name );
    //         $value = $input[$_POST["edit_post"]][$name];
    //     }

    //     echo '<input type="text" class="regular-text" name="' . $option_name . '[' . $name . ']" 
    //     id="'.$name.'" value="'.$value.'" placeholder="'.$args['placeholder'].'">';
    // }

    // public function numberField( $args ) {
    //     $name = $args['label_for'];
    //     $option_name = $args['option_name']; 
    //     $value = '';

    //     if ( isset($_POST["edit_post"]) ) {
    //         $input = get_option( $option_name );
    //         $value = $input[$_POST["edit_post"]][$name];
    //     }

    //     echo '<input type="text" class="regular-text" name="' . $option_name . '[' . $name . ']" 
    //     id="'.$name.'" value="'.$value.'" placeholder="'.$args['placeholder'].'" >';
    // }

    public function checkboxField( $args ) {
        $name = $args['label_for'];
        $classes = $args['class'];
        $option_name = $args['option_name']; 
        $checked = false;
        

        if ( isset( $_POST["edit_taxonomy"]) ) {
            $checkbox = get_option( $option_name );
            $checked = isset( $checkbox[$_POST["edit_taxonomy"]][$name] ) ?: false;

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
    
    public function checkboxPostTypesField( $args ) {
        $output = '';
        $name = $args['label_for'];
        $classes = $args['class'];
        $option_name = $args['option_name']; 
        $checked = false;
        if ( isset( $_POST["edit_taxonomy"]) ) {
            $checkbox = get_option( $option_name );
        }
        $post_types = get_post_types( array( 'show_ui' => true ) );
        foreach( $post_types as $post) {
            if ( isset( $_POST["edit_taxonomy"]) ) {
                $checked = isset( $checkbox[$_POST["edit_taxonomy"]][$name][$post] ) ?: false;
            }
            $output .= '<div class="'.$classes.' mb-10">
                            <input 
                                type="checkbox" 
                                name="' . $option_name . '[' . $name . '][' . $post . ']" 
                                id="'.$post.'" 
                                value="1" 
                                class="" 
                                '.( $checked ? 'checked' : '').'
                            >
                            <label for="'.$post.'">
                                <div>
                                </div>
                            </label>
                            <strong>' .$post.'</strong>
                        </div>';
        }
        echo $output;
    }
}

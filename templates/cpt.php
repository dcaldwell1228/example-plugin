<div class="wrap">
    <h1>CPT Manager</h1>
    <?php settings_errors(); ?>
    <br/>
    <ul class="nav nav-tabs">
        <li class="<?php echo !isset($_POST["edit_post"]) ? 'active' : '' ?>">
            <a href="#tab-1">Your Custom Post Types</a>
        </li>
        <li class="<?php echo isset($_POST["edit_post"]) ? 'active' : '' ?>">
            <a href="#tab-2"><?php echo isset($_POST["edit_post"]) ? 'Edit' : 'Add' ?> Custom Post Type</a>
        </li>
        <li>
            <a href="#tab-3">Export</a>
        </li>
    </ul>
    <div class="tab-content">
        <div id="tab-1" class="tab-pane <?php echo !isset($_POST["edit_post"]) ? 'active' : '' ?>">
            <h3>Manage your custom post types</h3>
            <?php 
                // if ( ! get_option( 'dillon_plugin_cpt' ) ) {
                //     $options =array();
                // } else {
                //     $options = get_option('dillon_plugin_cpt');
                // }
                // shorthand of the if else statment above
                //$options = ! get_option( 'dillon_plugin_cpt' ) ? array() : get_option('dillon_plugin_cpt');
                $options = get_option( 'dillon_plugin_cpt' ) ?: array();
                echo '<table class="cpt-table">
                        <tr>
                            <th>ID</th>
                            <th>Singular Name</th>
                            <th>Plural Name</th>
                            <th class="text-center">Public</th>
                            <th class="text-center">Archive</th>
                            <th class="text-center">Menu Position</th>
                            <th class="text-center">Actions</th>
                        </tr>';
                foreach ($options as $option) {
                    $public = isset($option['public']) ? "TRUE" : "FALSE";
                    $archive = isset($option['has_archive']) ? "TRUE" : "FALSE";
                    $hierarchical = isset($option['hierarchical']) ? "TRUE" : "FALSE";
                    $show_ui = isset($option['show_ui']) ? "TRUE" : "FALSE";
                    $show_in_menu = isset($option['show_in_menu']) ? "TRUE" : "FALSE";
                    $show_in_admin_bar = isset($option['show_in_admin_bar']) ? "TRUE" : "FALSE";
                    $show_in_nav_menus = isset($option['show_in_nav_menus']) ? "TRUE" : "FALSE";
                    $can_export = isset($option['can_export']) ? "TRUE" : "FALSE";
                    $exclude_from_search = isset($option['exclude_from_search']) ? "TRUE" : "FALSE";
                    $publicly_queryable = isset($option['publicly_queryable']) ? "TRUE" : "FALSE";
                    $menu_position = $option['menu_position'] ?: 25;

                    echo "<tr>
                            <td>{$option['post_type']}</td>
                            <td>{$option['singular_name']}</td>
                            <td>{$option['plural_name']}</td>
                            <td class=\"text-center\">{$public}</td>
                            <td class=\"text-center\">{$archive}</td>
                            <td class=\"text-center\">{$menu_position}</td>
                            <td class=\"text-center\">" ;
                            //edit button
                            echo '<form method="post" action="" class="inline-block">';
                                echo '<input type="hidden" name="edit_post" value="'.$option['post_type'].'" >';
                                submit_button( 'Edit', 'primary small', 'submit', false ); 
                            echo '</form> ';
                            //delete button
                            echo ' <form method="post" action="options.php" class="inline-block">';
                                settings_fields( 'dillon_plugin_cpt_settings' );
                            echo '<input type="hidden" name="remove" value="'.$option['post_type'].'" >';
                                submit_button( 'Delete', 'delete small', 'submit', false, array(
                                    'onclick' => 'return confirm("Are you sure you want to delete this custom post type? The data associated with it will not be deleted.");'
                                )); 
                        
                        echo '</form></td></tr>';
                }
                echo '</table>';
            ?>
        </div> <!-- End #tab-1 -->
        <div id="tab-2" class="tab-pane <?php echo isset($_POST["edit_post"]) ? 'active' : '' ?>">
            
            <form method="post" action="options.php">
                <?php
                    settings_fields( 'dillon_plugin_cpt_settings' );
                    do_settings_sections( 'dillon_cpt' ); //section page
                    submit_button();
                ?>
            </form>
        </div> <!-- End #tab-2 -->
        <div id="tab-3" class="tab-pane">
            <h3>Export your custom post types</h3>
            <?php foreach ($options as $option) { ?>

                <h3><?php echo $option['singular_name']; ?></h3>

                <pre class="prettyprint ">
                // Register Custom Post Type
                function custom_post_type() {
                
                    $labels = array(
                        'name'                  => _x( '<?php echo $option['post_type']; ?>' ),
                        'singular_name'         => _x( '<?php echo $option['singular_name']; ?>' ),
                        'menu_name'             => __( '<?php echo $option['plural_name']; ?>' ),
                        'plural_name'           => __( '<?php echo $option['plural_name']; ?>' ),
                        'name_admin_bar'        => __( '<?php echo $option['singular_name']; ?>' ),
                        'archives'              => __( '<?php echo $option['singular_name'] . ' Archives'; ?>' ),
                        'attributes'            => __( '<?php echo $option['singular_name'] . ' Attributes'; ?>' ),
                        'parent_item_colon'     => __( '<?php echo 'Parent ' .$option['singular_name']; ?>' ),
                        'all_items'             => __( '<?php echo 'All ' .$option['plural_name']; ?>' ),
                        'add_new_item'          => __( '<?php echo 'Add New ' .$option['singular_name']; ?>' ),
                        'add_new'               => __( 'Add New'),
                        'new_item'              => __( '<?php echo 'New ' .$option['singular_name']; ?>' ),
                        'edit_item'             => __( '<?php echo 'Edit ' .$option['singular_name']; ?>' ),
                        'update_item'           => __( '<?php echo 'Update ' .$option['singular_name']; ?>' ),
                        'view_item'             => __( '<?php echo 'View ' .$option['singular_name']; ?>' ),
                        'view_items'            => __( '<?php echo 'View ' .$option['plural_name']; ?>' ),
                        'search_items'          => __( '<?php echo 'Search ' .$option['plural_name']; ?>' ),
                        'not_found'             => __( '<?php echo 'No ' . $option['singular_name'] . ' Found'; ?>' ),
                        'not_found_in_trash'    => __( '<?php echo 'No ' . $option['singular_name'] . ' Found in Trash'; ?>' ),
                        'featured_image'        => __( 'Featured Image'),
                        'set_featured_image'    => __( 'Set featured image'),
                        'remove_featured_image' => __( 'Remove featured image'),
                        'use_featured_image'    => __( 'Use as featured image'),
                        'insert_into_item'      => __( '<?php echo 'Insert into ' .$option['singular_name']; ?>' ),
                        'uploaded_to_this_item' => __( '<?php echo 'Upload to this ' .$option['singular_name']; ?>' ),
                        'items_list'            => __( '<?php echo $option['plural_name'].' List'; ?>' ),
                        'items_list_navigation' => __( '<?php echo $option['plural_name'].' List Navigation'; ?>' ),
                        'filter_items_list'     => __( '<?php echo 'Filter ' . $option['plural_name'] . ' List'; ?>' ),
                    );
                    $args = array(
                        'label'                 => __( '<?php echo $option['singular_name']; ?>' ),
                        'description'           => __( '<?php echo $option['plural_name'].' Custom Post Type'; ?>' ),
                        'menu_icon'             => __( '<?php echo $option['menu_icon'] ?: 'dashicons-admin-post'; ?>' ),
                        'labels'                => $labels,
                        'supports'              => array( 'title', 'editor', 'thumbnail' ),
                        'show_in_rest'          => true,    
                        'taxonomies'            => array( 'category', 'post_tag' ),
                        'hierarchical'          => <?php echo isset($option['hierarchical']) ? "true" : "false"; ?>,
                        'public'                => <?php echo isset($option['public']) ? "true" : "false"; ?>,
                        'show_ui'               => true,
                        'show_in_menu'          => true,
                        'menu_position'         => <?php echo $option['menu_position'] ?: 25; ?>,
                        'show_in_admin_bar'     => true,
                        'show_in_nav_menus'     => true,
                        'can_export'            => true,
                        'has_archive'           => <?php echo isset($option['has_archive']) ? "true" : "false"; ?>,
                        'exclude_from_search'   => <?php echo isset($option['exclude_from_search']) ? "true" : "false"; ?>,
                        'publicly_queryable'    => <?php echo isset($option['publicly_queryable']) ? "true" : "false"; ?>,
                        'capability_type'       => 'post',
                    );
                register_post_type( '<?php echo $option['post_type']; ?>', $args );
                }
                add_action( 'init', 'custom_post_type', 0 );
                </pre>
            <?php } ?> <!-- End foreach-->
        </div> <!-- End #tab-3 -->
    </div> <!-- End .tab-content -->
</div> <!-- end .wrap -->
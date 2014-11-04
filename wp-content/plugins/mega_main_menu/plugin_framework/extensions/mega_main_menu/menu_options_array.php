<?php
/**
 * @package MegaMain
 * @subpackage MegaMain
 * @since mm 1.0
 */

    function mmpm_menu_options_array(){
        $post_types = get_post_types( $args = array( 'public' => true, 'exclude_from_search' => false ), 'names' );
        unset( $post_types['attachment'] );

        $additional_styles_presets = mmpm_get_option( 'additional_styles_presets' );
        unset( $additional_styles_presets['0'] );
        $additional_styles[ __( 'Default', MMPM_TEXTDOMAIN_ADMIN ) ] = false;
        if ( is_array( $additional_styles_presets ) ) {
            foreach ( $additional_styles_presets as $key => $value) {
                $additional_styles[ $key . '. ' . $value['style_name'] ] = 'additional_style_' . $key;
            }
        }

        $options = array(
/* for better times
                array(
                    'key' => 'show_mega_options',
                    'type' => 'select',
                    'values' => array(
                        __( 'Hide Mega Options', MMPM_TEXTDOMAIN_ADMIN ) => 'false',
                        __( 'Show Mega Options', MMPM_TEXTDOMAIN_ADMIN ) => 'true',
                    ),
                    'dependency' => array(
                        'element' => array( 
                            'item_icon', 
                            'disable_text', 
                            'disable_link',
                            'disable_icon',
                            'submenu_type',
                            'submenu_drops_side',
                            'submenu_disable_icons',
                            'submenu_enable_full_width',
                            'submenu_columns',
                            'submenu_custom_content',
                        ),
                        'value' => 'true',
                    ),
                ),
*/
                array(
                    'descr' => __( 'Icon of This item', MMPM_TEXTDOMAIN_ADMIN ),
                    'key' => 'item_icon',
                    'type' => 'icons',
                ),
                array(
                    'key' => 'disable_icon',
                    'type' => 'checkbox',
                    'values' => array(
                        __( 'Hide Icon of This Item', MMPM_TEXTDOMAIN_ADMIN ) => 'true',
                    ),
                ),
                array(
                    'key' => 'disable_text',
                    'type' => 'checkbox',
                    'values' => array(
                        __( 'Hide Text of This Item', MMPM_TEXTDOMAIN_ADMIN ) => 'true',
                    ),
                ),
                array(
                    'key' => 'disable_link',
                    'type' => 'checkbox',
                    'values' => array(
                        __( 'Disable Link', MMPM_TEXTDOMAIN_ADMIN ) => 'true',
                    ),
                ),
                array(
                    'name' => __( 'Options of Dropdown', MMPM_TEXTDOMAIN_ADMIN ),
                    'descr' => __( 'Submenu Type', MMPM_TEXTDOMAIN_ADMIN ),
                    'key' => 'submenu_type',
                    'type' => 'select',
                    'values' => array(
                        __( 'Standard Dropdown', MMPM_TEXTDOMAIN_ADMIN ) => 'default_dropdown',
                        __( 'Multicolumn Dropdown', MMPM_TEXTDOMAIN_ADMIN ) => 'multicolumn_dropdown',
                        __( 'Grid Dropdown', MMPM_TEXTDOMAIN_ADMIN ) => 'grid_dropdown',
                        __( 'Posts Grid Dropdown', MMPM_TEXTDOMAIN_ADMIN ) => 'post_type_dropdown',
                        __( 'Widgets First Area Dropdown', MMPM_TEXTDOMAIN_ADMIN ) => 'widgets_first_dropdown',
                        __( 'Widgets Second Area Dropdown', MMPM_TEXTDOMAIN_ADMIN ) => 'widgets_second_dropdown',
/* for better times
                        __( 'Custom Content Dropdown', MMPM_TEXTDOMAIN_ADMIN ) => 'custom_dropdown',
*/
                    ),
                    'dependency' => array(
                        'element' => array( 
                            'submenu_post_type', 
                        ),
                        'value' => 'post_type_dropdown',
                    ),

               ),
                array(
                    'key' => 'submenu_post_type',
                    'descr' => __( 'Post Type For Display In Dropdown', MMPM_TEXTDOMAIN_ADMIN ),
                    'type' => 'select',
                    'values' => $post_types,
                ),
                array(
                    'key' => 'submenu_drops_side',
                    'descr' => __( 'Side of dropdown elements', MMPM_TEXTDOMAIN_ADMIN ),
                    'type' => 'select',
                    'values' => array(
                        __( 'Drop To Right Side', MMPM_TEXTDOMAIN_ADMIN ) => 'drop_to_right',
                        __( 'Drop To Left Side', MMPM_TEXTDOMAIN_ADMIN ) => 'drop_to_left',
                        __( 'Drop To Center', MMPM_TEXTDOMAIN_ADMIN ) => 'drop_to_center',
                    ),
                ),
                array(
                    'descr' => __( 'Submenu Columns (Not For Standard Drops)', MMPM_TEXTDOMAIN_ADMIN ),
                    'key' => 'submenu_columns',
                    'type' => 'select',
                    'values' => range(1, 10),
                ),
/* for better times
                array(
                    'key' => 'submenu_disable_icons',
                    'type' => 'checkbox',
                    'values' => array(
                        __( 'Disable Submenu Icons', MMPM_TEXTDOMAIN_ADMIN ) => 'true',
                    ),
                ),
*/
                array(
                    'key' => 'submenu_enable_full_width',
                    'type' => 'checkbox',
                    'values' => array(
                        __( 'Enable Full Width Dropdown (only for horizontal menu)', MMPM_TEXTDOMAIN_ADMIN ) => 'true',
                    ),
                ),
/* for better times
                array(
                    'descr' => __( 'Custom Content (Shorcodes supported, only for "Multicolumn" and "Custom" Dropdown)', MMPM_TEXTDOMAIN_ADMIN ),
                    'key' => 'submenu_custom_content',
                    'type' => 'textarea',
                    'values' => '',
                ),
*/
                array(
                    'name' => __( 'Dropdown Background Image', MMPM_TEXTDOMAIN_ADMIN ),
                    'descr' => __( '', MMPM_TEXTDOMAIN_ADMIN ),
                    'key' => 'submenu_bg_image',
                    'type' => 'background_image',
                    'default' => '',
                ),
        );

        if ( count( $additional_styles ) > 1 ) {
            array_unshift( 
                $options, 
                array(
                    'descr' => __( 'Style of This Item', MMPM_TEXTDOMAIN_ADMIN ),
                    'key' => 'item_style',
                    'type' => 'select',
                    'values' => $additional_styles,
                )
            );
        }

        return $options;
    }
?>
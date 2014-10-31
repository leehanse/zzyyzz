<?php
/**
 * Include and setup custom metaboxes and fields. (make sure you copy this file to outside the CMB directory)
 *
 * @category YourThemeOrPlugin
 * @package  Metaboxes
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     https://github.com/webdevstudios/Custom-Metaboxes-and-Fields-for-WordPress
 */

/**
 * Get the bootstrap! If using the plugin from wordpress.org, REMOVE THIS!
 */

/**
 * Conditionally displays a field when used as a callback in the 'show_on_cb' field parameter
 *
 * @param  CMB2_Field object $field Field object
 *
 * @return bool                     True if metabox should show
 */
if(!function_exists('cmb2_hide_if_no_cats')){
    function cmb2_hide_if_no_cats( $field ) {
            // Don't show this field if not in the cats category
            if ( ! has_tag( 'cats', $field->object_id ) ) {
                    return false;
            }
            return true;
    }
}

add_filter( 'cmb2_meta_boxes', 'cmb2_main_page_mataboxes' );
/**
 * Define the metabox and field configurations.
 *
 * @param  array $meta_boxes
 * @return array
 */
function cmb2_main_page_mataboxes( array $meta_boxes ) {

    // Start with an underscore to hide fields from custom fields list
    $prefix = '_main_page_';

    /**
     * Sample metabox to demonstrate each field type included
     */
    $meta_boxes['main_page_metabox'] = array(
            'id'            => 'main_page_metabox',
            'title'         => __( 'Page Options', 'cmb2' ),
            'object_types'  => array( 'page', ), // Post type
            'context'       => 'normal',
            'priority'      => 'high',
            'show_names'    => true, // Show field names on the left
            //'show_on' => array( 'key' => 'page-template', 'value' => 'page-templates/home.php' ),           
            'fields'        => array(
                    array(
                            'name'    => __( 'Header Menu Color', 'cmb2' ),
                            'desc'    => __( 'Header menu color', 'cmb2' ),
                            'id'      => $prefix . 'header_menu_color',
                            'type'    => 'colorpicker',
                            'default' => '#ffffff'
                    )
            ),
    );
    return $meta_boxes;
}

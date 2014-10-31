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

add_filter( 'cmb2_meta_boxes', 'cmb2_home_page_mataboxes' );
/**
 * Define the metabox and field configurations.
 *
 * @param  array $meta_boxes
 * @return array
 */
function cmb2_home_page_mataboxes( array $meta_boxes ) {

    // Start with an underscore to hide fields from custom fields list
    $prefix = '_home_page_';

    /**
     * Sample metabox to demonstrate each field type included
     */
    $meta_boxes['field_group'] = array(
		'id'           => 'field_group',
		'title'        => __( 'Repeating Field Group', 'cmb2' ),
		'object_types' => array( 'page'),
                'show_on' => array( 'key' => 'page-template', 'value' => 'page-templates/home.php' ),           
		'fields'       => array(
			array(
				'id'          => $prefix . 'repeat_group',
				'type'        => 'group',
				'description' => __( 'Generates reusable form entries', 'cmb2' ),
				'options'     => array(
					'group_title'   => __( 'Entry {#}', 'cmb2' ), // {#} gets replaced by row number
					'add_button'    => __( 'Add Another Entry', 'cmb2' ),
					'remove_button' => __( 'Remove Entry', 'cmb2' ),
					'sortable'      => true, // beta
				),
				// Fields array works the same, except id's only need to be unique for this group. Prefix is not needed.
				'fields'      => array(
					array(
						'name' => 'Entry Title',
						'id'   => 'title',
						'type' => 'text',
						// 'repeatable' => true, // Repeatable fields are supported w/in repeatable groups (for most types)
					),
					array(
						'name' => 'Description',
						'description' => 'Write a short description for this entry',
						'id'   => 'description',
						'type' => 'textarea_small',
					),
					array(
						'name' => 'Entry Image',
						'id'   => 'image',
						'type' => 'file',
					),
					array(
						'name' => 'Image Caption',
						'id'   => 'image_caption',
						'type' => 'text',
					),
				),
			),
		),
	);    
    $meta_boxes['home_page_metabox'] = array(
            'id'            => 'home_page_metabox',
            'title'         => __( 'Home Page Options', 'cmb2' ),
            'object_types'  => array( 'page', ), // Post type
            'context'       => 'normal',
            'priority'      => 'high',
            'show_names'    => true, // Show field names on the left
            //'show_on' => array( 'key' => 'page-template', 'value' => 'page-templates/home.php' ),           
            'fields'        => array(
                    array(
                            'name'    => __( 'Banners', 'cmb2' ),
                            'desc'    => __( 'All banner images', 'cmb2' ),
                            'id'      => $prefix . 'header_menu_color',
                            'type'    => 'colorpicker',
                            'default' => '#ffffff'
                    )
            ),
    );
    return $meta_boxes;
}

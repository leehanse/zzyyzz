<?php
$prefix = 'imbibe_home_page_template_';

global $meta_boxes_home_page_template;
$meta_boxes_home_page_template   = array();
$meta_boxes_home_page_template[] = array(
	'id'     => 'homepage_takeover',
	'title'  => 'Homepage Takeover',
	'pages'  => array( 'page' ),
	'fields' => array(
		// IMAGE UPLOAD
                array(
			'name' => 'Active Using Ads',
			'id'   => "{$prefix}active_ads",
			'type' => 'checkbox',
			'std'  => 1,
		),
		array(
			'name' => __( 'Ads Image', 'rwmb' ),
			'id'   => "{$prefix}ads_image",
			'type' => 'image',
		),
	),
);

$meta_boxes_home_page_template[] = array(
	'id'     => 'homepage_sidebar',
	'title'  => 'Home Page Slide Bar',
	'pages'  => array( 'page' ),
	'fields' => array(
		// IMAGE UPLOAD
		array(
			'name' => __( 'Side Bar Image', 'rwmb' ),
			'id'   => "{$prefix}sidebar_image",
			'type' => 'plupload_image',
		),
	),
);
                        
                        
/**
 * Register meta boxes
 *
 * @return void
 */
function imbibe_register_meta_boxes_home_page_template()
{
	global $meta_boxes_home_page_template;

	// Make sure there's no errors when the plugin is deactivated or during upgrade
	if ( ! class_exists( 'RW_Meta_Box' ) )
		return;

	// Register meta boxes only for some posts/pages
	if ( ! imbibe_home_page_maybe_include() )
		return;

	foreach ( $meta_boxes_home_page_template as $meta_box )
	{
		new RW_Meta_Box( $meta_box );
	}
}

add_action( 'admin_init', 'imbibe_register_meta_boxes_home_page_template' );

/**
 * Check if meta boxes is included
 *
 * @return bool
 */
function imbibe_home_page_maybe_include()
{
	// Include in back-end only
	if ( ! defined( 'WP_ADMIN' ) || ! WP_ADMIN )
		return false;

	// Always include for ajax
	if ( defined( 'DOING_AJAX' ) && DOING_AJAX )
		return true;

	if ( isset( $_GET['post'] ) )
		$post_id = $_GET['post'];
	elseif ( isset( $_POST['post_ID'] ) )
		$post_id = $_POST['post_ID'];
	else
		$post_id = false;

	$post_id = (int) $post_id;

	// Check for page template
	$checked_templates = array('page-templates/home.php');

	$template = get_post_meta( $post_id, '_wp_page_template', true );
	if ( in_array( $template, $checked_templates ) ){
		return true;
        }
	// If no condition matched
	return false;
}
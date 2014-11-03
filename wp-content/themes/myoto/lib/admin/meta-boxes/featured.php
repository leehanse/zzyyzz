<?php
$prefix = 'imbibe_is_featured_';

global $meta_boxes_is_featured;

$post_types = get_post_types();

$meta_boxes_is_featured   = array();
$meta_boxes_is_featured[] = array(
	'id'       => 'is_featured',
	'title'    => 'Is Featured',
	'pages'    => $post_types,
        'context'  => 'side',
        'priority' => 'low',
	'fields'   => array(
                array(
			'name'     => '',
			'id'       => "{$prefix}is_featured",
			'type'     => 'select',
			// Array of 'value' => 'Label' pairs for select box
			'options'  => array(
				0 => 'Not Featured',
				1 => 'Is Featured',
			),
			// Select multiple values, optional. Default is false.
			'multiple'    => false,
			'std'         => 0			
		)
	),
);

/**
 * Register meta boxes
 *
 * @return void
 */
function imbibe_register_meta_boxes_is_featured()
{
	global $meta_boxes_is_featured;

	foreach ( $meta_boxes_is_featured as $meta_box )
	{
		new RW_Meta_Box( $meta_box );
	}
}

add_action( 'admin_init', 'imbibe_register_meta_boxes_is_featured' );

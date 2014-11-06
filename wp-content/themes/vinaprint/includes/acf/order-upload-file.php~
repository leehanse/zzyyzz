<?php

if(function_exists("register_field_group"))
{
	register_field_group(array (
		'id' => 'acf_order-upload-file',
		'title' => 'Order Upload File',
		'fields' => array (
			array (
				'key' => 'field_545a397db97c1',
				'label' => 'Product Upload File List',
				'name' => 'product_upload_file_list',
				'type' => 'repeater',
				'required' => 1,
				'sub_fields' => array (
					array (
						'key' => 'field_545a39d9b97c2',
						'label' => 'Product',
						'name' => 'product',
						'type' => 'post_object',
						'required' => 1,
						'column_width' => '',
						'post_type' => array (
							0 => 'product',
						),
						'taxonomy' => array (
							0 => 'all',
						),
						'allow_null' => 0,
						'multiple' => 0,
					),
					array (
						'key' => 'field_545a39fcb97c3',
						'label' => 'File Upload',
						'name' => 'file_upload',
						'type' => 'file',
						'required' => 1,
						'column_width' => '',
						'save_format' => 'object',
						'library' => 'all',
					),
				),
				'row_min' => '',
				'row_limit' => '',
				'layout' => 'table',
				'button_label' => 'Add Row',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'shop_order',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'default',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));
}
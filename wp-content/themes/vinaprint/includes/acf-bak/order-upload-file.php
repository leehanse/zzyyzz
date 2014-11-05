<?php
if(function_exists("register_field_group"))
{
	register_field_group(array (
		'id' => 'acf_order-upload-files',
		'title' => 'Order Upload Files',
		'fields' => array (
			array (
				'key' => 'order_upload_file_key',
				'label' => 'Order Upload File',
				'name' => 'order_upload_file',
				'type' => 'repeater',
				'sub_fields' => array (
					array (
						'key' => 'order_upload_file_product',
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
						'key' => 'order_upload_file_file_list',
						'label' => 'File List',
						'name' => 'file_list',
						'type' => 'repeater',
						'column_width' => '',
						'sub_fields' => array (
							array (
								'key' => 'order_upload_file_file_list_file',
								'label' => 'File',
								'name' => 'file',
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
						'button_label' => 'Add New File',
					),
				),
				'row_min' => '',
				'row_limit' => '',
				'layout' => 'table',
				'button_label' => 'Add New Upload File To Product',
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

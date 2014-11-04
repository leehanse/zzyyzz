<?php
/**
 * @package MegaMain
 * @subpackage MegaMain
 * @since mm 1.0
 */
	function mmpm_meta_options_array(){
		return array(
			array( // START single element params array
				'key' => 'general', // HTML atribute "id" for metabox
				'title' => __( 'Additional Options', MMPM_TEXTDOMAIN_ADMIN ), // Caption for metabox
				'post_type' => 'all_post_types', // Post types where will be displayed this metabox
				'context' => 'normal', // Position where will be displayed this metabox
				'priority' => 'high', // Priority for this metabox
				'options' => array(
					array(
						'name' => __( 'Post Icon', MMPM_TEXTDOMAIN_ADMIN ),
						'descr' => __( 'Select icon for this post, which will be displayed in the "Post Grid Dropdown Menu"', MMPM_TEXTDOMAIN_ADMIN ),
						'key' => 'post_icon',
						'type' => 'icons',
					),
				), // END element options
			), // END single element params array
		);
	}
?>
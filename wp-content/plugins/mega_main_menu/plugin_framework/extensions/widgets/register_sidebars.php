<?php
/**
 * @package MegaMain
 * @subpackage MegaMain
 * @since mm 1.0
 */

	register_sidebar(
		array(
			'name' => __( MMPM_PLUGIN_NAME . ' First Widgets', MMPM_TEXTDOMAIN_ADMIN  ),
			'id'=> MMPM_PREFIX . '_menu_first_widgets_area',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<div class="widgettitle">',
			'after_title' => '</div>',
		)
	);
	register_sidebar(
		array(
			'name' => __( MMPM_PLUGIN_NAME . ' Second Widgets', MMPM_TEXTDOMAIN_ADMIN  ),
			'id'=> MMPM_PREFIX . '_menu_second_widgets_area',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<div class="widgettitle">',
			'after_title' => '</div>',
		)
	);

?>
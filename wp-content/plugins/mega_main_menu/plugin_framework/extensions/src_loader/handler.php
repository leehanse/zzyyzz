<?php
/**
 * @package MegaMain
 * @subpackage MegaMain
 * @since mm 1.0
 */

	/** 
	 * actions what we need for call all functions in this file.
	 * @return void
	 */
	add_action( 'wp_enqueue_scripts', 'mmpm_load_all_src' );
	add_action( 'admin_enqueue_scripts', 'mmpm_load_all_src', 20, 1 );

	/** 
	 * register and call styles and sctipts for frontend or backend.
	 * @return void
	 */
	function mmpm_load_all_src ( $args ) {
		if ( function_exists( 'wp_script_is' ) && !wp_script_is( 'jquery', 'enqueued' ) ) {
			wp_enqueue_script( 'jquery' );
		}
		if ( is_admin() ) {
			$supported_pages = array( 'appearance_page_' . MMPM_THEME_PAGE_SLUG, 'post.php', 'post-new.php', 'nav-menus.php' );
			if ( !in_array( $args, $supported_pages ) ) {
				return false;
			}
			wp_enqueue_script( 'jquery-ui-sortable' );
			wp_enqueue_script( 'jquery-ui-draggable' );
		}
		// Commonly Used Sources
		$common_theme_css = array(
			MMPM_PREFIX . '_icomoon' => MMPM_CSS_URI . '/external/icomoon.css',
			MMPM_PREFIX . '_font-awesome' => MMPM_CSS_URI . '/external/font-awesome.css',
		);
		$common_theme_js = array(
		);
		if ( is_admin() ) { // Sources for wp-admin
			$additional_css = array(
				MMPM_PREFIX . '_bootstrap' => MMPM_CSS_URI . '/external/bootstrap.css',
				MMPM_PREFIX . '_colorpicker' => MMPM_CSS_URI . '/external/colorpicker.css',
				MMPM_PREFIX . '_backend_general' => MMPM_CSS_URI . '/backend/common.css',
				MMPM_PREFIX . '_icons_modal' => MMPM_CSS_URI . '/backend/icons_modal.css',
			);
			$additional_js = array(
				MMPM_PREFIX . '_bootstrap' => MMPM_JS_URI . '/external/bootstrap.js',
				MMPM_PREFIX . '_colorpicker' => MMPM_JS_URI . '/external/colorpicker.js',
				MMPM_PREFIX . '_option_generator' => MMPM_JS_URI . '/backend/option_generator.js',
			);
		} else { // Sources for Frontend
			$additional_css = array(
//				MMPM_PREFIX . '_mega_main_menu' => MMPM_CSS_URI . '/frontend/mega_main_menu.css',
			);
			$additional_js = array(
				MMPM_PREFIX . '_menu_functions' => MMPM_JS_URI . '/frontend/menu_functions.js',
			);
		}
		$page_all_css = array_merge( $common_theme_css, $additional_css );
		$page_all_js = array_merge( $common_theme_js, $additional_js );
		foreach ( $page_all_css as $key => $value ) {
			wp_register_style( $key, $value );
			wp_enqueue_style( $key );
		}
		foreach ( $page_all_js as $key => $value ) {
			if ( $value != '' ) {
				wp_register_script( $key, $value );
			}
			wp_enqueue_script( $key );
		}
	}
?>
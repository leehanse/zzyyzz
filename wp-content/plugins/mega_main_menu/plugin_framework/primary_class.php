<?php
/**
 * @package Mega Main Menu
 * @version 1.0.7
 * Primary functions file. Creates and initializes the primary class that calls all the other classes. 
 * Author: MegaMain.com
 * Author URI: http://megamain.com
 */

$mmpm_primary_class = new mmpm_primary_class; // call class below
class mmpm_primary_class {
	public function __construct () {
		// Order of calling functions is very important first-constants, second-mmpm_theme_options, last-extensions_loader!
		@ini_set('max_input_vars', 10000);
		add_action( 'init', array( $this, 'constants' ), 7 );
		add_action( 'init', array( $this, 'mmpm_theme_options' ), 8 );
		add_action( 'init', array( $this, 'extensions_loader' ), 9 );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'widgets' );
	}

	/*
	 * Function sets theme constants.
	 */
	public static function constants() {
		// Set theme primary information.
		define( 'MMPM_PLUGIN_NAME', 'Mega Main Menu' );
		define( 'MMPM_PLUGIN_VERSION', '1.0.7' );
		define( 'MMPM_PLUGIN_SLUG', 'mega_main_menu' );
		// Set theme identificators and prefixes.
		define( 'MMPM_PREFIX', 'mmpm' );
		define( 'MMPM_OPTIONS_NAME', 'options_' . MMPM_PLUGIN_SLUG );
		define( 'MMPM_OPTIONS_DB_NAME', MMPM_PREFIX . '_' . MMPM_OPTIONS_NAME );
		define( 'MMPM_SKIN_NAME', 'skin_' . MMPM_PLUGIN_SLUG );
		define( 'MMPM_SKIN_DB_NAME', MMPM_PREFIX . '_' . MMPM_SKIN_NAME );
		define( 'MMPM_TEXTDOMAIN', MMPM_PLUGIN_SLUG );
		define( 'MMPM_TEXTDOMAIN_ADMIN', MMPM_PLUGIN_SLUG . '_admin' );
		define( 'MMPM_THEME_PAGE_SLUG', MMPM_PREFIX . '_options_' . MMPM_PLUGIN_SLUG );
		// Set theme static locations: directories and files.
		// DIRECTORIES
		define( 'MMPM_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
		define( 'MMPM_EXTENSIONS_DIR', MMPM_PLUGIN_DIR . '/extensions' );
		define( 'MMPM_SRC_DIR', MMPM_PLUGIN_DIR . '../src' );
		define( 'MMPM_CSS_DIR', MMPM_SRC_DIR . '/css' );
		// URI
		define( 'MMPM_PLUGIN_URI', str_replace( '/plugin_framework/', '', plugin_dir_url( __FILE__ ) ) );
		define( 'MMPM_SRC_URI', MMPM_PLUGIN_URI . '/src' );
		define( 'MMPM_CSS_URI', MMPM_SRC_URI . '/css' );
		define( 'MMPM_JS_URI', MMPM_SRC_URI . '/js' );
		define( 'MMPM_FONTS_URI', MMPM_SRC_URI . '/fonts' );
		define( 'MMPM_IMG_URI', MMPM_SRC_URI . '/img' );
		define( 'MMPM_IMAGE_NOT_FOUND', MMPM_PLUGIN_URI . '/src/img/image_not_found.png' );
		define( 'MMPM_NO_IMAGE_AVAILABLE', MMPM_PLUGIN_URI . '/src/img/no_image_available.png' );
	}

	/*
	 * Function sets global theme variable $mmpm_theme_options wherein the stored all theme options for visual appearance.
	 */
	public function mmpm_theme_options () {
		$GLOBALS['mmpm_theme_options'] = get_option( MMPM_OPTIONS_DB_NAME, 'Not saved options' );
//		$GLOBALS['mmpm_theme_skin'] = get_option( MMPM_SKIN_DB_NAME, 'Not saved skin' );
	}

	/*
	 * Function sets global theme variable $mmpm_theme_options wherein the stored all theme options for visual appearance.
	 */

	/*
	 * Function open extensions directory (MMPM_EXTENSIONS_DIR) and load all initialization files (init.php) in subfolders.
	 */
	public function extensions_loader () {
		include_once( MMPM_EXTENSIONS_DIR . '/common_tools/init.php' ); 
		if ( $dir_contents = opendir( MMPM_EXTENSIONS_DIR ) ) {
			while( ( $inner_dir = readdir( $dir_contents ) ) !== false ) {
				if ($inner_dir != "." && $inner_dir != ".." && file_exists( MMPM_EXTENSIONS_DIR . '/' . $inner_dir . '/init.php' ) ) { 
					include_once( MMPM_EXTENSIONS_DIR . '/' . $inner_dir . '/init.php' ); 
				} 
			}
			closedir($dir_contents);
		}
	}
}

?>
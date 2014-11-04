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
	add_action( 'admin_menu', 'mmpm_add_theme_page' );
	add_action( 'admin_init', 'mmpm_register_theme_options' );
	/** 
	 * register page for theme options and addes submenu menu item in appearance menu.
	 * @return void
	 */
	function mmpm_add_theme_page(){
		add_theme_page(
			MMPM_PLUGIN_NAME ,
			__( MMPM_PLUGIN_NAME, MMPM_TEXTDOMAIN_ADMIN ),
			'edit_theme_options',
			MMPM_THEME_PAGE_SLUG,
			'mmpm_theme_options_form'
		);
	}

	/** 
	 * register theme options group and name.
	 * @return void
	 */
	function mmpm_register_theme_options() {
		register_setting( 'mmpm_options_group', MMPM_OPTIONS_DB_NAME );
//		register_setting( 'mmpm_options_group', MMPM_SKIN_DB_NAME );
	}

	/** 
	 * Build theme options page.
	 * @return $out
	 */
	function mmpm_theme_options_form(){
		$out = '';
		$submit_button = mmpm_ntab(7) . '<input type="submit" class="button-primary pull-right" value="' . __( 'Save All Changes', MMPM_TEXTDOMAIN_ADMIN ) . '" />';
		$theme_meta = mmpm_ntab(7) . '<div>' . mmpm_ntab(8) . '<span class="theme_name">' . __( MMPM_PLUGIN_NAME , MMPM_TEXTDOMAIN_ADMIN ) . '</span>' . ' <small>v' . MMPM_PLUGIN_VERSION . mmpm_ntab(7) . '</small></div>';
		$out .= mmpm_ntab(1) . '<div class="wrap bootstrap">';
		$out .= mmpm_ntab(2) . '<div class="'. MMPM_PREFIX . '_theme_page">';
		$out .= mmpm_ntab(3) . '<form method="post" action="options.php" class="'. MMPM_PREFIX . '_theme_options_form">';
		$out .= mmpm_ntab(4) . '<div class="save_shanges row no_x_margin">';
		$out .= mmpm_ntab(5) . '<div class="col-xs-12">';
		$out .= mmpm_ntab(6) . '<div class="float_holder">';
		$out .= $submit_button;
		$out .= $theme_meta;
		$out .= mmpm_ntab(6) . '</div>';
		$out .= mmpm_ntab(5) . '</div>';
		$out .= mmpm_ntab(4) . '</div>';
//		$out .= mmpm_ntab(4) . '<input type="hidden" name="action" value="update" />';
		$out .= mmpm_ntab(4) . '<input type="hidden" name="' . MMPM_OPTIONS_DB_NAME . '[last_modified]" value="' . ( time() + 60 ) . '" />';
		ob_start();
		settings_fields( 'mmpm_options_group' );
		$out .= mmpm_ntab(4) . ob_get_contents();
		ob_end_clean();
		$out .= mmpm_theme_sections_generator();
		$out .= mmpm_ntab(4) . '<div class="save_shanges row no_x_margin">';
		$out .= mmpm_ntab(5) . '<div class="col-xs-12">';
		$out .= mmpm_ntab(6) . '<div class="float_holder">';
		$out .= $submit_button;
		$out .= mmpm_ntab(6) . '</div>';
		$out .= mmpm_ntab(5) . '</div>';
		$out .= mmpm_ntab(4) . '</div>';
		$out .= mmpm_ntab(3) . '</form>';
		$out .= mmpm_ntab(2) . '</div><!--  class="'. MMPM_PREFIX . 'theme_page" -->';
		$out .= mmpm_ntab(1) . '</div><!-- class="wrap" -->';

		echo $out; // general out
	}

	/** 
	 * Build menu items and sections in theme options form.
	 * @return $out
	 */
	function mmpm_theme_sections_generator(){
		$out = '';
		$out .= mmpm_ntab(4) . '<div class="'. MMPM_PREFIX . '_theme_options row bootstrap no_x_margin">';
		$out .= mmpm_ntab(5) . '<ul id="'. MMPM_PREFIX . '_navigation" class="'. MMPM_PREFIX . '_navigation nav nav-tabs col-lg-2 col-sm-3 col-xs-12">';
		foreach ( mmpm_theme_options_array() as $key => $section ) {
			$out .= mmpm_ntab(6) . '<li class="menu_item' . ( ( $key == 0) ? ' active' : '' ) . '">';
			$out .= mmpm_ntab(7) . '<a href="#' . $section['key'] . '" data-toggle="tab"><i class="' . ( ( isset( $section['icon'] ) ) ? $section['icon'] : 'empty-icon' ) . '"></i> ' . $section['title'] . '</a></li>';
			$out .= mmpm_ntab(6) . '</li>';
		}
		$out .= mmpm_ntab(5) . '</ul><!-- class="'. MMPM_PREFIX . '_navigation" -->';
		$out .= mmpm_ntab(5) . '<div id="'. MMPM_PREFIX . '_content" class="tab-content '. MMPM_PREFIX . '_content col-lg-10 col-sm-9 col-xs-12">';
		foreach ( mmpm_theme_options_array() as $key => $section ) {
			$out .= mmpm_ntab(6) . '<div class="tab-pane fade' . ( ( $key == 0) ? ' active in' : '' ) . '" id="' . $section['key'] . '">';
			$mmpm_saved_theme_options = get_option( MMPM_OPTIONS_DB_NAME, array( 'empty' ) );
			foreach ( $section['options'] as $option ) {
				$option['key'] = isset( $option['key'] ) ? $option['key'] : 'key_no_set';
				$mmpm_saved_value = isset( $mmpm_saved_theme_options[ $option[ 'key' ] ] ) 
					? $mmpm_saved_theme_options[ $option[ 'key' ] ] 
					: false;
				$option['key'] = MMPM_OPTIONS_NAME . '[' . $option['key'] . ']';
				$out .= mmpm_options_generator( $option, $mmpm_saved_value );
			}
			$out .= mmpm_ntab(6) . '</div><!-- class="tab-pane fade" id="' . $section['key'] . '" -->';
		}
		$out .= mmpm_ntab(5) . '</div><!-- id="'. MMPM_PREFIX . '_content" class="tab-content" -->';
		$out .= mmpm_ntab(4) . '</div><!-- class="'. MMPM_PREFIX . '_theme_options" -->';
		return $out;
	}

?>
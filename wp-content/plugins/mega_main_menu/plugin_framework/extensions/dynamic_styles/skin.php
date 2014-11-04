<?php
/**
 * @package MegaMain
 * @subpackage MegaMain
 * @since mm 1.0
 */
	global $mmpm_theme_options;
	$mega_menu_locations = is_array( mmpm_get_option( 'mega_menu_locations' ) ) 
		? mmpm_get_option( 'mega_menu_locations' ) 
		: array();
$out = '.empty{}';
	if ( count( $mega_menu_locations ) > 1 ) {
$out .= '
#mega_main_menu .nav_logo > .logo_link > img 
{
	max-height: ' . mmpm_get_option( 'logo_height', '90' ) . '%;
}
';
		array_shift( $mega_menu_locations );
		foreach ( $mega_menu_locations as $key => $location_name ) { 
if ( is_array( mmpm_get_option( 'indefinite_location_mode' ) ) && in_array( 'true', mmpm_get_option( 'indefinite_location_mode' ) ) ) {
		$location_class = '';
} else {
		$location_class = '.' . $location_name;
}

$out .= '/* ' . $location_name . ' */
#mega_main_menu' . $location_class . '
{
	min-height:' . mmpm_get_option( $location_name . '_first_level_item_height' ) . 'px;
}
#mega_main_menu' . $location_class . ' > .menu_holder > .menu_inner > .nav_logo > .logo_link, 
#mega_main_menu' . $location_class . ' > .menu_holder > .menu_inner > .nav_logo > .mobile_toggle, 
#mega_main_menu' . $location_class . ' > .menu_holder > .menu_inner > ul > li > .item_link, 
#mega_main_menu' . $location_class . ' > .menu_holder > .menu_inner > ul > li > .item_link > span, 
#mega_main_menu' . $location_class . ' > .menu_holder > .menu_inner > ul > li.nav_search_box,
#mega_main_menu' . $location_class . '.icons-left > .menu_holder > .menu_inner > ul > li > .item_link > i,
#mega_main_menu' . $location_class . '.icons-right > .menu_holder > .menu_inner > ul > li > .item_link > i,
#mega_main_menu' . $location_class . '.icons-top > .menu_holder > .menu_inner > ul > li > .item_link.disable_icon > span,
#mega_main_menu' . $location_class . '.icons-top > .menu_holder > .menu_inner > ul > li > .item_link.menu_item_without_text > i
{
	height:' . mmpm_get_option( $location_name . '_first_level_item_height' ) . 'px;
	line-height:' . mmpm_get_option( $location_name . '_first_level_item_height' ) . 'px;
}
#mega_main_menu' . $location_class . '.icons-top > .menu_holder > .menu_inner > ul > li > .item_link > i,
#mega_main_menu' . $location_class . '.icons-top > .menu_holder > .menu_inner > ul > li > .item_link > span
{
	height:' . ( $mmpm_theme_options[ $location_name . '_first_level_item_height' ] / 2 ) . 'px;
	line-height:' . ( $mmpm_theme_options[ $location_name . '_first_level_item_height' ] / 3 ) . 'px;
}
#mega_main_menu' . $location_class . '.icons-top > .menu_holder > .menu_inner > ul > li > .item_link > i
{
	padding-top:' . ( $mmpm_theme_options[ $location_name . '_first_level_item_height' ] / 3 / 2 ) . 'px;
}
#mega_main_menu' . $location_class . '.icons-top > .menu_holder > .menu_inner > ul > li > .item_link > span
{
	padding-bottom:' . ( $mmpm_theme_options[ $location_name . '_first_level_item_height' ] / 3 / 2 ) . 'px;
}
#mega_main_menu' . $location_class . ' > .menu_holder
{
	' . mmpm_css_gradient( $mmpm_theme_options[ $location_name . '_menu_bg_gradient' ] ) . '
	' . mmpm_css_bg_image( $mmpm_theme_options[ $location_name . '_menu_bg_gradient' ] ) . '	
}
#mega_main_menu' . $location_class . ' > .menu_holder > .menu_inner > .nav_logo > .mobile_toggle > .mobile_button,
#mega_main_menu' . $location_class . ' > .menu_holder > .menu_inner > ul > li > .item_link,
#mega_main_menu' . $location_class . ' > .menu_holder > .menu_inner > ul > li > .item_link .link_text,
#mega_main_menu' . $location_class . ' > .menu_holder > .menu_inner > ul > li.nav_search_box *,
#mega_main_menu' . $location_class . ' > .menu_holder > .menu_inner > ul > li .post_details > .post_title,
#mega_main_menu' . $location_class . ' > .menu_holder > .menu_inner > ul > li .post_details > .post_title > .item_link
{
	' . mmpm_css_font( $mmpm_theme_options[ $location_name . '_menu_first_level_link_font'] ) . '
}
#mega_main_menu' . $location_class . ' > .menu_holder > .menu_inner > ul > li > .item_link > i
{
	' . mmpm_css_font( $mmpm_theme_options[ $location_name . '_menu_first_level_icon_font'] ) . '
}
#mega_main_menu' . $location_class . '.icons-right > .menu_holder > .menu_inner > ul > li > .item_link > i:before,
#mega_main_menu' . $location_class . '.icons-left > .menu_holder > .menu_inner > ul > li > .item_link > i:before
{	
	width:' . $mmpm_theme_options[ $location_name . '_menu_first_level_icon_font']['font_size'] . 'px;
}
#mega_main_menu' . $location_class . ' > .menu_holder > .menu_inner > .nav_logo > .mobile_toggle > .mobile_button,
#mega_main_menu' . $location_class . ' > .menu_holder > .menu_inner > ul > li > .item_link,
#mega_main_menu' . $location_class . ' > .menu_holder > .menu_inner > ul > li > .item_link *
{
	color: ' . $mmpm_theme_options[ $location_name . '_menu_first_level_link_color'] . ';
}
#mega_main_menu' . $location_class . ' > .menu_holder > .menu_inner > ul > li > .item_link
{
	' . mmpm_css_gradient( $mmpm_theme_options[ $location_name . '_menu_first_level_link_bg'] ) . '
}
#mega_main_menu' . $location_class . ' > .menu_holder > .menu_inner > ul > li:hover > .item_link,
#mega_main_menu' . $location_class . ' > .menu_holder > .menu_inner > ul > li > .item_link:hover,
#mega_main_menu' . $location_class . ' > .menu_holder > .menu_inner > ul > li.current-menu-ancestor > .item_link,
#mega_main_menu' . $location_class . ' > .menu_holder > .menu_inner > ul > li.current-menu-item > .item_link
{
	' . mmpm_css_gradient( $mmpm_theme_options[ $location_name . '_menu_first_level_link_bg_hover'] ) . '
}
#mega_main_menu' . $location_class . ' > .menu_holder > .menu_inner > ul > li.nav_search_box > #mega_main_menu_searchform
{
	background-color:' . $mmpm_theme_options[ $location_name . '_menu_search_bg'] . ';
}
#mega_main_menu' . $location_class . ' > .menu_holder > .menu_inner > ul > li.nav_search_box .field,
#mega_main_menu' . $location_class . ' > .menu_holder > .menu_inner > ul > li.nav_search_box .field::-webkit-input-placeholder,
#mega_main_menu' . $location_class . ' > .menu_holder > .menu_inner > ul > li.nav_search_box *,
#mega_main_menu' . $location_class . ' > .menu_holder > .menu_inner > ul > li .icosearch
{
	color: ' . $mmpm_theme_options[ $location_name . '_menu_search_color'] . ';
}
#mega_main_menu' . $location_class . ' > .menu_holder > .menu_inner > ul > li:hover > .item_link,
#mega_main_menu' . $location_class . ' > .menu_holder > .menu_inner > ul > li > .item_link:hover,
#mega_main_menu' . $location_class . ' > .menu_holder > .menu_inner > ul > li:hover > .item_link *,
#mega_main_menu' . $location_class . ' > .menu_holder > .menu_inner > ul > li.current-menu-ancestor > .item_link *,
#mega_main_menu' . $location_class . ' > .menu_holder > .menu_inner > ul > li.current-menu-item > .item_link *
{
	color: ' . $mmpm_theme_options[ $location_name . '_menu_first_level_link_color_hover'] . ';
}
#mega_main_menu' . $location_class . ' > .menu_holder > .menu_inner > ul > li.default_dropdown .mega_dropdown,
#mega_main_menu' . $location_class . ' > .menu_holder > .menu_inner > ul > li > .mega_dropdown,
#mega_main_menu' . $location_class . ' > .menu_holder > .menu_inner > ul > li .mega_dropdown > li .post_details
{
	' . mmpm_css_gradient( $mmpm_theme_options[ $location_name . '_menu_dropdown_wrapper_gradient'] ) . '
}
#mega_main_menu' . $location_class . ' ul > li.default_dropdown .mega_dropdown ul.mega_dropdown > li:first-child > .item_link:after
{
	background-color: ' . $mmpm_theme_options[ $location_name . '_menu_dropdown_wrapper_gradient']['color1'] . '
}
#mega_main_menu' . $location_class . ' ul li .mega_dropdown > li > .item_link,
#mega_main_menu' . $location_class . ' ul li .mega_dropdown > li > .item_link .link_text,
#mega_main_menu' . $location_class . ' ul li .mega_dropdown,
#mega_main_menu' . $location_class . ' > .menu_holder > .menu_inner > ul > li .post_details > .post_description
{
	' . mmpm_css_font( $mmpm_theme_options[ $location_name . '_menu_dropdown_link_font'] ) . '
}
#mega_main_menu' . $location_class . ' ul li.default_dropdown .mega_dropdown > li > .item_link,
#mega_main_menu' . $location_class . ' ul li.multicolumn_dropdown .mega_dropdown > li > .item_link,
#mega_main_menu' . $location_class . ' ul li.grid_dropdown .mega_dropdown > li > .item_link
{
	' . mmpm_css_gradient( $mmpm_theme_options[ $location_name . '_menu_dropdown_link_bg'] ) . '
	color: ' . $mmpm_theme_options[ $location_name . '_menu_dropdown_link_color'] . ';
}
#mega_main_menu' . $location_class . ' > .menu_holder > .menu_inner > ul > li .post_details > .post_icon > i,
#mega_main_menu' . $location_class . ' ul li.default_dropdown .mega_dropdown > li > .item_link *,
#mega_main_menu' . $location_class . ' ul li.multicolumn_dropdown .mega_dropdown > li > .item_link *
#mega_main_menu' . $location_class . ' ul li.grid_dropdown .mega_dropdown > li > .item_link *,
#mega_main_menu' . $location_class . ' ul li li .post_details a
{
	color: ' . $mmpm_theme_options[ $location_name . '_menu_dropdown_link_color'] . ';
}
#mega_main_menu' . $location_class . ' ul li.default_dropdown .mega_dropdown > li > .item_link
{
	border-color: ' . $mmpm_theme_options[ $location_name . '_menu_dropdown_link_border_color'] . ';
}
#mega_main_menu' . $location_class . ' ul li.default_dropdown .mega_dropdown > li:hover > .item_link,
#mega_main_menu' . $location_class . ' ul li.default_dropdown .mega_dropdown > li > .item_link:hover,
#mega_main_menu' . $location_class . ' ul li.default_dropdown .mega_dropdown > li.current-menu-item > .item_link,
#mega_main_menu' . $location_class . ' ul li.multicolumn_dropdown .mega_dropdown > li > .item_link:hover,
#mega_main_menu' . $location_class . ' ul li.multicolumn_dropdown .mega_dropdown > li.current-menu-item > .item_link,
#mega_main_menu' . $location_class . ' ul li.post_type_dropdown .mega_dropdown > li:hover > .item_link,
#mega_main_menu' . $location_class . ' ul li.post_type_dropdown .mega_dropdown > li > .item_link:hover,
#mega_main_menu' . $location_class . ' ul li.post_type_dropdown .mega_dropdown > li.current-menu-item > .item_link,
#mega_main_menu' . $location_class . ' ul li.grid_dropdown .mega_dropdown > li:hover > .item_link,
#mega_main_menu' . $location_class . ' ul li.grid_dropdown .mega_dropdown > li > .item_link:hover,
#mega_main_menu' . $location_class . ' ul li.grid_dropdown .mega_dropdown > li.current-menu-item > .item_link,
#mega_main_menu' . $location_class . ' ul li.post_type_dropdown .mega_dropdown > li:hover > .processed_image
{
	' . mmpm_css_gradient( $mmpm_theme_options[ $location_name . '_menu_dropdown_link_bg_hover'] ) . '
	color: ' . $mmpm_theme_options[ $location_name . '_menu_dropdown_link_color_hover'] . ';
}
#mega_main_menu' . $location_class . ' ul li.default_dropdown .mega_dropdown > li:hover > .item_link *,
#mega_main_menu' . $location_class . ' ul li.default_dropdown .mega_dropdown > li.current-menu-item > .item_link *,
#mega_main_menu' . $location_class . ' ul li.multicolumn_dropdown .mega_dropdown > li > .item_link:hover *,
#mega_main_menu' . $location_class . ' ul li.multicolumn_dropdown .mega_dropdown > li.current-menu-item > .item_link *,
#mega_main_menu' . $location_class . ' ul li.post_type_dropdown .mega_dropdown > li:hover > .item_link *,
#mega_main_menu' . $location_class . ' ul li.post_type_dropdown .mega_dropdown > li.current-menu-item > .item_link *,
#mega_main_menu' . $location_class . ' ul li.grid_dropdown .mega_dropdown > li:hover > .item_link *,
#mega_main_menu' . $location_class . ' ul li.grid_dropdown .mega_dropdown > li.current-menu-item > .item_link *,
#mega_main_menu' . $location_class . ' ul li.post_type_dropdown .mega_dropdown > li:hover > .processed_image > .cover > .item_link > i
{
	color: ' . $mmpm_theme_options[ $location_name . '_menu_dropdown_link_color_hover'] . ';
}
#mega_main_menu' . $location_class . ' > .menu_holder,
#mega_main_menu' . $location_class . ' > .menu_holder > .menu_inner > ul > li .post_details,
#mega_main_menu' . $location_class . ' > .menu_holder > .menu_inner > ul .mega_dropdown
{
	border-radius: ' . $mmpm_theme_options[ $location_name . '_corners_rounding'] . 'px;
}
#mega_main_menu' . $location_class . ' > .menu_holder > .menu_inner > span.nav_logo,
#mega_main_menu' . $location_class . '.direction-horizontal.include-search > .menu_holder > .menu_inner > ul > li:nth-child(200n+2) > .item_link,
#mega_main_menu' . $location_class . '.direction-horizontal.first-lvl-align-left > .menu_holder > .menu_inner > ul > li:first-child > .item_link
{
	border-radius: ' . $mmpm_theme_options[ $location_name . '_corners_rounding'] . 'px 0px 0px ' . $mmpm_theme_options[ $location_name . '_corners_rounding'] . 'px;
}
#mega_main_menu' . $location_class . '.first-lvl-align-right > ul > li:last-child > .item_link
{
	border-radius: 0px ' . $mmpm_theme_options[ $location_name . '_corners_rounding'] . 'px ' . $mmpm_theme_options[ $location_name . '_corners_rounding'] . 'px 0px;
}
#mega_main_menu' . $location_class . ' > .menu_holder > .menu_inner > ul > li.default_dropdown .mega_dropdown > li:first-child > .item_link,
#mega_main_menu' . $location_class . '.no-logo.no-search > .menu_holder > .menu_inner > ul > li:first-child > .item_link
{
	border-radius: ' . $mmpm_theme_options[ $location_name . '_corners_rounding'] . 'px ' . $mmpm_theme_options[ $location_name . '_corners_rounding'] . 'px 0px 0px;
}
#mega_main_menu' . $location_class . ' > .menu_holder > .menu_inner > ul > li.default_dropdown .mega_dropdown > li:last-child > .item_link,
#mega_main_menu' . $location_class . '.direction-vertical > .menu_holder > .menu_inner > ul > li:last-child > .item_link
{
	border-radius: 0px 0px ' . $mmpm_theme_options[ $location_name . '_corners_rounding'] . 'px ' . $mmpm_theme_options[ $location_name . '_corners_rounding'] . 'px;
}
#mega_main_menu' . $location_class . ' ul .nav_search_box #mega_main_menu_searchform,
#mega_main_menu' . $location_class . ' .multicolumn_dropdown .mega_dropdown > li > .item_link,
#mega_main_menu' . $location_class . ' .grid_dropdown .mega_dropdown > li > .item_link,
#mega_main_menu' . $location_class . ' .post_type_dropdown .mega_dropdown > li .processed_image
{
	border-radius: ' . ( $mmpm_theme_options[ $location_name . '_corners_rounding'] / 2 ) . 'px;
}
';
			$additional_styles = $mmpm_theme_options[ 'additional_styles_presets' ];
			$out .= '/* additional_styles */ ';
			if ( $additional_styles['0'] > 0 ) {
		        unset( $additional_styles['0'] );
	            foreach ( $additional_styles as $key => $value ) {
	                $out .= '
#mega_main_menu' . $location_class . ' > .menu_holder > .menu_inner > ul li.additional_style_' . $key . ' > .item_link
{
	' . mmpm_css_gradient( $value['bg_gradient'] ) . '
	color: ' . $value['text_color'] . ';
}
#mega_main_menu' . $location_class . ' > .menu_holder > .menu_inner > ul li.additional_style_' . $key . ' > .item_link > i,
#mega_main_menu' . $location_class . ' > .menu_holder > .menu_inner > ul li.additional_style_' . $key . ' > .item_link .link_text
{
	color: ' . $value['text_color'] . ';
}
#mega_main_menu' . $location_class . ' > .menu_holder > .menu_inner > ul li.additional_style_' . $key . ':hover > .item_link,
#mega_main_menu' . $location_class . ' > .menu_holder > .menu_inner > ul li.additional_style_' . $key . ' > .item_link:hover
{
	' . mmpm_css_gradient( $value['bg_gradient_hover'] ) . '
	color: ' . $value['text_color_hover'] . ';
}
#mega_main_menu' . $location_class . ' > .menu_holder > .menu_inner > ul li.additional_style_' . $key . ':hover > .item_link > i,
#mega_main_menu' . $location_class . ' > .menu_holder > .menu_inner > ul li.additional_style_' . $key . ':hover > .item_link .link_text
{
	color: ' . $value['text_color_hover'] . ';
}
';
	            }
			}
		}
	}
$out .= '/* set_of_custom_icons */ ';
$set_of_custom_icons = isset( $mmpm_theme_options[ 'set_of_custom_icons' ] ) ? $mmpm_theme_options[ 'set_of_custom_icons' ] : array();
if ( is_array( $set_of_custom_icons ) && $set_of_custom_icons['0'] > 0 ) {
    unset( $set_of_custom_icons['0'] );
    foreach ( $set_of_custom_icons as $value ) {
		$icon_name = str_replace( array( '/', strrchr( $value[ 'custom_icon' ], '.' ) ), '', strrchr( $value[ 'custom_icon' ], '/' ) );
        $out .= '
i.ci-icon-' . $icon_name . ':before
{
	background-image: url(' . $value[ 'custom_icon' ] . ');
}
';
    }
}
$out .= '/* custom css */ ' . isset( $mmpm_theme_options[ 'custom_css' ] ) ? $mmpm_theme_options[ 'custom_css' ] : '';

?>